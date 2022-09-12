<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\login;
use Auth;
use Hash;
use JWTAuth;
use Exception;
use Illuminate\Support\Facades\File; 
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\Role;
use App\Models\Employee;
use App\Models\BlockList;
use App\Models\Visitor;
use App\Models\VisitorEnrty;
use App\Models\Purpose;
use App\Models\Feed;
use App\Models\FeedJson;
use App\Models\Location;
use App\Models\Client;
use App\Models\Camera;
use App\Models\Setting;
use App\Mail\sendMail;
use Illuminate\Support\Facades\Mail;
use Carbon;
use PDF;
use App;
use DB;
use Storage;
use App\Events\BroadcastingDataToUser;
use ZipArchive;


class ApiController extends Controller
{
     public function __construct() {
        $this->middleware('auth:api', ['except' => ['postLogin','storeFeeds','entryFeeds','storeFeedsManually','storeNewVisitorEntry']]);
    }

    public function postLogin(Request $request): JsonResponse{ 
        $checkUserStatus = User::where('username',$request->username)->first();
        
        if(!isset($checkUserStatus)){
            $this->code = 409;
            $this->data = [
                "status"=>"error",
                "message"=>"Username not found!!",
            ];
            return response()->json($this->data, $this->code);
        }
        else{
            if($checkUserStatus->status==1){                
                 $this->code = 409;
                $this->data = [
                "status"=>"error",
                "message"=>"User was Inactive!! Contact admin!!",
            ];
            return response()->json($this->data, $this->code);
            }
        }

        $credentials = $request->only(['username', 'password']);
        try{
            if(!$token = JWTAuth::attempt($credentials,['exp' => Carbon\Carbon::now()->addDays(7)->timestamp])){
                throw new Exception('invalid_credentials');
            }
            $user=User::select('user_id','username','location_mapped','role_id')->where('user_id','=',Auth::user()->user_id)->first();
            $location='';
            if(Auth::user()->role_id!=0){
                $location = Location::whereIn('id',explode(',',Auth::user()->location_mapped))->get();
            }else{

                $location = Location::all();

            }
            
            $role = Controller::getRoleInfoByUserId(Auth::user()->user_id);
          
            if($user){
                $this->code = 200;
                $this->data = [
                    'status' => "success",
                    'data' => [
                            'token'=>$token,
                            'user'=>$user,
                            'role'=>$role['role']->role_name,
                            'permission'=> json_decode($role['role']->role_permission),
                            'location'=>$location
                    ],
                ];
            }else{
                $this->code = 409;
                $this->data = [
                    'status' => "error",
                    'message' => 'Invalid Credentials',
                ];
            } 
        }catch(Exception $e){
            $this->data = [
                'status' => "error",
                'message' => $e->getMessage(),
            ];
            $this->code = 409;
        }catch(JWTException $e){    
            $this->data = [
                'status' => "error",
                'message' => 'Could not create token',
            ];
            $this->code = 409;
        }
        return response()->json($this->data, $this->code);
    }
    public function changePassword(Request $request){
        $update_user = User::where('user_id',$request->user_id)->first();
        if($update_user){       
            if (!Hash::check($request->current_password,$update_user->password)) {
                $this->data = [
                'status' => "error",
                'message' => 'Current password you have entered is wrong!!!!',
                ];
                $this->code = 400;
                return response()->json($this->data, $this->code);
            }   
            

            $update_user->password = Hash::make($request->new_password);
            $update_user->update();

             $this->data = [
                'status' => "success",
                'message' => 'Password Updated Successfully!!',
            ];
            $this->code = 200;
        }
        else{
            $this->data = [
                'status' => "error",
                'message' => 'User Not found for this id',
            ];
            $this->code = 400;
        }
        
        return response()->json($this->data, $this->code);
    }

    public function loggedLocation(){
        if(Auth::user()->logged_location){
            $location = Location::where('id',Auth::user()->logged_location)->first();
             $this->data = [
                'status' => "success",
                'data' => $location,
            ];
            $this->code = 200;
        }else{
           $this->data = [
                'status' => "error",
                'message' =>"No Location mapped for this user",
            ];
            $this->code = 200;  
        }
        return response()->json($this->data, $this->code);
    }

    public function storeFeeds(Request $request){

        $img_name='';
            if(json_encode($request->images) != '[]' && 1==2) {
                $img_url = json_decode(json_encode($request->images))[0]->path;
                $img_name = json_decode(json_encode($request->images))[0]->name.'_'.$request->_id;
                $img_content = file_get_contents($img_url);  
                file_put_contents(public_path('/uploads/feed_image/'.$img_name.'.jpeg'),$img_content);
            }
            else{
                $img_name = Null;  
            }
                 
       date_default_timezone_set("Asia/Singapore"); 
    // Store feeds as Data
        $store_feed = new Feed();
        $store_feed->feed_id = $request->feedId;
        $store_feed->feed_name = $request->feedName;
        $store_feed->images = $img_name;
        $store_feed->license_plate_number = $request->license_plate_number;
        $store_feed->location_id = $request->locationId;
        $store_feed->location_name = $request->locationName;
        $store_feed->object_classification = $request->object_classification;
        $store_feed->time = $request->time;
        $store_feed->date_time = date('Y-m-d H:i:s',$request->time/1000);
        $store_feed->time_zone = $request->timezone;
        $store_feed->ui_type = $request->uiType;
        $store_feed->type = $request->type;
        $store_feed->from_host = $request->from_host;
        $store_feed->from_host_ip = $request->from_host_ip;
        $store_feed->auth_type = $request->auth_type;
        $store_feed->auth_params_addTo =$request->auth_params_addTo;
        $store_feed->_id =$request->_id;
        $store_feed->clips = Null;
        $store_feed->save();

    // Store feeds as JSON
        $store_json = new FeedJson();
        $store_json->feed_id = $request->feedId;
        $store_json->json = json_encode($request->all());
        $store_json->save();

         $this->data = [
                'status' => "success",
                'message' => 'Feeds has been stored successfully!!',
            ];
            $this->code = 200;
        
        // Auto Exit Entry
        if($request->license_plate_number!=Null && $request->feedName =='Exit Camera'){
            $currentFeed = Feed::orderBy('Created_at','DESC')->first();
           
            
            $matched_entry = VisitorEnrty::where('location_id',$request->locationId)->where('vehicle_no',$request->license_plate_number)->where('out_time',Null)->where('exit_feed',Null)->first();
           
            
            if($matched_entry){
                
                // Auto Update Exit Feed Id to Entry
                date_default_timezone_set("Asia/Singapore"); 
             
                $matched_entry->out_time = date('Y-m-d H:i:s');
                $matched_entry->exit_feed = $currentFeed->id;
                $matched_entry->update();

                // Auto Map Entry Id to Feed
                $update_feed = Feed::where('id',$currentFeed->id)->first();
                $update_feed->mapped_to_entry = $matched_entry->id;
                $update_feed->update();
            }
        }

        return response()->json($this->data, $this->code);
    }

    public function storeFeedsManually(Request $request){
       $get_client = Location::where('location_id',$request->locationId)->first();
       $get_feedJson = Client::where('id',$get_client->client_id)->first();
       $feed_json = json_decode($get_feedJson->feed_json);

        $img_name='';
        if(json_encode($request->post($feed_json->images)) != '[]' && 1==2) {
            $img_url = json_decode(json_encode($request->post($feed_json->images)))[0]->path;
            $img_name = json_decode(json_encode($request->post($feed_json->images)))[0]->name.'_'.$request->_id;
            $img_content = file_get_contents($img_url);  
            file_put_contents(public_path('/uploads/feed_image/'.$img_name.'.jpeg'),$img_content);
        }
        else{
            $img_name = Null;  
        }          
       date_default_timezone_set("Asia/Singapore"); 
    // Store feeds as Data
        $store_feed = new Feed();
        $store_feed->feed_id = $request->post($feed_json->feed_id);
        $store_feed->feed_name = $request->post($feed_json->feed_name);
        $store_feed->images = $img_name;
        $store_feed->date_time = date('Y-m-d H:i:s',$request->time/1000);
        $store_feed->time = $request->time;
        $store_feed->license_plate_number = $request->post($feed_json->license_plate_number);
        $store_feed->location_id = $request->post($feed_json->location_id);
        $store_feed->location_name = $request->post($feed_json->location_name);
        $store_feed->type = $request->post($feed_json->type);
        $store_feed->time_zone = $request->post($feed_json->timezone);
        $store_feed->ui_type = $request->post($feed_json->ui_type);
        
        $store_feed->object_classification = $request->object_classification;
        $store_feed->from_host = $request->from_host;
        $store_feed->from_host_ip = $request->from_host_ip;
        $store_feed->auth_type = $request->auth_type;
        $store_feed->auth_params_addTo =$request->auth_params_addTo;
        $store_feed->_id =$request->_id;
        $store_feed->clips = Null;
        $store_feed->save();

    // Store feeds as JSON
        $store_json = new FeedJson();
        $store_json->feed_id = $request->post($feed_json->feed_id);
        $store_json->json = json_encode($request->all());
        $store_json->save();

         $this->data = [
                'status' => "success",
                'message' => 'Feeds has been stored successfully!!',
            ];
            $this->code = 200;
        
        // Auto Exit Entry
        if($request->post($feed_json->license_plate_number)!=Null && $request->post($feed_json->feed_name) =='Exit Camera'){
            $currentFeed = Feed::orderBy('Created_at','DESC')->first();
           
            
            $matched_entry = VisitorEnrty::where('location_id',$request->post($feed_json->location_id))->where('vehicle_no',$request->post($feed_json->license_plate_number))->where('out_time',Null)->where('exit_feed',Null)->first();
           
            
            if($matched_entry){
                
                // Auto Update Exit Feed Id to Entry
                date_default_timezone_set("Asia/Singapore"); 
             
                $matched_entry->out_time = date('Y-m-d H:i:s');
                $matched_entry->exit_feed = $currentFeed->id;
                $matched_entry->update();

                // Auto Map Entry Id to Feed
                $update_feed = Feed::where('id',$currentFeed->id)->first();
                $update_feed->mapped_to_entry = $matched_entry->id;
                $update_feed->update();
            }
        }

        return response()->json($this->data, $this->code);
    }

