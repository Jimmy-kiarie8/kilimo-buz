<?php

namespace Modules\Usermanagement\Entities;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Staff extends Model
{
	 protected $table="staffs";
    protected $fillable = [];
    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
}
