<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
	protected $table="system_logs";
    //

    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
}