    public function getProfile(){
        print_r(Auth::user());
        exit;
    }

    public function viewRole(){

        $roles = Role::where('is_deleted',0)->where('id','!=',0)->get();
        $this->code = 200;
        $this->data = ['status' => "success",'roles'=>$roles];

        return response()->json($this->data,$this->code);
    }

    public function storeRole(Request $request){
       
        $store = new Role();
        $store->role_name = $request->role_name;
        $store->role_permission = $request->role_permission;
        $store->total_in_hours = $request->total_in_hour;
        $store->save();
        if($store){
            $this->code = 200;
            $this->data = ['status' => "success"];
        }
            return response()->json($this->data, $this->code);
    }

    public function viewUser(){

        // $users = User::where('is_deleted',0)->get();
        if(Auth::user()->role_id==0){
            $users =  User::join('employee', 'employee.user_id', '=', 'login.user_id')
                    ->where('role_id','!=',0)
                    ->where('login.is_deleted','!=',1)
                    ->join('roles', 'roles.id', '=', 'login.role_id')->get();
        }
        else{
            $clients = explode(',',Auth::user()->client_id);
            $users =  User::join('employee', 'employee.user_id', '=', 'login.user_id')
                    ->whereIn('client_id',$clients)
                    ->where('role_id','!=',0)
                    ->where('login.is_deleted','!=',1)
                    ->join('roles', 'roles.id', '=', 'login.role_id')->get();
        }

    
        $this->code = 200;
        $this->data = ['status' => "success",'user'=>$users];
        return response()->json($this->data,$this->code);
    }

    public function storeAdmin(Request $request){

      
        $check_username = User::where('username',$request->username)->first();
            if(isset($check_username)){
                $this->data = [
                    'status' => "error",
                    'message' => 'username is already taken!!Try diffeent',
                ];
                $this->code = 409;
                return response()->json($this->data,$this->code);
            }
            if($request->phone != Null){
                $check_mobile = Employee::where('phone',$request->phone)->first();            
                if(isset($check_mobile)){
                    $this->data = [
                        'status' => "error",
                        'message' => 'Mobile Number is already taken!!Try diffeent',
                    ];
                    $this->code = 409;
                    return response()->json($this->data,$this->code);
                }
            }
            if($request->email != Null){
                $check_email = Employee::where('email',$request->email)->first();
                if(isset($check_email)){
                    $this->data = [
                        'status' => "error",
                        'message' => 'Email ID is already taken!!Try diffeent',
                    ];
                    $this->code = 409;
                    return response()->json($this->data,$this->code);
                }
            }
                $explode_client = explode(',',$request->client_id);
                $getLocation = Location::whereIn('client_id',$explode_client)->get();
                $array = [];
                foreach($getLocation as $data){
                    array_push($array,$data->id);
                }
                $location_mapped = implode(', ', $array);         
            // Insert in User table
            $stor_user = new User();
            $stor_user->username = $request->username;
            $stor_user->password = Hash::make($request->password);
            $stor_user->location_mapped = $location_mapped;
            $stor_user->client_id = $request->client_id;
            $stor_user->status = '0';
            $stor_user->created_by = Auth::user()->user_id;
            $stor_user->updated_by = Auth::user()->user_id;
            $stor_user->role_id = '1';
            $stor_user->save();

             // Upload Photo            
            $file_name = Null;  
            if ($request->hasFile('photo')) {      
                $file_name = date('Y_m_d_H_i_s').'_'.$request->photo->getClientOriginalName();          
                $savepath = public_path('/uploads/profile_pic');
                $request->photo->move($savepath,$file_name);
            }

            $getUser_id=User::where('username',$request->username)->select('user_id')->first();
            // Insert in Employee table
            $store_employee = new Employee(); 
            $store_employee->user_id = $getUser_id->user_id;
            $store_employee->first_name = $request->first_name;
            $store_employee->last_name = $request->last_name;
            $store_employee->email  = $request->email;
            $store_employee->photo = $file_name;
            $store_employee->phone = $request->phone;
            $store_employee->is_deleted = 0;
            $store_employee->save();

            // Insert Admin to client table
            $getLatestAdmin = User::orderBy('Created_at','DESC')->first();
            foreach(explode(',',$request->client_id) as $data){
                $update = Client::where('id',$data)->first();
                $update->admin_id = $getLatestAdmin->user_id;
                $update->update();
            }
            $details = [
            'title' => 'Greeting from Visitor Management',
            'body' => 'Welcome to visitor management, Happy to join us!! Your Credentials is given below, you may change your password once you login!!' ,
            'username'=>$stor_user->username,
            'password'=>$request->password,
            ];
            
            if($request->email){
                 Mail::to($request->email)->send(new sendMail($details));
            }   
           
            $this->data = [
                'message'=>'Admin Added Successfully!!',
                'status'=>'success',
            ];
            $this->code = 200;

        return response()->json($this->data,$this->code);
    }

    public function storeUser(Request $request){
       
        $check_username = User::where('username',$request->username)->first();
            if(isset($check_username)){
                $this->data = [
                    'status' => "error",
                    'message' => 'username is already taken!!Try diffeent',
                ];
                $this->code = 409;
                return response()->json($this->data,$this->code);
            }

            if($request->phone != Null){
                $check_mobile = Employee::where('phone',$request->phone)->first();            
                if(isset($check_mobile)){
                    $this->data = [
                        'status' => "error",
                        'message' => 'Mobile Number is already taken!!Try diffeent',
                    ];
                    $this->code = 409;
                    return response()->json($this->data,$this->code);
                }
            }
            if($request->email != Null){
                $check_email = Employee::where('email',$request->email)->first();
                if(isset($check_email)){
                    $this->data = [
                        'status' => "error",
                        'message' => 'Email ID is already taken!!Try diffeent',
                    ];
                    $this->code = 409;
                    return response()->json($this->data,$this->code);
                }
            }
            // Location mapped to client id
            $getCLient = Location::whereIn('id',explode(',',$request->location_mapped))->get();
            
            $array = [];
            foreach($getCLient as $data){
                    array_push($array,$data->client_id);
                }
                $client_mapped = implode(', ', $array); 
            
            // Insert in User table
            $stor_user = new User();
            $stor_user->username = $request->username;
            $stor_user->password = Hash::make($request->password);
            $stor_user->client_id = $client_mapped;
            $stor_user->created_by = Auth::user()->user_id;
            $stor_user->updated_by = Auth::user()->user_id;
            $stor_user->status = '0';
            $stor_user->site_code = $request->site_code;
            $stor_user->location_mapped = $request->location_mapped;
            $stor_user->role_id = $request->role_id;
            $stor_user->save();

            // Upload Photo            
            $file_name = Null;  
            if ($request->hasFile('photo')) {      
                $file_name = date('Y_m_d_H_i_s').'_'.$request->photo->getClientOriginalName();          
                $savepath = public_path('/uploads/profile_pic');
                $request->photo->move($savepath,$file_name);
            }

            $getUser_id=User::where('username',$request->username)->select('user_id')->first();
            // Insert in Employee table
            $store_employee = new Employee(); 
            $store_employee->user_id = $getUser_id->user_id;
            $store_employee->first_name = $request->first_name;
            $store_employee->last_name = $request->last_name;
            $store_employee->email  = $request->email;
            $store_employee->photo = $file_name;
            $store_employee->phone = $request->phone;
            $store_employee->is_deleted = 0;
            $store_employee->save();
            $details = [
            'title' => 'Greeting from Visitor Management',
            'body' => 'Welcome to visitor management, Happy to join us!! Your Credentials is given belo, you may change your password once you login!!' ,
            'username'=>$stor_user->username,
            'password'=>$request->password,
            ];
            if($request->email){
                 Mail::to($request->email)->send(new sendMail($details));
            }   

            $this->data = [
                'message'=>'User Added Successfully!!',
                'status'=>'success',
            ];
            $this->code = 200;

        return response()->json($this->data,$this->code);
    }

