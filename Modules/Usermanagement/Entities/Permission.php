<?php

namespace Modules\Usermanagement\Entities;

use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
    protected $fillable = [];

     public function getPerms($category)
   {
      return $this->where(['perm_category'=>$category])->get();
   }
}
