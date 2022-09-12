<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\VisitorEnrty;
use App\Models\VisitorLocal;
use App\Models\VisitorEntryLocal;
use App\Models\FeedLocal;
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
use Redirect;
use Tymon\JWTAuth\Exceptions\JWTException;

class ServerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct(){
    //     $this->middleware('auth:api',['except' => ['postLogin','storeFeeds']]);
    // }

    public function triggerCron(Request $request){
    	
    	$location_id = 'SD686S5A565';
	 	$curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://dev.visitormanagement.solstium.net/security_monitoring/api/admin/last_entry_date/".$location_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
           
        ));
        $response = curl_exec($curl);
        $data = json_decode($response, true);
        
        if($data['date_time'] == 0){
            $entries = VisitorEnrty::with('getVisitor','entryFeed','exitFeed')->where('location_id',$data['location'])->get();
        }
        else{
        	$entries = VisitorEnrty::with('getVisitor','entryFeed','exitFeed')->where('location_id',$data['location'])->where('in_time', '>', $data['date_time'])->get();
        }
        // return response()->json($entries);
        // exit;
        
	// Sending entries to server
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://dev.visitormanagement.solstium.net/security_monitoring/api/admin/store_entries_server');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($entries));  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json',                                                                                
		    'Content-Length: ' . strlen($entries))                                                                       
		);                                                                                                                   

		$out = curl_exec($ch);
		curl_close($ch);

          
    }
 
}