    public function updateUser(Request $request){
        
            if($request->phone != Null){
                $check_mobile = Employee::where('user_id','!=',$request->user_id)->where('phone',$request->phone)->first();            
            if(isset($check_mobile)){
                    $this->data = [
                        'status' => "error",
                        'message' => 'Mobile Number is already taken!!Try diffeent',
                    ];
                    $this->code = 409;
                    return response()->json($this->data,$this->code);
                }
            }
            if($request->email != Null){
                $check_email = Employee::where('user_id','!=',$request->user_id)->where('email',$request->email)->first();
                if(isset($check_email)){
                    $this->data = [
                        'status' => "error",
                        'message' => 'Email ID is already taken!!Try diffeent',
                    ];
                    $this->code = 409;
                    return response()->json($this->data,$this->code);
                }
            }
        $allow = 0;
        if(Auth::user()->role_id==2){
            if(Auth::user()->user_id != $request->user_id){
                $allow = 1;
                $this->data = [
                        'status' => "error",
                        'message' => 'You are unable to edit other user details',
                    ];
                    $this->code = 409;
                    return response()->json($this->data,$this->code);
            }
            else{
                  $allow = 0;
            }
        }

        if($allow==0){
             $getCLient = Location::whereIn('id',explode(',',$request->location_mapped))->get();
                $array = [];
                foreach($getCLient as $data){
                        array_push($array,$data->client_id);
                    }
                    $client_mapped = implode(', ', $array); 

            // Insert in User table
                $stor_user = User::where('user_id',$request->user_id)->first();
                //$stor_user->password = Hash::make($request->password);
                $stor_user->updated_by = Auth::user()->user_id;
                $stor_user->site_code = $request->site_code;
                $stor_user->location_mapped = $request->location_mapped;
                $stor_user->client_id = $client_mapped;
                $stor_user->role_id = $request->role_id;
                $stor_user->update();

                // Upload Photo            
                $file_name = Null;           
                if ($request->hasFile('photo')) {
                    $file_name = date('Y_m_d_H_i_s').'_'.$request->photo->getClientOriginalName();                   
                    $savepath = public_path('/uploads/profile_pic');
                    $request->photo->move($savepath,$file_name);
                }

                // Insert in Employee table
                $store_employee = Employee::where('user_id',$request->user_id)->first(); 
                $store_employee->user_id = $request->user_id;
                $store_employee->first_name = $request->first_name;
                $store_employee->last_name = $request->last_name;
                $store_employee->email  = $request->email;
                $store_employee->photo = $file_name;
                $store_employee->phone = $request->phone;
                $store_employee->update();
                
                $this->data = [
                'message'=>'User Updated Successfully!!',
                'status'=>'success',
                ];
                $this->code = 200;

                return response()->json($this->data,$this->code);
            }
            
    }

    public function userStatus($id){
        $getStatus = User::where('user_id',$id)->select('status')->first();

        
        if($getStatus->status==0){
            $update = User::where('user_id',$id)->first();
            $update->status = 1;
            $update->update();

            $result = "User was Inactive!!"; 
        }
        else if($getStatus->status==1){
            $update = User::where('user_id',$id)->first();
            $update->status = 0;
            $update->update();

            $result = "User was Active!!"; 
        }
        

         $this->data = [
                'message'=>$result,
                'status'=>'success',
            ];
            $this->code = 200;

        return response()->json($this->data,$this->code);

    }

    public function deleteUser($user_id){
        $destroy_user = User::where('user_id',$user_id)->first();
        $destroy_user->delete();
        $destroy_employee = Employee::where('user_id',$user_id)->first();
        $destroy_employee->delete();

        $this->data= [
        "message"=>"User Deleted Successfully!!",
        "status"=>"success",
        ];
        $this->code = 200;

        return response()->json($this->data,$this->code);
    }

    public function updateRole(Request $request){
 
        $update = Role::where('id',$request->role_id)->first();
        $update->role_name = $request->role_name;
        $update->role_permission = $request->role_permission;
        $update->total_in_hours = $request->total_in_hour;
        $update->update();

        $this->data= [
        "message"=>"Role Updated Successfully!!",
        "status"=>"success",
        ];
        $this->code = 200;

        return response()->json($this->data,$this->code);
    }

    public function deleteRole($role_id){
        $destroy = Role::where('id',$role_id)->first();
        $destroy->is_deleted = '1';
        $destroy->update();

        $this->data= [
        "message"=>"Role Deleted Successfully!!",
        "status"=>"success",
        ];
        $this->code = 200;

        return response()->json($this->data,$this->code);
    }

    public function viewPurpose(){
        $purpose = Purpose::where('is_deleted',0)->get();

         $this->data= [
            "data"=>$purpose,
            "status"=>"success",
        ];
        $this->code = 200;

        return response()->json($this->data,$this->code);
    }

    public function storePurpose(Request $request){
        
        $store = new Purpose;
        $store->purpose = $request->purpose_name;
        $store->save();

         $this->data= [
            "message"=>"Purpose Added Successfully!!",
            "status"=>"success",
        ];
        $this->code = 200;
        return response()->json($this->data,$this->code);
    }

    public function viewVisitor(){
        
        echo Auth::user()->logged_location;
        exit;
       
    }

    public function storeNewVisitorEntry(Request $request){
        \Log::info($request->all());

        $checkDuplication = Visitor::Where('mobile',$request->mobile_no)->first();

        if(!isset($checkDuplication)){
            $store = new Visitor;
            $store->visitor_name = $request->name;
            $store->email = $request->email;
            $store->mobile = $request->mobile_no;              
            //$store->created_by = Auth::user()->user_id;
            $store->save();
        }else{
            $update_name = Visitor::where('mobile',$request->mobile_no)->select('visitor_id')->first();
            $update_name->visitor_name = $request->name;
            $update_name->email = $request->email;
            $update_name->update();
        }

    // Store Visitor
        $getVisitorsId = Visitor::where('mobile',$request->mobile_no)->select('visitor_id')->first();
    
    // Store Vistor Entry
        date_default_timezone_set("Asia/Singapore");  
        $store_entry = new VisitorEnrty;
        $store_entry->visitor_id = $getVisitorsId->visitor_id;
        $store_entry->in_time = date('Y-m-d H:i:s');
        $store_entry->location_id = $request->location_id;
        $store_entry->out_time = $request->out_time;
        $store_entry->ic_number = $request->ic_number;
        $store_entry->entry_feed = $request->entry_feed;
        $store_entry->exit_feed = $request->exit_feed;
        $store_entry->vehicle_no = $request->vehicle_no;
        $store_entry->unit_no = $request->unit_no;
        $store_entry->contact_person = $request->contact_person;
        $store_entry->person_count = $request->no_of_person;
        $store_entry->visit_reason = $request->purpose_visit;
        $store_entry->delay_reason = $request->delay_reason;
        //$store_entry->created_by = Auth::user()->user_id;
        //$store_entry->updated_by = Auth::user()->user_id;
        $store_entry->save();

        $getlatesVisitorEntry = VisitorEnrty::orderBy('Created_at','DESC')->first();
       
    // Feed Mapped Flag
        $store_map = Feed::where('id',$request->entry_feed)->first();
        $store_map->mapped_to_entry = $getlatesVisitorEntry->id;
        $store_map->update();


         $this->data= [
            "message"=>"Visitor Added Successfully!!",
            "status"=>"success",
        ];
        $this->code = 200;
        
        return response()->json($this->data,$this->code);
    }

    public function storeExistVisitorEntry(Request $request){
        date_default_timezone_set("Asia/Calcutta");  
        $store_entry = new VisitorEnrty;
        $store_entry->visitor_id = $request->visitor_id;
        $store_entry->location_id = $request->location_id;
        $store_entry->in_time = date('Y-m-d H:i:s');
        $store_entry->out_time = $request->out_time;
        $store_entry->ic_number = $request->ic_number;
        $store_entry->entry_feed = $request->entry_feed;
        $store_entry->exit_feed = $request->exit_feed;
        $store_entry->contact_person = $request->contact_person;
        $store_entry->person_count = $request->no_of_person;
        $store_entry->visit_reason = $request->purpose_visit;
        $store_entry->delay_reason = $request->delay_reason;
        //$store_entry->created_by = Auth::user()->user_id;
        //$store_entry->updated_by = Auth::user()->user_id;
        $store_entry->save();

        $getlatesVisitorEntry = VisitorEnrty::orderBy('Created_at','DESC')->first();
        // Feed Mapped Flag
        $store_map = Feed::where('id',$request->entry_feed)->first();
        $store_map->mapped_to_entry = $getlatesVisitorEntry->id;
        $store_map->update();

        $this->data= [
            "message"=>"Visitor Added Successfully!!",
            "status"=>"success",
        ];
        $this->code = 200;
        
        return response()->json($this->data,$this->code);
    }

