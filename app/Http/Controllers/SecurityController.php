<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\login;
use Auth;
use Hash;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\Role;
use App\Models\FeedCloud;
use App\Models\FeedInterval;
use App\Models\Employee;
use App\Models\Visitor;
use App\Models\Purpose;
use App\Models\Security;
use App\Models\Location;
use App\Mail\sendMail;
use Illuminate\Support\Facades\Mail;

class SecurityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct() {
        $this->middleware('auth:api', ['except' => ['postLogin']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewSecurity(){

        // $users = User::where('is_deleted',0)->get();
        if(Auth::user()->role_id==0){
            $users =  User::join('employee', 'employee.user_id', '=', 'login.user_id')
                    ->join('security','security.user_id', '=', 'login.user_id')
                    ->where('role_id','!=',0)
                    ->where('login.is_deleted','!=',1)
                    ->where('user_type',1)
                    ->join('roles', 'roles.id', '=', 'login.role_id')->get();
        }
        else{
           $clients = explode(',',Auth::user()->client_id);   
            $users = $users =  User::join('employee', 'employee.user_id', '=', 'login.user_id')
                            ->join('security','security.user_id', '=', 'login.user_id')
                            ->whereIn('client_id',$clients)
                            ->where('user_type',1)
                            ->where('role_id','!=',0)
                            ->where('login.is_deleted','!=',1)
                            ->join('roles', 'roles.id', '=', 'login.role_id')->get();
        }
        

        $this->code = 200;
        $this->data = ['status' => "success",'user'=>$users];
        return response()->json($this->data,$this->code);
    }

    public function storeSecurity(Request $request){
        
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
            $stor_user->user_type = '1';
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
            // Store in Security Table   
            $store_security = new Security;
            $store_security->user_id = $getUser_id->user_id;
            $store_security->shift = $request->shift;
            $store_security->save();

            // Send Welcome Email
           
            $this->data = [
                'message'=>'Security Added Successfully!!',
                'status'=>'success',
            ];
            $this->code = 200;

        return response()->json($this->data,$this->code);
    }

     public function updateSecurity(Request $request){
        
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
           
            // Update Security
            $update_security = Security::where('user_id',$request->user_id)->update(['shift' => $request->shift]);
           

            $this->data = [
                'message'=>'Security Updated Successfully!!',
                'status'=>'success',
            ];
            $this->code = 200;

        return response()->json($this->data,$this->code);
    }

     public function deleteSecurity(Request $request){
        $destroy_user = User::where('user_id',$request->user_id)->first();

        if(!$destroy_user){
            $this->data= [
            "message"=>"No user found for this id!!",
            "status"=>"error",
            ];
            $this->code = 400;
            return response()->json($this->data,$this->code);
        }
        
        $destroy_user->delete();
        $destroy_employee = Employee::where('user_id',$request->user_id)->first();
        $destroy_employee->delete();
        $destroy_security = Security::where('user_id',$request->user_id)->delete();
  

        $this->data= [
        "message"=>"Security Deleted Successfully!!",
        "status"=>"success",
        ];
        $this->code = 200;

        return response()->json($this->data,$this->code);
    }

    public function storeInterval(Request $request){
        $check_location = FeedInterval::where('location_id',$request->location_id)->first();

        if($check_location){
             $this->data= [
                "message"=>'This location already has its interval..',
                "status"=>"error",
            ];
            $this->code = 400;

            return response()->json($this->data,$this->code);  
        }

        $store = new FeedInterval();
        $store->location_id = $request->location_id;
        $store->feed_interval = $request->interval;
        $store->save();

        $this->data= [
        "message"=>"Interval Created for this location",
        "status"=>"success",
        ];
        $this->code = 200;

        return response()->json($this->data,$this->code); 
    }
    public function viewInterval(Request $request){
        $get_interval =FeedInterval::where('location_id',$request->location_id)->first();
        
        if($get_interval){
             $this->code = 200;
             $this->data = ['status' => "success",'data'=>$get_interval];
       
        }
        else{
             $this->data= [
                "message"=>"No Interval Found for this location...",
                "status"=>"error",
                ];
            $this->code = 400;
        }
         return response()->json($this->data,$this->code);
    }

    public function updateInterval(Request $request){
        
        $updateInterval = FeedInterval::where('location_id',$request->location_id)->update(["feed_interval"=>$request->interval]);

        $this->data= [
                "message"=>"Interval has been update successfully",
                "status"=>"success",
                ];
        $this->code = 200;

        return response()->json($this->data,$this->code);

    }

    public function deleteInterval(Request $request){
        $deleteInterval = FeedInterval::where('location_id',$request->location_id)->delete();
        
        $this->data= [
                "message"=>"Interval has been Deleted successfully",
                "status"=>"success",
                ];
        $this->code = 200;

        return response()->json($this->data,$this->code);
    }

    public function getFeedByDate(Request $request){
        $getFeeds = FeedCloud::whereDate('date_time',date('Y-m-d',strtotime($request->date)))->get();

        $this->data= [
                "data"=>$getFeeds,
                "status"=>"success",
                ];
        $this->code = 200;

        return response()->json($this->data,$this->code);
    }
    
}

