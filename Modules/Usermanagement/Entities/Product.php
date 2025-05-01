<?php

namespace Modules\Usermanagement\Entities;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [];

    public function member()
    {
    	return $this->belongsTo(Member::class,'member_id');
    }
}