    public function deleteVisitorEntry(Request $request){

        $delete_entry = VisitorEnrty::where('id',$request->entry_id)->first();
        $delete_entry->delete();

         $this->data= [
            "message"=>"Visitor Entry Deletd Successfully!!",
            "status"=>"success",
        ];
        $this->code = 200;        
        return response()->json($this->data,$this->code);
    }

    
    public function getEntryReport(Request $request){
        if(!isset($request->date)){
            date_default_timezone_set("Asia/Singapore");
            $from = date('Y-m-d 00:00:00');
            $to = date('Y-m-d H:i:s');
                if($request->entry_type==1){
                    $getReport = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')->whereBetween('in_time', [$from, $to])->where('in_time','!=',null)->where('out_time','=',null)->where('is_deleted',0)->where('location_id',$request->location_id)->paginate(10)->appends(request()->query());   
                }
                elseif ($request->entry_type==2) {
                    $getReport = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')->whereBetween('in_time', [$from, $to])->where('in_time','!=',null)->where('out_time','!=',null)->where('is_deleted',0)->where('location_id',$request->location_id)->paginate(10)->appends(request()->query());  
                }
                else{
                $getReport = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')->whereBetween('in_time', [$from, $to])->where('is_deleted',0)->where('location_id',$request->location_id)->paginate(10)->appends(request()->query());
                }
        }
        else{   
                $from = $request->date.' '.$request->time_from;
                $to = $request->date_to.' '.$request->time_to;           
                if($request->feed_type == 'license_plate'){
                    if(!isset($request->search)){
                        if($request->entry_type==1){
                        $getReport = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')->whereBetween('in_time', [$from, $to])->where('in_time','!=',null)->where('out_time','=',null)->where('is_deleted',0)->where('location_id',$request->location_id)->paginate(10)->appends(request()->query());   
                        }
                        elseif ($request->entry_type==2) {
                            $getReport = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')->whereBetween('in_time', [$from, $to])->where('in_time','!=',null)->where('out_time','!=',null)->where('is_deleted',0)->where('location_id',$request->location_id)->paginate(10)->appends(request()->query());  
                        }
                        else{
                            $getReport = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')->whereBetween('in_time', [$from, $to])->where('is_deleted',0)->where('location_id',$request->location_id)->paginate(10)->appends(request()->query());
                        }
                    }
                    else{
                        $search = $request->search;
                        if($request->entry_type==1){
                            $getEntry = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')
                            ->leftjoin('visitors', 'entry.visitor_id', '=', 'visitors.visitor_id')
                            ->leftjoin('purpose', 'entry.visit_reason', '=', 'purpose.purpose_id')
                            ->whereBetween('in_time', [$from, $to])
                            ->where('in_time','!=',null)
                            ->where('out_time','=',null)
                            ->where('location_id',$request->location_id)
                            ;
                        }
                        elseif($request->entry_type==2){                           
                            $getEntry = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')
                            ->leftjoin('visitors', 'entry.visitor_id', '=', 'visitors.visitor_id')
                            ->leftjoin('purpose', 'entry.visit_reason', '=', 'purpose.purpose_id')
                            ->whereBetween('in_time', [$from, $to])
                            ->where('in_time','!=',null)
                            ->where('out_time','!=',null)
                            ->where('location_id',$request->location_id)
                            ;
                        }else{
                            $getEntry = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')
                            ->leftjoin('visitors', 'entry.visitor_id', '=', 'visitors.visitor_id')
                            ->leftjoin('purpose', 'entry.visit_reason', '=', 'purpose.purpose_id')
                            ->whereBetween('in_time', [$from, $to])
                            ->where('location_id',$request->location_id)
                            ;
                        }

                        $getReport = $getEntry->where(function ($q) use ($search) {
                            $q->orWhere('visitors.mobile', 'LIKE', '%' . $search . '%')
                                ->orWhere('visitors.visitor_name', 'LIKE', '%' . $search . '%')
                                ->orWhere('visitors.email', 'LIKE', '%' . $search . '%')
                                ->orWhere('entry.contact_person', 'LIKE', '%' . $search . '%')
                                ->orWhere('entry.unit_no', 'LIKE', '%' . $search . '%')
                                ->orWhere('purpose.purpose', 'LIKE', '%' . $search . '%')
                                ->orWhere('entry.vehicle_no', 'LIKE', '%' . $search . '%');
                            })->paginate(10)->appends(request()->query());
                    }
                }
            else{
                    $data = Feed::where('type',$request->feed_type)->where('location_id',$request->location_id)->whereBetween('Created_at',[$from, $to])->get(); 
                      
                    $getReport=[];
                    foreach($data as $feeds){
                        $temp['id']='';
                        if($feeds->type =='video_loss'){
                              $temp['feed_type']=2;
                        }
                        elseif($feeds->type =='traffic'){
                            $temp['feed_type']=3;
                        }   
                        $temp['visitor_id']='';
                        $temp['in_time']='';
                        $temp['out_time']='';
                        $temp['ic_number']='';
                        $temp['contact_person']='';
                        $temp['role']='';
                        $temp['person_count']='';
                        $temp['visit_reason']='';
                        $temp['delay_reason']='';
                        $temp['created_at']='';
                        $temp['updated_at']='';
                        $temp['updated_by']='';
                        $temp['created_by']='';
                        $temp['entry_feed']=$feeds;   
                        $temp['exit_feed']=Null;
                        $temp['is_deleted']='';
                        $temp['vehicle_no']='';
                        $temp['get_visitor']=[];

                        $getReport[]=$temp;
                    }
                }
        } 


            $this->data= [
                "data"=>$getReport,
                "status"=>"success",
            ];
            $this->code = 200;        
            return response()->json($this->data,$this->code);
    }

     public function downloadPDF(Request $request){
        $page='reportPdf';
            if(!isset($request->date)){
                date_default_timezone_set("Asia/Singapore");
                $from = date('Y-m-d 00:00:00');
                $to = date('Y-m-d H:i:s');
                
                if($request->entry_type==1){
                    $getReport = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')->whereBetween('in_time', [$from, $to])->where('in_time','!=',null)->where('out_time','=',null)->where('is_deleted',0)->where('location_id',$request->location_id)->get();   
                }
                elseif ($request->entry_type==2) {
                    $getReport = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')->whereBetween('in_time', [$from, $to])->where('in_time','!=',null)->where('out_time','!=',null)->where('is_deleted',0)->where('location_id',$request->location_id)->get();  
                }
                else{
                $getReport = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')->whereBetween('in_time', [$from, $to])->where('is_deleted',0)->where('location_id',$request->location_id)->get();
                }
            }
            else{
                    $from = $request->date.' '.$request->time_from;
                    $to = $request->date_to.' '.$request->time_to;
                    if($request->feed_type == 'license_plate'){      
                        if(!isset($request->search)){
                           if($request->entry_type==1){
                            $getReport = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')->whereBetween('in_time', [$from, $to])->where('in_time','!=',null)->where('out_time','=',null)->where('is_deleted',0)->where('location_id',$request->location_id)->get();   
                            }
                            elseif ($request->entry_type==2) {
                                $getReport = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')->whereBetween('in_time', [$from, $to])->where('in_time','!=',null)->where('out_time','!=',null)->where('is_deleted',0)->where('location_id',$request->location_id)->get();  
                            }
                            else{
                            $getReport = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')->whereBetween('in_time', [$from, $to])->where('is_deleted',0)->where('location_id',$request->location_id)->get();
                            }                           
                        }
                        else{
                            $search = $request->search;
                            if($request->entry_type==1){
                            $getEntry = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')
                            ->leftjoin('visitors', 'entry.visitor_id', '=', 'visitors.visitor_id')
                            ->leftjoin('purpose', 'entry.visit_reason', '=', 'purpose.purpose_id')
                            ->whereBetween('in_time', [$from, $to])
                            ->where('in_time','!=',null)
                            ->where('out_time','=',null)
                            ->where('location_id',$request->location_id);
                            }
                            elseif($request->entry_type==2){                               
                                $getEntry = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')
                                ->leftjoin('visitors', 'entry.visitor_id', '=', 'visitors.visitor_id')
                                ->leftjoin('purpose', 'entry.visit_reason', '=', 'purpose.purpose_id')
                                ->whereBetween('in_time', [$from, $to])
                                ->where('in_time','!=',null)
                                ->where('out_time','!=',null)
                                ->where('location_id',$request->location_id);
                            }else{
                                $getEntry = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')
                                ->leftjoin('visitors', 'entry.visitor_id', '=', 'visitors.visitor_id')
                                ->leftjoin('purpose', 'entry.visit_reason', '=', 'purpose.purpose_id')
                                ->whereBetween('in_time', [$from, $to])
                                ->where('location_id',$request->location_id);
                            }   
                            $getReport = $getEntry->where(function ($q) use ($search) {
                            $q->orWhere('visitors.mobile', 'LIKE', '%' . $search . '%')
                                ->orWhere('visitors.visitor_name', 'LIKE', '%' . $search . '%')
                                ->orWhere('visitors.email', 'LIKE', '%' . $search . '%')
                                ->orWhere('entry.contact_person', 'LIKE', '%' . $search . '%')
                                ->orWhere('entry.unit_no', 'LIKE', '%' . $search . '%')
                                ->orWhere('purpose.purpose', 'LIKE', '%' . $search . '%')
                                ->orWhere('entry.vehicle_no', 'LIKE', '%' . $search . '%');
                            })->get();     
                        }    
                    }
                    else{
                       $data = Feed::where('type',$request->feed_type)->where('location_id',$request->location_id)->whereBetween('Created_at',[$from, $to])->get(); 

                       $getReport=[];
                        foreach($data as $feeds){
                            $temp['id'] = '';
                            $temp['visitor_id'] = '';
                            $temp['in_time'] = '';
                            $temp['out_time'] = '';
                            $temp['ic_number'] = '';
                            $temp['contact_person'] = '';
                            $temp['role'] = '';
                            $temp['person_count'] = '';
                            $temp['visit_reason'] = '';
                            $temp['delay_reason'] = '';
                            $temp['created_at'] = '';
                            $temp['updated_at'] = '';
                            $temp['updated_by'] = '';
                            $temp['created_by'] = '';
                            $temp['entryFeed'] = $feeds;
                            $temp['exit_feed'] = Null;
                            $temp['is_deleted'] = '';
                            $temp['vehicle_no'] = '';
                            $temp['get_visitor'] = [];
                            $getReport[]=$temp;
                        }
                        $page='feedReport';
                    }
            } 
           
            // $this->data= [
            //     "data"=>$getReport,
            //     "status"=>"success",
            // ];
            // $this->code = 200;        
            // return response()->json($this->data,$this->code);

           $getLocation = Location::where('location_id',$request->location_id)->first();
           $html = view($page, ['entry_report'=>$getReport,'location_name'=>$getLocation->location_name])->render();
           $html = preg_replace('/>\s+</', "><", $html);
           $pdf = App::make('dompdf.wrapper');
           $pdf_name = 'reportPdf_'.date('Ymd_His').'.pdf';

           $invPDF = $pdf->loadHTML($html)->setPaper('a4', 'landscape')->save(public_path('/report_pdf/').$pdf_name);
           
           
           $this->code = 200;
           $this->data=[
               "status"=>"success",
               "data"=> url('/public/report_pdf').'/'.$pdf_name,
           ];
           return response()->json($this->data,$this->code);      
    }

