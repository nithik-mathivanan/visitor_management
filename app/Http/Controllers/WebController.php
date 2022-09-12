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
class WebController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function recent_feeds(){
        $brownstone = Feed::where('location_id','61c1bb102c679d1f3e946011')->orderBy('id','DESC')->take(10)->get();
        $rivervale = Feed::where('location_id','625d697b540f6015daf77f3f')->orderBy('id','DESC')->take(10)->get();
        $tembusu = Feed::where('location_id','61c598bb2c679d1f3e992866')->orderBy('id','DESC')->take(10)->get();
        $trillium = Feed::where('location_id','62843f4a540f6015da77f459')->orderBy('id','DESC')->take(10)->get();
       
        return view('home')->with([
            'brownstone'=>$brownstone,
            'rivervale'=>$rivervale,
            'tembusu'=>$tembusu,
            'trillium'=>$trillium,
        ]);
    }
    
}

