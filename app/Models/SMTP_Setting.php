<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMTP_Setting extends Model
{
    use HasFactory;
     use HasFactory;
    protected $table = 'smtp_setting';
    protected $primaryKey = 'id';

    public function location(){
        return $this->hasOne('App\Models\Location','id', 'location_id');
    }
}