    public function getUnmappedFeeds($location_id){
        $getFeeds = Feed::where('location_id',$location_id)->where('mapped_to_entry',0)->paginate(20);
    if(count($getFeeds)!=0){          
            $this->data = [
                'status'=>"success",
                'data'=>$getFeeds,
                
            ];
            $this->code = 200;
        }else{           
            $this->data = [
                'status'=>"error",
                'message'=>'No un mapped feeds for this location',
                
            ];
            $this->code = 400;
        }
        return response()->json($this->data,$this->code);
    }

    public function rejectFeed($feed_id){
       
        $reject_feed = Feed::where('id',$feed_id)->first();
        $reject_feed->mapped_to_entry = 2;
        $reject_feed->update();
        $this->data = [
                'status'=>"success",
                'message'=>'Feed has been Rejected!!',                
        ];
        $this->code = 200;

        return response()->json($this->data,$this->code);
    }
    public function entryFeeds($location_id){
        \Log::info($location_id);
        date_default_timezone_set("Asia/Singapore");
         $to = Date('Y-m-d H:i:s');
         $from = date("Y-m-d H:i:s", strtotime("-10 minutes"));
            
        $entryfeeds = Feed::where('location_id',$location_id)->where('feed_name','Entry Camera')->where('is_deleted',0)->where('mapped_to_entry',0)->whereBetween('Created_at',[$from,$to])->paginate(10);
    
        if(count($entryfeeds)!=0){          
                $this->data = [
                    'status'=>"success",
                    'data'=>$entryfeeds,
                    
                ];
                $this->code = 200;
            }else{           
                $this->data = [
                    'status'=>"error",
                    'message'=>'No Entry feeds found!!',
                    
                ];
                $this->code = 400;
            }
            //event(new BroadcastingDataToUser($this->data,$this->code));
            return response()->json($this->data,$this->code);
        }
        public function getNotReturnedVisitors($location_id,$type=Null){

                    if($type==Null){
                       $visitor = VisitorEnrty::with('getVisitor','visitReason','entryFeed')->where('location_id',$location_id)->where('out_time',null)->where('in_time','!=',null)->orderBy('Created_at','DESC')->paginate(20);
                    }
                    else{
                        if($type==1){
                        $visitor =  VisitorEnrty::with('getVisitor','visitReason','entryFeed')->where('entry_type',1)->where('location_id',$location_id)->where('out_time',null)->where('in_time','!=',null)->orderBy('Created_at','DESC')->paginate(20);
                        }else{
                            $visitor =  VisitorEnrty::with('getVisitor','visitReason','entryFeed')->where('location_id',$location_id)->where('out_time',null)->where('entry_type',2)->where('in_time','!=',null)->orderBy('Created_at','DESC')->paginate(20);
                        }
                    }
                
                
                   
            if($visitor){
                $this->code = 200;
                $this->data = [
                    'status'=>'success',
                    'visitors'=>$visitor,              
                ];
            }
            else{
                $this->code = 400;
                $this->data = [
                    'status'=>'error',
                    'message'=>'No entry had found'
                ];
            }
            return response()->json($this->data,$this->code);
        }

        public function searchByMobile(Request $request){
       
            $getVisitorId = Visitor::select('visitor_id')->where('mobile',$request->mobile_no)->first();
            
            if($getVisitorId){
               $getEntry = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')->where('visitor_id',$getVisitorId->visitor_id)->where('in_time','!=',Null)->where('out_time','=',Null)->where('location_id',$request->location_id)->paginate(100);
               if($getEntry){
                 $this->code = 200;
                $this->data= [
                "data"=>$getEntry,
                "status"=>"success",
                ];
               }else{
                 $this->code = 400;
                $this->data= [
                "message"=>"No Entry for this Visitor",
                "status"=>"error",
                ]; 
               } 
           }else{
            $this->code = 400;
                $this->data= [
                "message"=>"No visitor for this mobile_no",
                "status"=>"error",
                ]; 
           }
           return response()->json($this->data,$this->code);
        
        }

        public function mapUnmatchedFeeds(Request $request){
            date_default_timezone_set("Asia/Singapore");
            $updateEntry = VisitorEnrty::where('id',$request->entry_id)->first();
            $updateEntry->out_time = date('Y-m-d H:i:s');
            $updateEntry->exit_feed = $request->feed_id;
            $updateEntry->update();

            $updateFeed = Feed::where('id',$request->feed_id)->first();
            $updateFeed->mapped_to_entry = $request->entry_id;
            $updateFeed->update();

             $this->code = 200;
                $this->data = [
                    'status'=>'success',
                    'message'=>'Feed has been mapped to entry successfully!!'
                ];

            return response()->json($this->data,$this->code);
        }

        public function unMatchedInOutLicense($location_id,$searchkey){
            date_default_timezone_set('Asia/Singapore');
            $feeds=[];
            $entry_feeds=[];
            if(Auth::user()->feed_type == 'default'){
            // exit feed
            $feeds = Feed::where('location_id',$location_id)->where('feed_name','Exit Camera')
                        ->where('license_plate_number','!=',null)
                        ->select('id','license_plate_number','images')
                        ->where('mapped_to_entry',0)->whereDate('Created_at',date('Y-m-d'))->orderBy('Created_at','DESC')->get();

             // entry feed
                        
            $entry_feeds = Feed::select('id','license_plate_number','images','feed_name')->where('location_id',$location_id)->where('feed_name','Entry Camera')->whereNotNull('license_plate_number')->where('mapped_to_entry',0)->whereDate('Created_at',date('Y-m-d'))->get();
            }
            else{
            // exit feed
            $getFeedInfo = Setting::where('location_id',$location_id)->where('user_id',Auth::user()->user_id)->first();

            $feeds = Feed::where('license_plate_number','!=',null)->where('feed_id',$getFeedInfo->exit_camera)
                        ->select('id','license_plate_number','images')
                        ->where('mapped_to_entry',0)->whereDate('Created_at',date('Y-m-d'))->orderBy('Created_at','DESC')->get();

            // entry feed           
            $entry_feeds = Feed::select('id','license_plate_number','images','feed_name')->where('feed_id',$getFeedInfo->entry_camera)->whereNotNull('license_plate_number')->where('mapped_to_entry',0)->whereDate('Created_at',date('Y-m-d'))->get();
            }

// Choice 1
            $exit_temp=[];
            foreach($feeds as $data){
                $temp['id']=$data->id;
                $temp['license_plate_number']=$data->license_plate_number;
                $exit_temp[]=$temp;
            }

            $entry_temp=[];
            foreach($entry_feeds as $data){
                array_push($entry_temp,$data->license_plate_number);
            }

            // print_r($entry_temp);
            // print_r($exit_temp);
            // exit;
            // Un matched exit feed with entry feed
            $final_result=[];
            //matched
            foreach ($exit_temp as $key => $exit_license) {                
              if(!in_array($exit_license['license_plate_number'],$entry_temp)){
                array_push($final_result,$exit_license['id']);
              }
            }
           
            // get Un matched exit feed data
            if($searchkey=='0'){
               
                $result = Feed::select('id','license_plate_number','images','date_time')->where('location_id',$location_id)->whereIn('id',$final_result)->orderBy('Created_at','DESC')->limit(20)->get();
            }
            else{
               
                $unmatched_feed = Feed::select('id','license_plate_number','images','date_time')->where('location_id',$location_id)->whereIn('id',$final_result)->orderBy('Created_at','DESC');

                $result = $unmatched_feed->where(function ($q) use ($searchkey) {
                            $q->orWhere('license_plate_number', 'LIKE', '%' . $searchkey . '%');
                            })->limit(20)->get();
            }
            $this->code = 200;
            $this->data = [
                'status'=>'success',
                'data'=>$result,
            ];
            return response()->json($this->data,$this->code);
        }

        // doubt
        public function noOutTime($location_id){
            $entry = VisitorEnrty::with('entryFeed')->where('in_time','!=',Null)->where('out_time',Null)->where('location_id',$location_id)->where('entry_type','!=',2)->get();
            
            $entry_data=[];
            foreach($entry as $data){
                $temp=[];
                $temp['id'] = $data->id;
                $temp['in_time'] = $data->in_time;
                $temp['vehicle_no'] = $data->vehicle_no;
                $temp['images'] = $data->entryFeed->images.'.jpeg';
                $entry_data[]= $temp;
            }

            $this->code = 200;
                $this->data = [
                    'status'=>'success',
                    'data'=>$entry_data,
                ];
            return response()->json($this->data,$this->code);

        }

        public function outEntry($entry_id,$delay_reason){
            date_default_timezone_set('Asia/Singapore');
            $current_time = date('Y-m-d H:i:s');
            $out = VisitorEnrty::with('entryFeed','exitFeed')->where('id',$entry_id)->first();
           
            if(!$out){
                 $this->code = 409;
                    $this->data = [
                        'status'=>'error',
                        'message'=>'No vehicle no is given for this entry!!',
                    ];
                    return response()->json($this->data,$this->code);
            }
            if($out->entry_type!=2){
                $exit_feed=[];;
                $license_no = $out->vehicle_no;
                if(Auth::user()->feed_type=='DEFAULT'){
                    $exit_feed = Feed::where('feed_name','Exit Camera')->where('location_id',$out->location_id)->where('license_plate_number',$license_no)->where('mapped_to_entry',0)->first();
                }
                else{
                    $feed_id = Setting::where('user_id',Auth::user()->user_id)->where('location_id',$out->location_id)
                    ->first();        
                    
                    $exit_feed = Feed::where('feed_name','Exit Camera')->where('feed_id',$feed_id->exit_camera)->where('license_plate_number',$license_no)->where('mapped_to_entry',0)->first();   
                }

                if(!$exit_feed){
                    $out->delay_reason = $delay_reason;
                    $out->out_time = $current_time;
                    $out->update();
                }
                else{
                    $exit_feed->mapped_to_entry = $entry_id;
                    $exit_feed->update();
                    $visitor_entry = VisitorEnrty::where('id',$entry_id)->first();
                    $visitor_entry->out_time = $current_time;
                    $visitor_entry->exit_feed = $exit_feed->id;
                    $visitor_entry->delay_reason = $delay_reason;
                    $visitor_entry->update();
                }
            }
            else{
                $out->delay_reason = $delay_reason;
                $out->out_time = $current_time;
                $out->update();
            }

             $this->code = 200;
                $this->data = [
                    'status'=>'success',
                    'message'=>'Visitor has been exited successfully!!',
                ];

             return response()->json($this->data,$this->code);
        }

       

