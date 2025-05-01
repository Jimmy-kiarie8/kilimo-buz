<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;


class Audit extends Model
{
    protected $table="audits";
    public function user(){
    	return $this->belongsTo(User::class,'user_id');
    }
}
