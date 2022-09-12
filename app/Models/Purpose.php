<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    use HasFactory;
    protected $table = 'purpose';
    protected $primaryKey = 'visitor_id';
   
    protected $fillable = [
        'visitor_name',
        'vehicle_no',
        'ic_nuumber',
        'contact_person',
        'purpose_visit',
    ];
}