    public function walkInEntry(Request $request){ 
      
        $checkDuplication = Visitor::whereNotNull('email')->where('email',$request->email)->orWhere('mobile',$request->mobile_no)->first();

        if(!isset($checkDuplication)){
           // Store Visitor
            $store = new Visitor;
            $store->visitor_name = $request->name;
            $store->email = $request->email;
            $store->mobile = $request->mobile_no;              
            $store->created_by = Auth::user()->user_id;
            $store->save();
        }else{
            $update_name = Visitor::where('mobile',$request->mobile_no)->select('visitor_id')->first();
            $update_name->visitor_name = $request->name;
            $update_name->email = $request->email;
            $update_name->update();
        }
        $getVisitorsId = Visitor::where('mobile',$request->mobile_no)->select('visitor_id')->first();
    // Upload Photo            
            $imageName = Null;  
            if($request->image_capture){
                //$base64_str = substr($request->image_capture, strpos($request->image_capture, ",")+1);
                $image = base64_decode($request->image_capture); // decode the image
                $imageName = rand(1000, 999999).'.'.'jpg';  
                file_put_contents('public/uploads/feed_image/'.$imageName,$image);
            }
    // Store Vistor Entry  
        date_default_timezone_set("Asia/Singapore");
        $store_entry = new VisitorEnrty;
        $store_entry->visitor_id = $getVisitorsId->visitor_id;
        $store_entry->location_id = $request->location_id;
        $store_entry->vehicle_no = $request->vehicle_no;
        $store_entry->in_time = date('Y-m-d H:i:s');
        $store_entry->out_time = $request->out_time;
        $store_entry->unit_no = $request->unit_no;
        $store_entry->capture_image = $imageName;
        $store_entry->ic_number = $request->ic_number;
        $store_entry->contact_person = $request->contact_person;
        $store_entry->person_count = $request->no_of_person;
        $store_entry->visit_reason = $request->purpose_visit;
        $store_entry->delay_reason = $request->delay_reason;
        $store_entry->entry_type = 2;
        $store_entry->created_by = Auth::user()->user_id;
        $store_entry->updated_by = Auth::user()->user_id;
        $store_entry->save();

         $this->data= [
            "message"=>"Visitor Added Successfully!!",
            "status"=>"success",
        ];
        $this->code = 200;
        
        return response()->json($this->data,$this->code);
    }
     public function getVisitorRecordByMobile(Request $request){
        $blocked=0;
        $visitor_details=array();
        $getVisitorId = Visitor::where('mobile',$request->mobile_no)->first();

        if(!$getVisitorId){
              $this->code = 400;
                $this->data= [
                "message"=>'No visitor found',
                "status"=>"error",
            ];
            return response()->json($this->data,$this->code);     
        }

        $visitors_data = VisitorEnrty::with('getVisitor','visitReason')->where('visitor_id',$getVisitorId->visitor_id)->where('location_id',$request->location_id)->orderBy('Created_at','DESC')->first();

            if(!$visitors_data){
                    $this->code = 400;
                    $this->data= [
                    "message"=>'No visitor found',
                    "status"=>"success",
                 ];
                return response()->json($this->data,$this->code);
            }
          
           

            $visitor_details['name'] = $visitors_data->getVisitor->visitor_name;
            $visitor_details['phone'] = $visitors_data->getVisitor->mobile;
            $visitor_details['email'] = $visitors_data->getVisitor->email;
            $visitor_details['ic_number'] = $visitors_data->ic_number;
            $visitor_details['contact_person'] = $visitors_data->contact_person;
            $visitor_details['person_count'] = $visitors_data->person_count;
            $visitor_details['purpose_of_visit'] = $visitors_data->visitReason->purpose_id;
            $visitor_details['vehicle_no'] = $visitors_data->vehicle_no;
            $visitor_details['unit_no'] = $visitors_data->unit_no;
      
            $this->code = 200;
            $this->data= [
            "data"=>$visitor_details,
            "status"=>"success",
            ];   
        return response()->json($this->data,$this->code);
    }



    public function getVisitorRecord(Request $request){

        $blocked=0;
        $visitor_details=array();
        $visitors_data = VisitorEnrty::with('getVisitor','visitReason')->where('vehicle_no',$request->vehicle_no)->where('location_id',$request->location_id)->orderBy('Created_at','DESC')->first();
        $check_blocked = BlockList::where('vehicle_no',$request->vehicle_no)->where('location',$request->location_id)->orderBy('Created_at','DESC')->first();
        
            if($check_blocked){
                $blocked=1;
            }
            if(!$visitors_data){
                if($blocked==1){
                    $this->code = 400;
                    $this->data= [
                    "message"=>'No visitor found',
                    "status"=>"success",
                    "blocked_status"=>$blocked,
                    ];  
                }else{
                    $this->code = 400;
                    $this->data= [
                    "message"=>'No visitor found',
                    "status"=>"error",
                    "blocked_status"=>$blocked,];
                }
                return response()->json($this->data,$this->code);
            }   

            $visitor_details['name'] = $visitors_data->getVisitor->visitor_name;
            $visitor_details['phone'] = $visitors_data->getVisitor->mobile;
            $visitor_details['email'] = $visitors_data->getVisitor->email;
            $visitor_details['ic_number'] = $visitors_data->ic_number;
            $visitor_details['contact_person'] = $visitors_data->contact_person;
            $visitor_details['person_count'] = $visitors_data->person_count;
            $visitor_details['purpose_of_visit'] = $visitors_data->visitReason->purpose_id;
            $visitor_details['vehicle_no'] = $visitors_data->vehicle_no;
            $visitor_details['unit_no'] = $visitors_data->unit_no;
      
            $this->code = 200;
            $this->data= [
            "data"=>$visitor_details,
            "status"=>"success",
            "blocked_status"=>$blocked,
            ];   
        return response()->json($this->data,$this->code);
    }

    public function skipFeeds(Request $request){
        $drop = Feed::where('id',$request->feed_id)->update(['is_deleted'=>1]);
         $this->code = 200;
            $this->data= [
            "status"=>"success",
            "message"=>'Feed has been deleted!!',
            
            ];   
        return response()->json($this->data,$this->code);
    }

    //CRON 
    public function feedDelete(){

        // delete feed image from directory 
        $get_image_name = Feed::where('is_deleted',1)->get();
        foreach($get_image_name as $value){
             $image_path = public_path('/uploads/feed_image/'.$value->images.'.jpeg');
             if (File::exists($image_path)) {
                    File::delete($image_path);
                    unlink($image_path);
              }
        }

        // delete feeds from db
        $feed = Feed::where('is_deleted',1)->delete();
        $this->code = 200;
            $this->data= [
            "status"=>"success",
            "message"=>'All Feed has been deleted!!',
            
            ];   
        return response()->json($this->data,$this->code); 
    }

    public function feedImageZipping(){

        $ninty_days=date('Y-m-d', strtotime('-90 days'));
        $feed_img = Feed::where('Created_at','<',$ninty_days)->get();
        $array = array();
       
    // Getting File to zip
        foreach($feed_img as $value){
             $image_path = public_path("uploads/feed_image/".$value->images.'.jpg');
             if (File::exists($image_path)) {
                    array_push($array,$image_path);
              } 
        }
       
    // Zipping file 
        $zip = new ZipArchive;
        $zip_name = date('Y-m', strtotime('-90 days'));;
        if ($zip->open(public_path('/uploads/zipping_images/'.$zip_name.'.zip'), ZipArchive::CREATE) === TRUE){        
            foreach($array as $value){
                 $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }  
        $zip->close();
        }

    // Deleting File
        foreach($feed_img as $value){
             $image_path = public_path("uploads/feed_image/".$value->images.'.jpg');
             if (File::exists($image_path)) {
                    File::delete($image_path);
                    
              } 
        } 
        $directory =public_path('/uploads/zipping_images/'.$zip_name.'zip');
        $this->code = 200;
            $this->data= [
            "status"=>"success",
            "message"=>'All Feed has zipped to !!'.$directory,
            
            ];   
        return response()->json($this->data,$this->code); 
    }

    public function mapFeedToEntry(Request $request){
        
        $checkLicense= VisitorEnrty::where('in_time','!=',Null)->where('vehicle_no',$request->license_no)
        ->where('out_time',Null)->first();
        
        if(isset($checkLicense)){
         date_default_timezone_set("Asia/Singapore");
         $checkLicense->out_time = date('Y-m-d H:i:s');
         $checkLicense->exit_feed = $request->feed_id;
         $checkLicense->update();

         $update_feed = Feed::where('id',$request->feed_id)->first();
         $update_feed->mapped_to_entry= $checkLicense->id;
         $update_feed->update(); 
         $this->code = 200;
            $this->data= [
                "status"=>"success",
                "message"=>'Visitor Out successfully!!',
            ];  
        }
        else{
            $this->code = 200;
            $this->data= [
                "status"=>"error",
                "message"=>'Entry not matched for this license no!!',
            ];  
        }
        return response()->json($this->data,$this->code);
    }

