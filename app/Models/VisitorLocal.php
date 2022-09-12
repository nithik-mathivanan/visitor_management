<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLocal extends Model
{
    use HasFactory;
    protected $table = 'visitors_local';
    protected $primaryKey = 'visitor_id';
   
    protected $fillable = [
        'visitor_name',
        'ic_nuumber',
        'contact_person',
        'purpose_visit',
    ];
}
