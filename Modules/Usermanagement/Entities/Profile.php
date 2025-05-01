<?php

namespace Modules\Usermanagement\Entities;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Profile extends Model
{
    protected $fillable = [];

    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }

     public function dep()
    {
    	return $this->belongsTo(Department::class,'department_id');
    }
}
