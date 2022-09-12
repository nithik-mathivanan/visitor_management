<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
     use HasFactory;
    protected $table = 'clients';
    protected $primaryKey = 'id';

    public function admin(){
       return $this->hasOne('App\Models\User','client_id', 'id');
    }
}
