<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getRoleInfoByUserId($user_id){
        $roleID = User::where('user_id',$user_id)->select('role_id')->first();
        $roleInfo = Role::where('id',$roleID->role_id)->first();
       
        return ['role'=>$roleInfo];
    }

   
}
