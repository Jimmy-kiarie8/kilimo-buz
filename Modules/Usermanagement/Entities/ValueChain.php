<?php

namespace Modules\Usermanagement\Entities;

use Illuminate\Database\Eloquent\Model;

class ValueChain extends Model
{
    protected $fillable = [];

    public function uom()
    {
    	return $this->belongsTo(UnitOfMeasure::class,'uom_id');
    }
}
