<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\VisitorEnrty;
use App\Models\Purpose;
use App\Models\Attendance;
use App\Models\Feed;
use App\Models\Shift;
use App\Models\Security;
use App\Models\Location;
use App\Models\User;
use App\Models\Unit;
use App\Imports\UnitImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use App\Mail\sendMail;
use Illuminate\Support\Facades\Mail;
use App\Models\SMTP_Setting;
use DateTime;
use DatePeriod;
use DateInterval;
use Auth;
use Hash;
use JWTAuth;
use Exception;

use Tymon\JWTAuth\Exceptions\JWTException;
class ShiftController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

   public function index(){
        print_r('heleo');
    }

    public function storeShift(Request $request){
        $day_cross = 0;
        if(date('H',strtotime($request->start_time))>date('H',strtotime($request->end_time))) {
              $day_cross = 1;
        }
        $store = new Shift;
        $store->shift_name = $request->shift_name;
        $store->start_time = $request->start_time;
        $store->end_time = $request->end_time;
        $store->day_cross = $day_cross;
        $store->save();

         $this->code = 200;
                $this->data = [
                    'status' => "success",
                    'message'=>'Shift Created',
                ];
                return response()->json($this->data, $this->code);

     } 

     public function viewShift(){
         $shift = Shift::all();
         $this->code = 200;
                $this->data = [
                    'status' => "success",
                    'data'=>$shift,
                ];
                return response()->json($this->data, $this->code);
     }

     public function updateShift(Request $request){
             $day_cross = 0;
            if(date('H',strtotime($request->start_time))>date('H',strtotime($request->end_time))) {
                  $day_cross = 1;
            }
            $update = Shift::where('id',$request->shift_id)->first();
            $update->shift_name = $request->shift_name;
            $update->start_time = $request->start_time;
            $update->end_time = $request->end_time;
            $update->day_cross = $day_cross;
            $update->update();

                $this->code = 200;
                $this->data = [
                    'status' => "success",
                    'message'=>'Shift Updated',
                ];
                return response()->json($this->data, $this->code);
     }

    public function deleteShift(Request $request){
        $delete = Shift::where('id',$request->shift_id)->first();
        if($delete){
        $delete->delete();
        $this->code = 200;
        $this->data = [
                'status' => "success",
                'message'=>'Shift Deleted!!',
            ];
        }
        else{
             $this->code = 400;
            $this->data = [
                'status' => "error",
                'message'=>'No shift for this id',
            ];
        }
        return response()->json($this->data, $this->code);
    } 

    public function viewSMTPByLocation(Request $request){
        $getLocation_id = Location::select('id')->where('location_id',$request->location_id)->first();
        if($getLocation_id){
           $data = SMTP_Setting::where('location_id',$getLocation_id->id)->first();
           if($data){
                $this->code = 200;
                $this->data = [
                'status' => "success",
                'data'=>$data,
                ];
           }
           else{
             $this->code = 400;
             $this->data = [
                'status' => "error",
                'message'=>'No Setting for this location',
                ];
           }
        }else{
            $this->code = 400;
            $this->data = [
                'status' => "error",
                'message'=>'Invalid Location ID',
            ];
        }
        return response()->json($this->data, $this->code);
    }

    public function viewSMTP(){
        $smtp_setting = SMTP_Setting::with('location')->get();

        $this->code = 200;
        $this->data = [
                'status' => "success",
                'data'=>$smtp_setting,
            ];
       
        return response()->json($this->data, $this->code);
    }

    public function addSMTP(Request $request){
        
        $store = new SMTP_Setting();
        $store->email = $request->email;
        $store->password = $request->password;
        $store->driver = $request->driver;
        $store->host = $request->host;
        $store->port = $request->port;
        $store->encryption = $request->encryption;
        $store->location_id = $request->location_id;
        $store->save();
         $this->code = 200;
         $this->data = [
                'status' => "success",
                'message'=>'Sender Email Created!!',
            ];
        return response()->json($this->data, $this->code);
    }

    public function updateSMTP(Request $request){
        $store = SMTP_Setting::where('id',$request->id)->first();
        $store->email = $request->email;
        $store->password = $request->password;
        $store->driver = $request->driver;
        $store->host = $request->host;
        $store->port = $request->port;
        $store->encryption = $request->encryption;
        $store->location_id = $request->location_id;
        $store->save();
         $this->code = 200;
         $this->data = [
                'status' => "success",
                'message'=>'Sender Email Updated!!',
            ];
        return response()->json($this->data, $this->code);
    }
    public function storeAttendance(Request $request){
        date_default_timezone_set("Asia/Singapore");

        // Get Shift by time  
        $shift_id=0;
        $shifts = Shift::get();
        //$current_time = date('H:i:s');
        $current_time = '19:00:00';
        foreach($shifts as $shift){             
            if(date('H',strtotime($shift->start_time)) > date('H',strtotime($shift->end_time))){
                $getShift = SHift::where('day_cross',1)->first();
                   $shift_id = $getShift->id;
                   break;
                  
            }
            else{
                 $date1 = DateTime::createFromFormat('h:i a', date('h:i a', strtotime($current_time)));
                 $date2 = DateTime::createFromFormat('h:i a', date('h:i a', strtotime($shift->start_time)));
                 $date3 = DateTime::createFromFormat('h:i a', date('h:i a', strtotime($shift->end_time)));
               
                if ($date1 >= $date2 && $date1 < $date3){
                    $shift_id = $shift->id;
                    break;
                   
                }
            }  
        }
        
        
       
        if($shift_id==0){
            $this->code = 400;
            $this->data = [
                    'status' => "error",
                    'message'=>'No Shift for this time',
            ];
        }

        // Security Code Validation
        $security=Security::where('user_id',$request->user_id)->where('security_code',$request->security_code)->first();
        if($security){
            if($request->photo){
                $image = base64_decode($request->photo); // decode the image
                $imageName = rand(1000, 999999).'.'.'jpg'; 
                file_put_contents('public/uploads/security_photo/'.$imageName,$image);
            }
            else{
                    $this->code = 400;
                    $this->data = [
                            'status' => "error",
                            'message'=>'Image Required',
                    ];
                return response()->json($this->data, $this->code);
            }
            
            // get shift from time
            $store = new Attendance;
            $store->user_id = $security->user_id;
            $store->date_time= date('Y-m-d H:i:s');
            $store->shift_id = $shift_id;
            $store->location_id = $request->location_id;
            $store->status = '0';
            $store->geo_location = $request->geo_location;
            $store->photo = $imageName;
            $store->save();
            $this->code = 200;
               $this->data = [
                    'status' => "success",
                    'message'=>'Attendance Registered Successfully',
                ];
        }
        else{
             $this->code = 400;
               $this->data = [
                    'status' => "error",
                    'message'=>'Invalid Security ID or Code',
                ];
        }
        return response()->json($this->data, $this->code);
    }

    public function viewAttendance(Request $request){

        $attendance_data=array();
        $location = Location::select('id')->where('location_id',$request->location_id)->first();

        if($request->date_from==0 && $request->security==0){
                $attendance_array = array();
                $users = User::where('role_id',2)->whereRaw("find_in_set(".$location->id.",location_mapped)")->get();
                 foreach($users as $user) {
                    $temp=[];
                    $attendance_array['user_id']= $user->user_id;
                    $attendance_array['user_name']= $user->username; 
                    $attendance = Attendance::where('location_id',$request->location_id)->whereDate('date_time',date('Y-m-d'))->where('user_id',$user->user_id)->get(); 
                     $temp['date']= date('Y-m-d');
                    if(count($attendance)>0){
                         $temp['att'] ='P,'.count($attendance);
                    }else{
                         $temp['att'] ='A';
                    }
                    $attendance_array['attendance'] = $temp;
                    $attendance_data[] = $attendance_array;
                 }
        }
        elseif($request->date_from==0 && $request->security!=0){
            $attendance_array = array();
             $users = User::where('user_id',$request->security)->first();

                    $temp=[];
                    $attendance_array['user_id']= $request->security;
                    $attendance_array['user_name']= $users->username;
                    $temp['date']= date('Y-m-d');
                    $attendance = Attendance::where('location_id',$request->location_id)->whereDate('date_time',date('Y-m-d'))->where('user_id',$request->security)->get(); 
                    if(count($attendance)>0){
                        $temp['att'] ='P,'.count($attendance);
                    }else{
                        $temp['att'] ='A';
                    }
                    $attendance_array['attendance'] = $temp;
                    $attendance_data[] = $attendance_array;
        }
        else{
                if($request->security==0){ 

                    $users = User::where('role_id',2)->whereRaw("find_in_set(".$location->id.",location_mapped)")->get();
                        foreach($users as $user){
                            $attendance_array = array();
                            $date_range = $this->getDatesFromRange($request->date_from,$request->date_to);
                            $attendance_array['user_id']= $user->user_id;
                            $attendance_array['user_name']= $user->username; 
                            $temp_array =[];
                            foreach($date_range as $date){
                                $temp=[];
                                $attendance =  Attendance::where('location_id',$request->location_id)->whereDate('date_time',$date)->where('user_id',$user->user_id)->get();
                               
                                if(!empty($attendance[0])){                                     
                                    $temp['date']= $date;
                                    $temp['att'] = 'P,'.count($attendance);
                                   
                                }
                                else{
                                    $temp['date']= $date;
                                    $temp['att'] = 'A';
                                   
                                }
                                $temp_array[]=$temp;
                                
                            }
                            $attendance_array['attendance']=$temp_array;
                            $attendance_data[] = $attendance_array;
                        }
                        
                }
                else{
                    $date_range = $this->getDatesFromRange($request->date_from,$request->date_to);
                    $users = User::where('user_id',$request->security)->first();

                    $attendance_array = array();
                     
                    $attendance_array['user_id']= $request->security;
                    $attendance_array['user_name']= $users->username;
                    $temp_array=[];
                     foreach($date_range as $date){
                        $temp=[];
                        $attendance = Attendance::where('location_id',$request->location_id)->whereDate('date_time',$date)->where('user_id',$request->security)->get();
                       
                        
                        if(count($attendance)>0){   
                            $temp['date']= $date;
                            $temp['att'] = 'P,'.count($attendance);
                        }
                        else{
                            $temp['date']= $date;
                            $temp['att'] = 'A';
                        }
                        $temp_array[]=$temp;            
                    }  
                    $attendance_array['attendance']=$temp_array;
                    $attendance_data[] = $attendance_array;  
                }

        }
        
        $this->code = 200;
        $this->data = [
                'status' => "success",
                'data'=>$attendance_data,
        
        ];
        return response()->json($this->data, $this->code);
    }
    function getDatesFromRange($start, $end, $format = 'Y-m-d') { 
        // Declare an empty array
        $array = array();
          
        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');
      
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
      
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
      
        // Use loop to store date into array
        foreach($period as $date) {                 
            $array[] = $date->format($format); 
        }
      
        // Return the array elements
        return $array;
    }

    public function attendanceDetail(Request $request){
        $attendance_data = array();
        $user = User::where('user_id',$request->security)->first();
    
        $attendance = Attendance::whereDate('date_time',$request->date)->where('user_id',$request->security)->get();
        $attendance_data['user_id']=$request->security;
        $attendance_data['user_name']=$user->username;
        $temp=[];
        foreach($attendance as $data){
            $shift = Shift::where('id',$data->shift_id)->first(); 
            $temp_array=[];          
            $temp_array['date']=$request->date;
            $temp_array['shift']=$data->shift_id;
            $temp_array['shift_name']=$shift->shift_name;
            $temp_array['img']=$data->photo;
            $temp[]=$temp_array;
        }
        $attendance_data['attendance']=$temp;

        $this->code = 200;
        $this->data = [
                'status' => "success",
                'data'=>$attendance_data,
        
        ];
        return response()->json($this->data, $this->code);
    }

    public function securityNotification(){
        date_default_timezone_set("Asia/Singapore"); 
        $securities = Security::all();
        foreach($securities as $security){
            $check_shift = Shift::where('id',$security->shift)->whereTime('end_time',date('H:i'))->first();
            if($check_shift){
                $code = (rand(4,9999));
                $store_code = Security::where('user_id',$security->user_id)->update(['security_code'=>$code]);
              
                $message = "Your Shift Has ended at ".date('h:i a');
                $details=['user_id'=>$security->user_id,'code'=>$code,'message'=>$message];
                \Log::info($details);
                event(new \App\Events\NotificationPush($details)); 
                return response()->json($details);
            }
        } 
        
    }

}