    public function webSocket_entryFeeds($location_id){
       date_default_timezone_set("Asia/Singapore");
        $entryfeeds = Feed::where('location_id',$location_id)->where('feed_name','Entry Camera')->where('mapped_to_entry',0)->whereDate('Created_at','2022-03-01')->orderBy('Created_at','DESC')->paginate(10);

        

        if(count($entryfeeds)!=0){          
                $this->data = [
                    'status'=>"success",
                    'data'=>$entryfeeds,
                    
                ];
                $this->code = 200;
            }else{           
                $this->data = [
                    'status'=>"error",
                    'message'=>'No Entry feeds for this location',
                    
                ];
                $this->code = 400;
            }
            event(new BroadcastingDataToUser($this->data,$this->code));
            //return response()->json($this->data,$this->code);
    }

    public function wildCardSearch($key,$location_id){
     
      $license_no = array();   
            $visitors = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')
            ->leftjoin('visitors', 'entry.visitor_id', '=', 'visitors.visitor_id')
            ->leftjoin('purpose', 'entry.visit_reason', '=', 'purpose.purpose_id')
            ->Where('visitors.mobile', 'LIKE', '%' . $key . '%')
            ->orWhere('visitors.visitor_name', 'LIKE', '%' . $key . '%')
            ->orWhere('visitors.email', 'LIKE', '%' . $key . '%')
            ->orWhere('entry.contact_person', 'LIKE', '%' . $key . '%')
            ->orWhere('entry.unit_no', 'LIKE', '%' . $key . '%')
            ->orWhere('purpose.purpose', 'LIKE', '%' . $key . '%')
            ->orWhere('entry.vehicle_no', 'LIKE', '%' . $key . '%')
            ->where('entry.location_id','=',$location_id)->paginate(20);
            
            if(count($visitors)!=0){
                $this->code = 200;
                $this->data = [
                    'status'=>'success',
                    'visitors'=>$visitors,
                                      
                ];
            }
            else{
                $this->code = 400;
                $this->data = [
                    'status'=>'error',
                    'message'=>'No entry had found'
                ];
            }
            return response()->json($this->data,$this->code);
    }

    public function storeClient(Request $request){
      
        if(Auth::user()->role_id==0){
            $check_duplication = Client::where('token',$request->token)->first();
            if($check_duplication){
                $this->code = 400;
                $this->data = [
                        'status'=>'error',
                        'messages'=>'Token is already taken!!',
                                          
                ];
                return response()->json($this->data,$this->code); 
            }

            $store = new Client();
            $store->client_name = $request->client_name;
            $store->address = $request->address;
            $store->email = $request->client_email;
            $store->mobile = $request->client_mobile;
            $store->token = $request->token;
            $store->feed_url = $request->feed_url;
            $store->push_pull = $request->push_pull;
            $store->user_name = $request->user_name;
            $store->password = $request->password;
            $store->feed_json = $request->feed_json;
            $store->save();
            if($store->save()){
                $this->code = 200;
                $this->data = [
                        'status'=>'success',
                        'messages'=>'Clients has been stored successfully!!',
                                          
                ];
            }
           $getCLient = Client::orderBy('id','DESC')->first();            
           return redirect()->route('store_location',['token'=> $getCLient->token,'client_id'=>$getCLient->id]);
        }else{
          $this->code = 400;
                $this->data = [
                        'status'=>'error',
                        'messages'=>'Sorry you must be a super admin to access this page!!',
                                          
                ];  
        }
       return response()->json($this->data,$this->code); 
    }

    public function updateClient(Request $request){
        if(Auth::user()->role_id==0){
            $update = Client::where('id',$request->client_id)->first();
            $update->client_name = $request->client_name;
            $update->address = $request->address;
            $update->token = $request->token;
            $update->update();
            if($update->update()){
               $this->code = 200;
                $this->data = [
                        'status'=>'success',
                        'messages'=>'Clients has been Updated successfully!!',
                                          
                ];  
            }
           return redirect()->route('store_location',['token'=> $request->token,'client_id'=>$request->client_id]);
           
        }else{
            $this->code = 400;
                $this->data = [
                        'status'=>'error',
                        'messages'=>'Sorry you must be a super admin to access this page!!',
                                          
                ];
        }
         return response()->json($this->data,$this->code); 
    }

    public function viewClient(){
        if(Auth::user()->role_id==0){
            $get_client = Client::with('admin')->where('status',0)->get();

            if($get_client){
                $this->code = 200;
                $this->data = [
                        'status'=>'success',
                        'clients'=>$get_client,
                                          
                ];
            }else{
                $this->code = 400;
                $this->data = [
                        'status'=>'error',
                        'messages'=>'No CLient FOund!!',
                                          
                ];
            }
        }else{
           $this->code = 400;
                $this->data = [
                        'status'=>'error',
                        'messages'=>'Sorry you must be a super admin to access this page!!',
                                          
                ]; 
        }
        return response()->json($this->data,$this->code); 
    }

    public function deleteClient($client_id){
        if(Auth::user()->role_id==0){
            $delete = Client::where('id',$client_id)->update(['status'=>1]);
            $this->code = 200;
                $this->data = [
                        'status'=>'success',
                        'messages'=>'Client Deleted!!',
                                          
                ];         
        }else{
            $this->code = 400;
                $this->data = [
                        'status'=>'error',
                        'messages'=>'Sorry you must be a super admin to access this page!!',
                                          
                ];
        }
         return response()->json($this->data,$this->code); 
    }

    

    public function updateAdmin(Request $request){

            if($request->phone != Null){
                $check_mobile = Employee::where('user_id','!=',$request->admin_id)->where('phone',$request->phone)->first();            
            if(isset($check_mobile)){
                    $this->data = [
                        'status' => "error",
                        'message' => 'Mobile Number is already taken!!Try diffeent',
                    ];
                    $this->code = 409;
                    return response()->json($this->data,$this->code);
                }
            }
            if($request->email != Null){
                $check_email = Employee::where('user_id','!=',$request->admin_id)->where('email',$request->email)->first();
                if(isset($check_email)){
                    $this->data = [
                        'status' => "error",
                        'message' => 'Email ID is already taken!!Try diffeent',
                    ];
                    $this->code = 409;
                    return response()->json($this->data,$this->code);
                }
            }
                $explode_client = explode(',',$request->client_id);
                $getLocation = Location::whereIn('client_id',$explode_client)->get();
                $array = [];
                foreach($getLocation as $data){
                    array_push($array,$data->id);
                }
                $location_mapped = implode(', ', $array); 
            \Log::info($location_mapped);
            // Insert in User table
            $update = User::where('user_id',$request->admin_id)->first();
          
            $update->client_id = $request->client_id;
            $update->location_mapped = $location_mapped;
            $update->status = '0';
            $update->updated_by = Auth::user()->user_id;
            $update->update();

             // Upload Photo            
            $file_name = Null;           
            if ($request->hasFile('photo')) {
                $file_name = date('Y_m_d_H_i_s').'_'.$request->photo->getClientOriginalName();                   
                $savepath = public_path('/uploads/profile_pic');
                $request->photo->move($savepath,$file_name);
            }

            // Insert in Employee table
            $store_employee = Employee::where('user_id',$request->admin_id)->first(); 
            $store_employee->user_id = $request->admin_id;
            $store_employee->first_name = $request->first_name;
            $store_employee->last_name = $request->last_name;
            $store_employee->email  = $request->email;
            $store_employee->photo = $file_name;
            $store_employee->phone = $request->phone;
            $store_employee->update();

            if($update->update()){
                $this->data = [
                    'message'=>'Admin Updated Successfully!!',
                    'status'=>'success',
                ];
                $this->code = 200;
            }

        return response()->json($this->data,$this->code);
    }

    public function deleteAdmin($admin_id){
        $delete = User::where('user_id',$admin_id)->update(['status'=>1]);
        $this->code = 200;
            $this->data = [
                    'status'=>'success',
                    'messages'=>'Admin Deleted!!',
                                      
            ];
             return response()->json($this->data,$this->code); 
    }

    public function viewAdmin(){
        if(Auth::user()->role_id == 0){
            $admin = User::with('user_details')->where('status',0)->where('role_id',1)->get();
            if($admin){
                $this->code = 200;
                $this->data = [
                        'status'=>'success',
                        'admins'=>$admin,
                                          
                ];
            }else{
                $this->code = 400;
                $this->data = [
                        'status'=>'error',
                        'messages'=>'No Admin Found!!',
                                          
                ];
            }
        }
        else{
            $this->code = 400;
                $this->data = [
                        'status'=>'error',
                        'messages'=>'You must be super admin to access this page!!',
                                          
                ];
            }
        
        return response()->json($this->data,$this->code);
    }

    public function getCameras(Request $request){
       
        $get_cameras = Camera::where('location_id',$request->location_id)->get();
        if($get_cameras){
            $this->code = 200;
            $this->data = [
                    'status'=>'success',
                    'cameras'=>$get_cameras,
                                      
            ];
        }else{
            $this->code = 400;
            $this->data = [
                    'status'=>'error',
                    'messages'=>'No Cameras found for this location!!',
                                      
            ];
        }
        return response()->json($this->data,$this->code);
    }

