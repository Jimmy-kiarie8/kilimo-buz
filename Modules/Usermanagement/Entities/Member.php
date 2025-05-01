<?php

namespace Modules\Usermanagement\Entities;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
	protected $table="vco_members";
    protected $fillable = [];

    public function node()
    {
    	return $this->belongsTo(NodeType::class,'node_id');
    }

    public function valuechain()
    {
    	return $this->belongsTo(ValueChain::class,'value_chain_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class,'org_id');
    }
}
