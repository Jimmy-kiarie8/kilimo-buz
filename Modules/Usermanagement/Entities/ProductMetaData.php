<?php

namespace Modules\Usermanagement\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductMetaData extends Model
{
	protected $table="productnames_metadatas";
    protected $guarderd = ['id'];
}