    public function storeSetting(Request $request){

        $check_duplication = Setting::where('user_id',$request->user_id)
        ->where('location_id',$request->location_id)->first();

         if($check_duplication){
             $check_duplication->user_id = $check_duplication->user_id;
             $check_duplication->location_id = $request->location_id;
             $check_duplication->entry_camera = $request->entry_camera;
             $check_duplication->exit_camera = $request->exit_camera;
             $check_duplication->update();
                $this->code = 200;
                $this->data = [
                        'status'=>'success',
                        'messages'=>'Setting has been Updated!!',
                                          
                ];
         }
         else{
             $update_type = User::where('user_id',$request->user_id)->first();
             $update_type->feed_type='custom';
             $update_type->update();

             $store = new Setting;
             $store->user_id = $request->user_id;
             $store->location_id = $request->location_id;
             $store->entry_camera = $request->entry_camera;
             $store->exit_camera = $request->exit_camera;
             $store->save();

            $this->code = 200;
            $this->data = [
                    'status'=>'success',
                    'messages'=>'Setting has been stored!!',
                                      
            ];
         }
        
         return response()->json($this->data,$this->code);
    }

    public function userSetting(Request $request){

        $setting = Setting::where('user_id',$request->user_id)->where('location_id',$request->location_id)->first();
        if($setting){
           $this->code = 200;
            $this->data = [
                    'status'=>'success',
                    'data'=>$setting,
                                      
            ]; 
        }
        else{
            $this->code = 400;
            $this->data = [
                    'status'=>'error',
                    'message'=>'No custom setting found',
                                      
            ]; 
        }
        return response()->json($this->data,$this->code);
    }

    public function blockList($location_id){
        $list = BlockList::where('location',$location_id)->get();
        if($list){
            $this->code = 400;
            $this->data = [
                    'status'=>'success',
                    'data'=>$list,
                                      
            ]; 
        }else{
            $this->code = 400;
            $this->data = [
                    'status'=>'error',
                    'message'=>'Empty list for this location',
                                      
            ]; 
        }
        return response()->json($this->data,$this->code);
    }
    public function storeBLock(Request $request){
       
        date_default_timezone_set("Asia/Singapore"); 
        $store_block = new BlockList;
        $store_block->vehicle_no = $request->vehicle_no; 
        $store_block->location = $request->location;
        $store_block->date_time = date('Y-m-d H:i:s');
        $store_block->created_by = Auth::user()->user_id;
        $store_block->save(); 
        if($store_block->save()){
            $this->code = 200;
            $this->data = [
                    'status'=>'success',
                    'message'=>'vehicle_no has blocked!!',
                                      
            ];
        }
        return response()->json($this->data,$this->code);
    }

    public function editBLock(Request $request){
       
        date_default_timezone_set("Asia/Singapore"); 
        $edit_block = BlockList::where('id',$request->id)->first();
        $edit_block->vehicle_no = $request->vehicle_no; 
        $edit_block->location = $request->location;
        $edit_block->date_time = date('Y-m-d H:i:s');
        $edit_block->created_by = Auth::user()->user_id;
        $edit_block->update(); 
        if($edit_block->update()){
            $this->code = 200;
            $this->data = [
                    'status'=>'success',
                    'message'=>'Blocked vehicle has updated successfully',
                                      
            ];
        }
        return response()->json($this->data,$this->code);
    }

    public function outBLock($entry_id,$delay_reason){       
            date_default_timezone_set('Asia/Singapore');
            $current_time = date('Y-m-d H:i:s');
            $out = VisitorEnrty::with('entryFeed','exitFeed')->where('id',$entry_id)->first();
           
            if(!$out){
                $this->code = 409;
                    $this->data = [
                        'status'=>'error',
                        'message'=>'No vehicle no is given for this entry!!',
                    ];
                    return response()->json($this->data,$this->code);
            }
            if($out->entry_type!=2){
                $exit_feed=[];;
                $license_no = $out->vehicle_no;
                if(Auth::user()->feed_type=='DEFAULT'){
                $exit_feed = Feed::where('feed_name','Exit Camera')->where('location_id',$out->location_id)->where('license_plate_number',$license_no)->where('mapped_to_entry',0)->first();
                }else{
                  $feed_id = Setting::where('user_id',Auth::user()->user_id)->where('location_id',$out->location_id)
                    ->first();      
                 $exit_feed = Feed::where('feed_name','Exit Camera')->where('feed_id',$feed_id->exit_camera)->where('license_plate_number',$license_no)->where('mapped_to_entry',0)->first();   
                }

                if(!$exit_feed){
                    $out->out_time = $current_time;
                    $out->delay_reason = $delay_reason;
                    $out->update();
                }
                else{                    
                    $exit_feed->mapped_to_entry = $entry_id;
                    $exit_feed->update();
                    $visitor_entry = VisitorEnrty::where('id',$entry_id)->first();
                    $visitor_entry->delay_reason = $delay_reason;
                    $visitor_entry->out_time = $current_time;
                    $visitor_entry->exit_feed = $exit_feed->id;
                    $visitor_entry->update();
                }

                $block = new BlockList;
                $block->vehicle_no = $license_no;
                $block->location = $out->location_id;
                $block->date_time = $current_time;
                $block->created_by = Auth::user()->user_id;
                $block->save();
            }
            else{
                if($out->vehicle_no){
                    $block = new BlockList;
                    $block->vehicle_no =$out->vehicle_no;
                    $block->location = $out->location_id;
                    $block->date_time = $current_time;
                    $block->created_by = Auth::user()->user_id;
                    $block->save();
                }
                $out->delay_reason = $delay_reason;
                $out->out_time = $current_time;
                $out->update();
            }

             $this->code = 200;
                $this->data = [
                    'status'=>'success',
                    'message'=>'Visitor has been exited and blocked successfully!!',
                ];
             return response()->json($this->data,$this->code);
    }
    public function deleteBlock($id){
        $block = BlockList::where('id',$id)->delete();

         $this->code = 200;
                $this->data = [
                    'status'=>'success',
                    'message'=>'Given entry was unblocked successfully!!',
                ];
             return response()->json($this->data,$this->code);
    }

    public function searchBlock($location_id,$key){
       
        $search = BlockList::where('location',$location_id);
        $result = $search->where(function ($q) use ($key) {
                            $q->orWhere('vehicle_no', 'LIKE', '%' . $key . '%');
                            })->paginate(10);
        if($result){
            $this->code = 200;
                $this->data = [
                    'status'=>'success',
                    'data'=>$result,
                ];
        }
        else{
             $this->code = 400;
                $this->data = [
                    'status'=>'error',
                    'message'=>'No result found',
                ];
        }
        return response()->json($this->data,$this->code);
    }

    public function getAllVisitor(Request $request){
           if($request->entry_type==2){
                if($request->search==''){
                    $getReport = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')->where('location_id',$request->location_id)->where('entry_type',2)->orderBy('Created_at','DESC')->paginate(20)->appends(request()->query());
                }
                else{
                   $search = $request->search; 
                   $visitors = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')
                                ->leftjoin('visitors', 'entry.visitor_id', '=', 'visitors.visitor_id')
                                ->leftjoin('purpose', 'entry.visit_reason', '=', 'purpose.purpose_id')
                                ->where('entry_type',2)
                                ->where('location_id',$request->location_id);

                   $getReport = $visitors->where(function ($q) use ($search){
                                $q->orWhere('visitors.mobile', 'LIKE', '%' . $search . '%')
                                    ->orWhere('visitors.visitor_name', 'LIKE', '%' . $search . '%')
                                    ->orWhere('visitors.email', 'LIKE', '%' . $search . '%')
                                    ->orWhere('entry.contact_person', 'LIKE', '%' . $search . '%')
                                    ->orWhere('entry.unit_no', 'LIKE', '%' . $search . '%')
                                    ->orWhere('purpose.purpose', 'LIKE', '%' . $search . '%')
                                    ->orWhere('entry.vehicle_no', 'LIKE', '%' . $search . '%');
                                })->paginate(20)->appends(request()->query());   
                }
           }
            else{
                if($request->search==''){
                    $getReport = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')->where('location_id',$request->location_id)->orderBy('Created_at','DESC')->paginate(20)->appends(request()->query());
                }
                else{
                    $search = $request->search; 
                   $visitors = VisitorEnrty::with('getVisitor','visitReason','entryFeed','exitFeed')
                                ->leftjoin('visitors', 'entry.visitor_id', '=', 'visitors.visitor_id')
                                ->leftjoin('purpose', 'entry.visit_reason', '=', 'purpose.purpose_id')
                                ->where('location_id',$request->location_id);

                   $getReport = $visitors->where(function ($q) use ($search){
                                $q->orWhere('visitors.mobile', 'LIKE', '%' . $search . '%')
                                    ->orWhere('visitors.visitor_name', 'LIKE', '%' . $search . '%')
                                    ->orWhere('visitors.email', 'LIKE', '%' . $search . '%')
                                    ->orWhere('entry.contact_person', 'LIKE', '%' . $search . '%')
                                    ->orWhere('entry.unit_no', 'LIKE', '%' . $search . '%')
                                    ->orWhere('purpose.purpose', 'LIKE', '%' . $search . '%')
                                    ->orWhere('entry.vehicle_no', 'LIKE', '%' . $search . '%');
                                })->paginate(20)->appends(request()->query());   
                }
            }
            
                    
            if($getReport){
                $this->code = 200;
                $this->data = [
                    'status'=>'success',
                    'visitors'=>$getReport,              
                ];
            }
            else{
                $this->code = 400;
                $this->data = [
                    'status'=>'error',
                    'message'=>'No entry had found'
                ];
            }
            return response()->json($this->data,$this->code);

    }
}

