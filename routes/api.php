<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\WebHookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServerController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();     
// Role management
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'admin'
], function ($router) {
    Route::post('/login', [ApiController::class, 'postLogin'])->name('login');
    Route::post('/change_password',[ApiController::class, 'changePassword'])->name('change_password');
    Route::post('/store_feed',[ApiController::class, 'storeFeeds'])->name('store_feed');
    Route::post('/store_feed_manually',[ApiController::class, 'storeFeedsManually'])->name('store_feed_manually');
    Route::post('/create_client',[ApiController::class, 'storeClient'])->name('store_client');
    Route::post('/create_admin',[ApiController::class, 'storeAdmin'])->name('store_admin');
    Route::post('/update_client',[ApiController::class, 'updateClient'])->name('update_client');
    Route::get('/delete_client/{id}',[ApiController::class, 'deleteClient'])->name('delete_client');
    Route::get('/delete_admin/{id}',[ApiController::class, 'deleteAdmin'])->name('delete_admin');
    Route::post('/update_admin',[ApiController::class, 'updateAdmin'])->name('update_admin');
    Route::get('/view_client',[ApiController::class, 'viewClient'])->name('view_client');
    Route::get('/view_admin/',[ApiController::class, 'viewAdmin'])->name('view_admin');
    Route::post('/get_cameras',[ApiController::class, 'getCameras'])->name('get_cameras');
    Route::post('/store_setting',[ApiController::class, 'storeSetting'])->name('store_setting');
    Route::post('/user_setting',[ApiController::class, 'userSetting']);

    // Profile
    Route::get('/my_profile',[HomeController::class, 'MyProfile'])->name('my_profile');
    Route::post('/update_profile',[HomeController::class, 'updateProfile'])->name('update_profile');
    Route::post('/forget_password',[HomeController::class, 'forgetPassword'])->name('forget_password');
    Route::post('/forget_update_password',[HomeController::class, 'forgetUpdatePassword'])->name('forget_update_password');
    
    // Role Management
    Route::get('/view_role', [ApiController::class, 'viewRole'])->name('view_role');
    Route::post('/store_role', [ApiController::class, 'storeRole'])->name('store_role');
    Route::post('/update_role', [ApiController::class, 'updateRole'])->name('update_role');
    Route::get('/delete_role/{id}', [ApiController::class, 'deleteRole'])->name('delete_role');
    

    // User Management
    Route::get('/view_user', [ApiController::class, 'viewUser'])->name('view_user');
    Route::post('/store_user', [ApiController::class, 'storeUser'])->name('store_user');
    Route::post('/update_user', [ApiController::class, 'updateUser'])->name('update_user');
    Route::get('/delete_user/{id}',[ApiController::class, 'deleteUser'])->name('delete_user');
    Route::get('/user_status/{id}', [ApiController::class, 'userStatus'])->name('user_status');
    Route::get('/logged_location', [ApiController::class, 'loggedLocation'])->name('logged_location');

    // Security Management
    Route::get('/view_security', [SecurityController::class, 'viewSecurity'])->name('view_security');
    Route::post('/store_security', [SecurityController::class, 'storeSecurity'])->name('store_security');
    Route::post('/update_security', [SecurityController::class, 'updateSecurity'])->name('update_security');
    Route::delete('/delete_security',[SecurityController::class, 'deleteSecurity'])->name('delete_security');

    // Visitor Entry Management
    Route::get('/view_visitor', [ApiController::class,'viewVisitor'])->name('view_visitor');
    Route::post('/store_newvisitor_entry', [ApiController::class,'storeNewVisitorEntry'])->name('store_new_visitor_entry');
    Route::post('/store_existingvisitor_entry', [ApiController::class,'storeExistVisitorEntry'])->name('store_exist_visitor_entry');
    Route::delete('/delete_entry', [ApiController::class,'deleteVisitorEntry'])->name('delete_entry');
    Route::get('/out_entry/{entry_id}/{delay_reason}', [ApiController::class,'outEntry']);
    Route::post('/walkIn_entry', [ApiController::class,'walkInEntry']);
    Route::post('/get_visitor_record', [ApiController::class,'getVisitorRecord']);
    Route::post('/get_visitor_record_mobile', [ApiController::class,'getVisitorRecordByMobile']);
    Route::get('/get_all_visitor', [ApiController::class,'getAllVisitor']);


    
    // WebHook Call
    Route::get('/view_location', [WebHookController::class,'viewLocation']);
    Route::get('/store_location', [WebHookController::class,'storeLocation'])->name('store_location');
    Route::get('/view_gateway/{location_id}',[WebHookController::class,'viewGateway']);
    Route::get('/store_gateway',[WebHookController::class,'storeGateway'])->name('store_gateway');
    Route::get('/store_feed_by_gatewayId',[WebHookController::class,'storeFeedByGateway'])->name('store_feed_by_gatewayId');
    Route::get('/view_feed_by_gatewayId/{gateway_id}',[WebHookController::class,'viewFeedByGateway']);
    Route::get('/store_link_by_feedId',[WebHookController::class,'storeLinkByFeed'])->name('store_link_by_feedId');
    Route::get('/view_link_by_feedId/{feed_id}',[WebHookController::class,'viewLinkByFeed']);
    Route::webhooks('paystack-webhook');
    Route::post('/set_location_session',[WebHookController::class,'setLocation']);
    Route::post('/manual_feed_entry', [WebHookController::class,'manualFeedEntry']);

    // Purpose
    Route::get('/get_purpose', [ApiController::class,'viewPurpose']);

    // Feeds and Reports
    Route::get('/get_entry_report', [ApiController::class,'getEntryReport'])->name('get_entry_report');
    Route::get('/get_unmapped_feeds/{location_id}', [ApiController::class,'getUnmappedFeeds']);
    Route::get('/reject_feed/{feed_id}', [ApiController::class,'rejectFeed']);
    Route::get('/get_entry_feeds/{location_id}', [ApiController::class,'entryFeeds']);
    // Route::get('/websockets_entryFeed/{location_id}', [ApiController::class,'webSocket_entryFeeds']);
    Route::get('/get_not_returned_visitors/{location_id}/{type}', [ApiController::class,'getNotReturnedVisitors']);
    Route::get('/get_not_returned_visitors/{location_id}', [ApiController::class,'getNotReturnedVisitors']);
    Route::get('/unmatched_inout_license/{location_id}-{searchkey}', [ApiController::class,'unMatchedInOutLicense']);
    Route::post('/download_pdf', [ApiController::class,'downloadPDF']);
    Route::get('/no_out_time_entry/{location_id}', [ApiController::class,'noOutTime']); 
    Route::post('/map_unmatchFeeds', [ApiController::class,'mapUnmatchedFeeds']);
    Route::post('/visitor_filterby_mobile', [ApiController::class,'searchByMobile']);
    Route::post('/skip_feeds', [ApiController::class,'skipFeeds']);
    Route::post('/map_feed_to_entry', [ApiController::class,'mapFeedToEntry']);
    Route::get('/wild_card/{key}/{location_id}', [ApiController::class,'wildCardSearch']);

    // BlockList
    Route::get('/block_list/{location_id}', [ApiController::class,'blockList'])->name('block_list');
    Route::get('/out_block/{id}/{delay_reason}', [ApiController::class,'outBLock'])->name('out_block');
    Route::post('/store_block', [ApiController::class,'storeBLock'])->name('store_block');
    Route::post('/edit_block/{id}', [ApiController::class,'editBLock'])->name('edit_block');
    Route::get('/delete_block/{id}', [ApiController::class,'deleteBlock'])->name('delete_block');
    Route::get('/search_block/{location_id}/{key}',[ApiController::class,'searchBlock'])->name('search_block');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    // Attendance
    Route::post('/store_attendance/', [ShiftController::class,'storeAttendance'])->name('dashboard');
    Route::get('/view_attendance/', [ShiftController::class,'viewAttendance'])->name('view_attendance');
    Route::get('/attendance_detail', [ShiftController::class,'attendanceDetail'])->name('attendance_detail');
    Route::get('/security_notification', [ShiftController::class,'securityNotification'])->name('security_notification');

    // Unit No
    Route::get('view_unit', [DashboardController::class,'viewUnit'])->name('view_unit');
    Route::post('store_unit', [DashboardController::class,'storeUnit'])->name('store_unit');
    Route::post('update_unit', [DashboardController::class,'updateUnit'])->name('update_unit');
    Route::delete('delete_unit', [DashboardController::class,'deleteUnit'])->name('delete_unit');
    Route::post('import_unit_file', [DashboardController::class,'importUnit'])->name('import_unit_file');

    // Shift
    Route::get('view_shift', [ShiftController::class,'viewShift'])->name('view_shift');
    Route::post('store_shift', [ShiftController::class,'storeShift'])->name('store_shift');
    Route::post('update_shift', [ShiftController::class,'updateShift'])->name('update_shift');
    Route::delete('delete_shift', [ShiftController::class,'deleteShift'])->name('delete_shift');

    // SMTP
     Route::get('view_smtp', [ShiftController::class,'viewSMTP'])->name('view_smtp');
     Route::post('add_smtp', [ShiftController::class,'addSMTP'])->name('add_smtp');
     Route::post('update_smtp', [ShiftController::class,'updateSMTP'])->name('update_smtp');
     Route::get('view_smtp_by_location', [ShiftController::class,'viewSMTPByLocation'])->name('update_smtp');
     Route::get('testEmail', [ShiftController::class,'securityNotification'])->name('test_email');
     Route::any('test_post', [WebHookController::class,'testPost'])->name('test_post');

     //Manual Location
      Route::post('create_location', [HomeController::class,'createLocation'])->name('create_location');
     Route::post('update_location', [HomeController::class,'updateLocation'])->name('update_location');
     Route::delete('delete_location', [HomeController::class,'deleteLocation'])->name('delete_location');

     //Manual Gateway
     Route::post('store_gateway', [HomeController::class,'storeGateway'])->name('store_gateway');
     Route::post('update_gateway', [HomeController::class,'updateGateway'])->name('update_gateway');
     Route::delete('delete_gateway', [HomeController::class,'deleteGateway'])->name('delete_gateway');

     //Manual Camera
     Route::post('store_camera', [HomeController::class,'storeCamera'])->name('store_camera');
     Route::post('store_camera_withoutGateway', [HomeController::class,'storeCameraWithoutGateway'])->name('store_camera_withoutGateway');
     Route::post('update_camera', [HomeController::class,'updateCamera'])->name('update_camera');
     Route::delete('delete_camera', [HomeController::class,'deleteCamera'])->name('delete_camera');

     //Manual Link
     Route::post('store_link', [HomeController::class,'storeLink'])->name('store_link');
     Route::post('update_link', [HomeController::class,'updateLink'])->name('update_link');
     Route::delete('delete_link', [HomeController::class,'deleteLink'])->name('delete_link');

     // Interval Feeds
     Route::post('create_feed_interval', [SecurityController::class,'storeInterval'])->name('create_feed_interval');
     Route::get('view_interval', [SecurityController::class,'viewInterval'])->name('view_interval');
     Route::post('update_interval', [SecurityController::class,'updateInterval'])->name('update_interval');
     Route::delete('delete_interval', [SecurityController::class,'deleteInterval'])->name('delete_interval');
     Route::get('get_feedBy_data', [SecurityController::class,'getFeedByDate'])->name('get_feedBy_data');

    // Local
     Route::get('trigger_cron', [ServerController::class,'triggerCron'])->name('trigger_cron');
     Route::get('get_server_entries', [ServerController::class,'serverEntries'])->name('get_server_entries');
     

    // Server 
    // Route::get('last_entry_date', [ServerController::class,'lastEntryDate'])->name('last_entry_date');
    Route::get('store_entries_server', [ServerController::class,'storeEntriesServer'])->name('store_entries_server');
    
    // Feed Delete - CRON
    Route::get('feed_delete', [ApiController::class,'feedDelete'])->name('feed_delete');
    Route::get('feed_image_zipping', [ApiController::class,'feedImageZipping'])->name('feed_image_zipping');

});


Route::group([
    'middleware' => 'api',
    'prefix' => 'mobile'
], function ($router) {
     Route::get('/dash', [SecurityController::class,'index']);
});