<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Gateway;
use App\Models\Camera;
use App\Models\Link;
use App\Models\User;
use App\Models\SMTP_Setting;
use App\Models\Employee;
use App\Mail\sendOtpMail;
use Illuminate\Support\Facades\Mail; 
use Hash; 
use Auth;  

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['forgetPassword','forgetUpdatePassword']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createLocation(Request $request){
       
        $store = new Location();
        $store->location_id = $request->location_id;
        $store->client_id = $request->client_id;
        $store->location_name = $request->location_name;
        $store->latitude = $request->latitude;
        $store->longitude = $request->longitude;
        $store->street = $request->street;
        $store->street2 = $request->street2;
        $store->city = $request->city;
        $store->state = $request->state;
        $store->postal = $request->postal;
        $store->country = $request->country;
        $store->phone = $request->phone;
        $store->timezone = $request->timezone;
        $store->is_local = $request->is_local;
        $store->url = $request->url;
        $store->threshold = $request->threshold;
        $store->archive_store = $request->archive_store;
        $store->archive_url = $request->archive_url;
        $store->username = $request->username;
        $store->password = $request->password;
        $store->save();

        $this->code = 200;
        $this->data=[
                "status"=>"success",
                "message"=>"Location Stored successfully",
            ];

        return response()->json($this->data, $this->code);
    }
    public function updateLocation(Request $request){
       
        $update = Location::where('id',$request->id)->first();
        $update->location_id = $request->location_id;
        $update->client_id = $request->client_id;
        $update->location_name = $request->location_name;
        $update->latitude = $request->latitude;
        $update->longitude = $request->longitude;
        $update->street = $request->street;
        $update->street2 = $request->street2;
        $update->city = $request->city;
        $update->state = $request->state;
        $update->postal = $request->postal;
        $update->country = $request->country;
        $update->phone = $request->phone;
        $update->timezone = $request->timezone;
        $update->is_local = $request->is_local;
        $update->url = $request->url;
        $update->threshold = $request->threshold;
        $update->archive_store = $request->archive_store;
        $update->archive_url = $request->archive_url;
        $update->username = $request->username;
        $update->password = $request->password;
        $update->update();

     

        $this->code = 200;
        $this->data=[
                "status"=>"success",
                "message"=>"Location Updated successfully",
            ];

        return response()->json($this->data, $this->code);
    }
    public function deleteLocation(Request $request){
        $delete = Location::where('id',$request->id)->delete();

        $this->code = 200;
        $this->data=[
                "status"=>"success",
                "message"=>"Location Deleted successfully",
            ];

        return response()->json($this->data, $this->code);
    }

    public function storeGateway(Request $request){
        $store = new Gateway();
        $store->location_id = $request->location_id;
        $store->gateway_id = $request->gateway_id;
        $store->gateway_name = $request->gateway_name;
        $store->save();

        $this->code = 200;
        $this->data=[
                "status"=>"success",
                "message"=>"Gateway stored successfully",
            ];

        return response()->json($this->data, $this->code);

    }

    public function updateGateway(Request $request){
        $update = Gateway::where('id',$request->id)->first();
        $update->gateway_name = $request->gateway_name;
        $update->gateway_id = $request->gateway_id;
        $update->location_id = $request->location_id;
        $update->update();

        $this->code = 200;
        $this->data=[
                "status"=>"success",
                "message"=>"Gateway Updated successfully",
            ];

        return response()->json($this->data, $this->code);
    }

    public function deleteGateway(Request $request){
         $delete = Gateway::where('id',$request->id)->delete();

        $this->code = 200;
        $this->data=[
                "status"=>"success",
                "message"=>"Gateway Deleted successfully",
            ];

        return response()->json($this->data, $this->code);
        
    }
    public function storeCamera(Request $request){
       
        $store = new Camera();
        $store->location_id = $request->location_id;
        $store->gateway_id = $request->gateway_id;
        $store->feed_id = $request->feed_id;
        $store->feed_name = $request->feed_name;
        $store->audio = $request->audio;
        $store->recording = $request->recording;
        $store->save();

        $this->code = 200;
        $this->data=[
                "status"=>"success",
                "message"=>"Camera Stored successfully",
            ];

        return response()->json($this->data, $this->code);

    }
    public function storeCameraWithoutGateway(Request $request){
       
        $store = new Camera();
        $store->location_id = $request->location_id;
        $store->gateway_id = '0';
        $store->feed_id = $request->feed_id;
        $store->feed_name = $request->feed_name;
        $store->audio = $request->audio;
        $store->recording = $request->recording;
        $store->save();

        $this->code = 200;
        $this->data=[
                "status"=>"success",
                "message"=>"Camera Stored successfully",
            ];

        return response()->json($this->data, $this->code);

    }
    public function updateCamera(Request $request){
        // print_r($request->feed_id);
        // exit;
        $update = Camera::where('id',$request->id)->first();
        $update->feed_id = $request->feed_id;
        $update->feed_name = $request->feed_name;
        $update->location_id = $request->location_id;
        $update->gateway_id = $request->gateway_id;
        $update->update();

        $update_link = Link::where('feed_id',$request->feed_id)->first();
        if($update){
            $update_link->link_id = $request->link_id;
            $update_link->feed_id = $request->feed_id;
            $update_link->perpetual = $request->perpetual;
            $update_link->link = $request->link;
            $update_link->update();

            $this->code = 200;
            $this->data=[
                    "status"=>"success",
                    "message"=>"Camera Updated successfully",
                ];
        }else{
                $this->code = 400;
                $this->data=[
                    "status"=>"error",
                    "message"=>"No Link for this feed id",
                ];
        }
        

        return response()->json($this->data, $this->code);
    }
    public function deleteCamera(Request $request){
         $delete = Camera::where('id',$request->id)->delete();

        $this->code = 200;
        $this->data=[
                "status"=>"success",
                "message"=>"Camera Deleted successfully",
            ];

        return response()->json($this->data, $this->code);
        
    }

    public function storeLink(Request $request){
    
        $store = new Link();
        $store->link_id = $request->link_id;
        $store->start = $request->start;
        $store->perpetual = $request->perpetual;
        $store->feed_id = $request->feed_id;
        $store->end = $request->end;
        $store->link = $request->link;
        $store->save();

        $this->code = 200;
        $this->data=[
                "status"=>"success",
                "message"=>"Link stored successfully",
            ];

        return response()->json($this->data, $this->code);
    }

    public function updateLink(Request $request){

        $update = Link::where('id',$request->id)->first();
        $update->link_id = $request->link_id;
        $update->start = $request->start;
        $update->perpetual = $request->perpetual;
        $update->feed_id = $request->feed_id;
        $update->end = $request->end;
        $update->link = $request->link;
        $update->update();

        $this->code = 200;
        $this->data=[
                "status"=>"success",
                "message"=>"Link Update successfully",
            ];

        return response()->json($this->data, $this->code);
    }

     public function deleteLink(Request $request){
        $delete = Link::where('id',$request->id)->delete();
        

        $this->code = 200;
        $this->data=[
                "status"=>"success",
                "message"=>"Link Deleted successfully",
            ];

        return response()->json($this->data, $this->code);      
    }

    public function MyProfile(Request $request){
        $profile =  User::join('employee', 'employee.user_id', '=', 'login.user_id')->where('login.user_id',$request->user_id)->first();

        $this->code = 200;
        $this->data=[
                "data"=>$profile,
                "status"=>"success",
            ];

        return response()->json($this->data, $this->code); 
    }
    
    public function updateProfile(Request $request){
         if($request->phone != Null){
                $check_mobile = Employee::where('user_id','!=',$request->user_id)->where('phone',$request->phone)->first();            
                if(isset($check_mobile)){
                    $this->data = [
                        'status' => "error",
                        'message' => 'Mobile Number is already taken!!Try different',
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
                        'message' => 'Email ID is already taken!!Try different',
                    ];
                    $this->code = 409;
                    return response()->json($this->data,$this->code);
                }
            }

            $update = Employee::where('user_id',$request->user_id)->first();
            $update->first_name = $request->first_name;
            $update->last_name = $request->last_name;
            $update->email = $request->email;
            $update->phone = $request->phone;
            $update->update();

            if(Auth::user()->role_id!=0){
                $location = Location::whereIn('id',explode(',',Auth::user()->location_mapped))->get();
            }else{
                $location = Location::all();
            }

            $user = User::select('user_id','username','location_mapped','role_id')->where('user_id',$request->user_id)->first();
            $role = Controller::getRoleInfoByUserId($request->user_id);

            $this->code = 200;
                $this->data=[
                    "message"=>'Profile Updated Successfully',
                    "data"=>[
                        'user'=>$user,
                        'role'=>$role['role']->role_name,
                        'permission'=> json_decode($role['role']->role_permission),
                        'location'=>$location
                    ],
                    "status"=>"success",
                ];

            return response()->json($this->data,$this->code);
    }
    public function forgetPassword(Request $request){
        $otp = rand(9999,100);
        $user = User::where('username',$request->user_name)->first();
        if(!$user){
            $this->code = 400;
            $this->data=[
                "message"=>'Invalid Username',
                "status"=>"error",
            ];   
           
            return response()->json($this->data, $this->code);
        }
        $user->otp = $otp;
        $user->update();
        $employee = Employee::where('user_id',$user->user_id)->first();

        $details = [
            'title' => 'Reset Password - Visitor Management',
            'body' => '' ,
            'otp'=>$otp,
            'name'=>$employee->first_name,
            ];
            if($employee->email){
                 //Mail::to($employee->email)->send(new sendOtpMail($details));
            }
            $reset_location = SMTP_Setting::where('location_id',12)->update(['current_active'=>'0']);
            $this->code = 200;
            $this->data=[
                "otp"=>$otp,
                "message"=>'OTP send to your registered email!! Pls check to your email to proceed',
                "status"=>"success",
            ];   
           
            return response()->json($this->data, $this->code); 
    }

    public function forgetUpdatePassword(Request $request){
        $user = User::where('username',$request->user_name)->first();
        if($user->otp == $request->otp){
            
            $update_user = User::where('username',$request->user_name)->first();
            $update_user->password = Hash::make($request->password);
            $update_user->update();
            
            $this->code = 200;
            $this->data=[
                "message"=>'Password Reset Successfully',
                "status"=>"success",
            ];
        }
        else{
           $this->code = 400;
            $this->data=[
                "message"=>'Invalid OTP',
              
                "status"=>"error",
            ];
        }
        return response()->json($this->data, $this->code); 
    }

 }

