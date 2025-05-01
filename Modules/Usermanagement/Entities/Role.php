<?php

namespace Modules\Usermanagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as BaseRole;
class Role extends BaseRole
{
    protected $fillable = [];
}
