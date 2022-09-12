<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedLocal extends Model
{
    use HasFactory;
    protected $table = 'feed_local';
    protected $fillable =['feed_id','feed_name','images','license_plate_number','location_id','location_name','object_classification','time','time_zone','type','ui_type'];

}
