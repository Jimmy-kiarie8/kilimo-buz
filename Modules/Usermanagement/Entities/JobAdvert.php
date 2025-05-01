<?php

namespace Modules\Usermanagement\Entities;

use Illuminate\Database\Eloquent\Model;

class JobAdvert extends Model
{
    protected $fillable = [];

    public function jobgroup()
    {
    	return $this->belongsTo(JobGroup::class,'job_group_id');
    }

     public function department()
    {
    	return $this->belongsTo(Department::class,'dep_id');
    }

    public function jobqualification()
    {
      return $this->belongsTo(Qualification::class,'qualification_id');
    }
}
