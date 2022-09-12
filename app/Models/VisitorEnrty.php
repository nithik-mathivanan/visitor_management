<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorEnrty extends Model
{
    use HasFactory;
    protected $table = 'entry';
    protected $primaryKey = 'id';
   
    protected $fillable = [
        'visitor_name',
        'vehicle_no',
        'ic_nuumber',
        'contact_person',
        'purpose_visit',
    ];

    public function getVisitor(){
        return $this->hasOne('App\Models\Visitor', 'visitor_id', 'visitor_id');
    }

    public function visitReason(){
       return $this->hasOne('App\Models\Purpose', 'purpose_id', 'visit_reason');
    }

    public function entryFeed(){
       return $this->hasOne('App\Models\Feed','id', 'entry_feed');
    }
    public function exitFeed(){
       return $this->hasOne('App\Models\Feed','id', 'exit_feed');
    }
}
