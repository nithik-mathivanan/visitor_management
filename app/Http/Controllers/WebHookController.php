<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Gateway;
use App\Models\Camera;
use App\Models\Link;
use Session;
use Auth;

class WebHookController extends Controller
{
     public function __construct() {
       
         $this->middleware('auth:api',['except' => ['testPost']]);
    }
    public function setLocation(Request $request){
        //$request->session()->set('session_location', $request->input('location_id'));
        Session::set('session_location', $request->input('location_id'));  
        echo $request->session()->get('session_location');   
    }

    public function viewLocation(){
       if(Auth::user()->role_id != 0){
           $location = Location::whereIn('client_id',explode(',',Auth::user()->client_id))->get();   
           if(isset($location)){
            $this->code = 200;
            $this->data = [
                "status"=>"success",
                "data" => $location,
            ];
           }
           else{
            $this->code = 409;
            $this->data = [
                "status"=>"error",
                "message" =>'No location found..',
            ];
           }
       }else{
            $location = Location::all();  
            $this->code = 200;
            $this->data = [
                "status"=>"success",
                "data" => $location,
            ];
       } 
        return response()->json($this->data, $this->code);
    }

    public function storeLocation(Request $request){  

        if(!$request->token){
            $this->code = 409;
            $this->data=[
                'status'=>"error",
                'message'=>"You Must provide header token",
            ];
            return response()->json($this->data, $this->code);
        }

            $tokens = "Authorization: Bearer ".$request->token;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://vision.spectra.com.sg/api/external/locations",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array($tokens),
            ));

            $response = curl_exec($curl);

            $data = json_decode($response, true);

             if(isset($data['locations'])){
                foreach($data['locations'] as $loc_value){
                    $locationDuplication = Location::where('location_id',$loc_value['locationId'])->first();
                    if(!isset($locationDuplication)){
                        $store = new Location;
                         $store->location_id = $loc_value['locationId'];
                         $store->client_id = $request->client_id;
                         $store->location_name = $loc_value['locationName'];
                         $store->latitude = $loc_value['address']['geo']['latitude'];
                         $store->longitude = $loc_value['address']['geo']['longitude'];
                         $store->street = $loc_value['address']['street'];
                         $store->street2 = $loc_value['address']['street2'];
                         $store->city = $loc_value['address']['city'];
                         $store->state = $loc_value['address']['state'];
                         $store->postal = $loc_value['address']['postal'];
                         $store->country = $loc_value['address']['country'];
                         $store->phone = $loc_value['phone'];
                         $store->timezone = $loc_value['timezone'];
                         $store->save();
                    }
                }
                return redirect()->route('store_gateway',['location_id'=>$store->location_id,'token'=>$request->token]);
                $this->code = 200;
                $this->data=[
                    'status'=>"success",
                    'message'=>"All Location has been stored successfully",
                ];
            }
            else{
                    $this->code = 400;
                    $this->data=[
                        'status'=>"error",
                        'message'=>"Client stored!!,But No location for this token",
                    ];
             }
            return response()->json($this->data, $this->code);
        
    }

    public function viewGateway($loc_id){
           $gateway = Gateway::where('location_id',$loc_id)->get();
         
     
           if(count($gateway)!=0){
            $this->code = 200;
            $this->data = [
                "status"=>"success",
                "data" => $gateway,
            ];
           }
           else{
            $this->code = 409;
            $this->data = [
                "status"=>"error",
                "message" =>'No location found..',
            ];
           } 
            return response()->json($this->data, $this->code);
        }

    public function storeGateway(Request $request){

            $bearer = $request->token; 
            $token = "Authorization: Bearer ".$bearer;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://vision.spectra.com.sg/api/external/location/gateways/".$request->location_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array($token),
            ));

            $response = curl_exec($curl);
            $data = json_decode($response, true);
           
            if(isset($data['gateways'])){
                $gateway_array = [];
                foreach($data['gateways'] as $loc_value){
                    $locationGateway = Gateway::where('gateway_id',$loc_value['gatewayId'])->first();
                    if(!isset($locationGateway)){
                         $store = new Gateway;
                         $store->gateway_id = $loc_value['gatewayId'];
                         $store->gateway_name = $loc_value['gatewayName'];              
                         $store->location_id = $loc_value['locationId'];
                         $store->save();
                         array_push($gateway_array,$loc_value['gatewayId']);
                    }
                }
                $this->code = 200;
                $this->data=[
                    'status'=>"success",
                    'message'=>"All Gateway has been stored successfully",
                ];
              return redirect()->route('store_feed_by_gatewayId',['gateway_id'=>$gateway_array,'token'=>$request->token]);   
            }else{
                $this->code = 400;
                $this->data=[
                    'status'=>"error",
                    'message'=>"Gateway Not found for this location!!"
                    ];  
            }
            return response()->json($this->data, $this->code);     
    }

    public function storeFeedByGateway(Request $request){
        $feeds_array =[];
        $bearer = $request->token;
     
        foreach ($request->gateway_id as $gateway) {
            $token = "Authorization: Bearer ".$bearer;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://vision.spectra.com.sg/api/external/gateway/feeds/".$gateway,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array($token),
            ));
            $response = curl_exec($curl);
            $data = json_decode($response, true);
            if(isset($data['feeds'])){
                foreach($data['feeds'] as $value){
                    $camera = Camera::where('feed_id',$value['feedId'])->first();
                    if(!isset($camera)){                    
                         $store = new Camera;
                         $store->feed_id = $value['feedId'];
                         $store->feed_name = $value['feedName'];       
                         $store->location_id = $value['locationId'];
                         $store->gateway_id = $value['gatewayId'];
                         $store->audio = $value['audio'];
                         $store->recording = json_encode($value['recording']);
                         $store->save();
                         array_push($feeds_array,$store->feed_id);
                    }
                }
            }
            else{
                $this->code = 400;
                $this->data=[
                    'status'=>"error",
                    'message'=>"there is no feed for this gateway_id".$gateway_id,
                ];
                return response()->json($this->data, $this->code); 
            }
        }
        return redirect()->route('store_link_by_feedId',['feed_id'=>$feeds_array,'token'=>$request->token]);
        return response()->json($this->data, $this->code);     
    }

    public function viewFeedByGateway($gateway_id){
            
          $camera = Camera::select('camera.id as id','camera.feed_id','camera.feed_name','camera.location_id','camera.gateway_id','camera.audio','camera.recording','link.link_id','link.link','link.perpetual')->join('link', 'link.feed_id', '=', 'camera.feed_id')
                    ->where('gateway_id',$gateway_id)->get();

         //$camera = Camera::where('gateway_id',$gateway_id)->get();
         
     
           if(count($camera)!=0){
            $this->code = 200;
            $this->data = [
                "status"=>"success",
                "data" => $camera,
            ];
           }
           else{
            $this->code = 409;
            $this->data = [
                "status"=>"error",
                "message" =>'No feeds found..',
            ];
           } 
            return response()->json($this->data, $this->code);
    }
    public function storeLinkByfeed(Request $request){
      
       $bearer = $request->token; 
       foreach($request->feed_id as $feed_id){
            $token = "Authorization: Bearer ".$bearer;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://vision.spectra.com.sg/api/external/feed/shares/".$feed_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array($token),
            ));

            $response = curl_exec($curl);
            $data = json_decode($response, true);
            
            if(!empty($data['shareable_links'])) {
                foreach($data['shareable_links'] as $value){
                    $link = Link::where('feed_id',$value['feedId'])->first();
                    if(!isset($link)){
                    
                     $store = new Link;
                     $store->feed_id = $value['feedId'];
                     $store->link_id = $value['id'];       
                     $store->start = $value['start'];
                     $store->perpetual = $value['perpetual'];
                     $store->end = $value['end'];
                     $store->link = json_encode($value['link']);
                     $store->save();
                    }
                }
                $this->code = 200;
                $this->data=[
                    'status'=>"success",
                    'message'=>"All Link has been stored successfully",
                ];
            }
            else{
                $this->code = 400;
                $this->data=[
                    'status'=>"error",
                    'message'=>"No link for feed".$feed_id,
                ];
                return response()->json($this->data, $this->code);  
            }
        }
        return response()->json($this->data, $this->code);  
    }

    public function viewLinkByfeed($feed_id){
       $link = Link::where('feed_id',$feed_id)->get();
         
     
           if(count($link)!=0){
            $this->code = 200;
            $this->data = [
                "status"=>"success",
                "data" => $link,
            ];
           }
           else{
            $this->code = 409;
            $this->data = [
                "status"=>"error",
                "message" =>'No link found..',
            ];
           } 
            return response()->json($this->data, $this->code);
    }

    public function manualFeedEntry(Request $request){
      print_r($request->all());
      exit;
    }

    public function testPost(Request $request){
        \Log::info('Test-');
        \Log::info($request->all());
    }
    
}
