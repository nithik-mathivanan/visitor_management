<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\VisitorEnrty;
use App\Models\Purpose;
use App\Models\Attendance;
use App\Models\Feed;
use App\Models\Unit;
use App\Models\Shift;
use App\Imports\UnitImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use App\Models\User;


class DashboardController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
        $from_date = $request->from_date.' '.'00:00:00';
        $to_date = $request->to_date.' '.'23:59:59';
       
       date_default_timezone_set("Asia/Singapore");

            $today_entry = VisitorEnrty::whereDate('in_time',date('Y-m-d'))->where('location_id',$request->location_id)->count();

            $today_visitor = VisitorEnrty::whereDate('in_time',date('Y-m-d'))->where('location_id',$request->location_id)->groupBy('visitor_id')->count();
    
            $today_not_returned = VisitorEnrty::whereDate('in_time',date('Y-m-d'))->where('location_id',$request->location_id)->where('in_time','!=',Null)->where('out_time',Null)->count();
        //==================================   
            $purpose_visitor = VisitorEnrty::whereBetween('in_time',[$from_date,$to_date])->where('location_id',$request->location_id)->where('visit_reason',1)->count();
            
            $purpose_delivery = VisitorEnrty::whereBetween('in_time',[$from_date,$to_date])->where('location_id',$request->location_id)->where('visit_reason',2)->count();
            
            $purpose_contractor = VisitorEnrty::whereBetween('in_time',[$from_date,$to_date])->where('location_id',$request->location_id)->where('visit_reason',3)->count();
            
            $purpose_drop_off = VisitorEnrty::whereBetween('in_time',[$from_date,$to_date])->where('location_id',$request->location_id)->where('visit_reason',4)->count();
            
            $purpose_coaching = VisitorEnrty::whereBetween('in_time',[$from_date,$to_date])->where('location_id',$request->location_id)->where('visit_reason',5)->count();
            
            $purpose_others = VisitorEnrty::whereBetween('in_time',[$from_date,$to_date])->where('location_id',$request->location_id)->where('visit_reason',6)->count();
        //===================================  
            $video_loss = Feed::whereBetween('date_time',[$from_date,$to_date])->where('location_id',$request->location_id)->where('type','video_loss')->count();
            
            $traffic = Feed::whereBetween('date_time',[$from_date,$to_date])->where('location_id',$request->location_id)->where('type','traffic')->count();

        $this->code = 200;
        $this->data = [
                    'status' => "success",
                    'data' => [
                            'today_entry'=>$today_entry,
                            'today_visitor'=>$today_visitor,
                            'today_not_returned'=>$today_not_returned,
                            'purpose_visitor'=>$purpose_visitor,
                            'purpose_delivery'=>$purpose_delivery,
                            'purpose_contractor'=>$purpose_contractor,
                            'purpose_drop_off'=>$purpose_drop_off,
                            'purpose_coaching'=>$purpose_coaching,
                            'purpose_others'=>$purpose_others,
                            'video_loss'=>$video_loss,
                            'traffic'=>$traffic,
                        ],
                    ];
        return response()->json($this->data, $this->code);
       
    }


    public function viewUnit(Request $request){
    $unit =array();
    if($request->search_key!=''){
        $search = $request->search_key;
        $data = Unit::where('location_id',$request->location_id);
        $unit = $data->where(function ($q) use ($search){
                $q->orWhere('unit.unit_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('unit.name', 'LIKE', '%' . $search . '%')
                    ->orWhere('unit.vehicle_no_1', 'LIKE', '%' . $search . '%')
                    ->orWhere('unit.vehicle_no_2', 'LIKE', '%' . $search . '%')
                    ->orWhere('unit.vehicle_no_3', 'LIKE', '%' . $search . '%')
                    ->orWhere('unit.contact_no', 'LIKE', '%' . $search . '%')
                    ->orWhere('unit.ic_number', 'LIKE', '%' . $search . '%')
                    ->orWhere('unit.location_id', 'LIKE', '%' . $search . '%');
                    })->paginate(20);
    }
    else{
       $unit = Unit::where('location_id',$request->location_id)->paginate(20);
    }
       $this->code = 200;
       $this->data = [
            'status' =>"success",
            'data'=>$unit,
        ];

        return response()->json($this->data, $this->code);
    }

    public function storeUnit(Request $request){
        $store = new Unit;
        $store->unit_name = $request->unit_name;
        $store->name = $request->name;
        $store->vehicle_no_1 = $request->vehicle_no_1;
        $store->vehicle_no_2 = $request->vehicle_no_2;   
        $store->vehicle_no_3 = $request->vehicle_no_3;
        $store->contact_no = $request->contact_no;
        $store->ic_number = $request->ic_number;
        $store->location_id = $request->location_id;
        $store->save();
        $this->code = 200;
        $this->data = [
                'status' => "success",
                'message'=>'Unit Saved!!',
            ];
        return response()->json($this->data, $this->code);
    }

    public function updateUnit(Request $request){
        
        $update = Unit::where('id',$request->unit_id)->first();
        $update->unit_name = $request->unit_name;
        $update->name = $request->name;
        $update->vehicle_no_1 = $request->vehicle_no_1;
        $update->vehicle_no_2 = $request->vehicle_no_2;   
        $update->vehicle_no_3 = $request->vehicle_no_3;
        $update->contact_no = $request->contact_no;
        $update->ic_number = $request->ic_number;
        $update->location_id = $request->location_id;
        $update->update();
        $this->code = 200;
        $this->data = [
                'status' => "success",
                'message'=>'Unit Updated!!',
            ];
        return response()->json($this->data, $this->code);
    }

    public function deleteUnit(Request $request){
        $delete = Unit::where('id',$request->unit_id)->first();
        $delete->delete();

        $this->code = 200;
        $this->data = [
                'status' => "success",
                'message'=>'Unit Deleted!!',
            ];
        return response()->json($this->data, $this->code);
    } 

    public function importUnit(Request $request){

        $excel = base64_decode($request->unit_file);
        $file_name = rand(1000, 999999).'.'.'xlsx';  
        file_put_contents('public/report_pdf/'.$file_name,$excel);
        $file_path = base_path('public/report_pdf/'.$file_name);
        $rows = Excel::toArray([],$file_path);
            
    // Records check 
       if(count($rows[0])<2){
            $this->code = 400;
            $this->data = [
                'status' => "error",
                'message'=>'No record found',
            ];
            return response()->json($this->data, $this->code);
        }
        
        // Excel to Custom Array
            foreach(array_slice($rows[0],1) as $value){
                $custom =[];
                $custom['unit_name'] = $value[0];
                $custom['name'] = $value[1];
                $custom['vehicle_no_1'] = $value[2];
                $custom['vehicle_no_2'] = $value[3];
                $custom['vehicle_no_3'] = $value[4];
                $custom['contact_no'] = $value[5];
                $custom['ic_number'] = $value[6];
                $import[]=$custom;
            }
        $check_unit = 0;
        $check_name = 0;
        $check_contact = 0;
        foreach($import as $value){
        // Unit name not null validator
            if($value['unit_name']==null){
                $this->code = 400;
                $this->data = [
                    'status' => "error",
                    'message'=>'You should give unit name for all records',
                ];
                return response()->json($this->data, $this->code);
            }
        // Name not null validator
            if($value['name']==null){
                $this->code = 400;
                $this->data = [
                    'status' => "error",
                    'message'=>'You should give name for all records',
                ];
                return response()->json($this->data, $this->code);
            }
        // Contact no not null validator
            if($value['contact_no']==null){
                $this->code = 400;
                $this->data = [
                    'status' => "error",
                    'message'=>'You should give contact no for all records',
                ];
                return response()->json($this->data, $this->code);
            }
        }
    
    // Insert to Unit Table  
        foreach($import as $data){
            $check_unit_name = Unit::where('location_id',$request->location_id)->where('unit_name',$data['unit_name'])->first();
            if(!$check_unit_name){
                $store = new Unit;
                $store->unit_name = $data['unit_name'];
                $store->name = $data['name'];
                $store->vehicle_no_1 = $data['vehicle_no_1'];
                $store->vehicle_no_2 = $data['vehicle_no_2'];   
                $store->vehicle_no_3 = $data['vehicle_no_3'];
                $store->contact_no = $data['contact_no'];
                $store->ic_number = $data['ic_number'];
                $store->location_id = $request->location_id;
                $store->save();
            }else{
                $check_unit_name->name = $data['name'];
                $check_unit_name->vehicle_no_1 = $data['vehicle_no_1'];
                $check_unit_name->vehicle_no_2 = $data['vehicle_no_2'];   
                $check_unit_name->vehicle_no_3 = $data['vehicle_no_3'];
                $check_unit_name->contact_no = $data['contact_no'];
                $check_unit_name->ic_number = $data['ic_number'];
                $check_unit_name->location_id = $request->location_id;
                $check_unit_name->update();
            }
          }

        $this->code = 200;
        $this->data = [
                'status' => "success",
                'message'=>'Excel Imports Successfully!!',
            ];
        return response()->json($this->data, $this->code);
       }   

}

