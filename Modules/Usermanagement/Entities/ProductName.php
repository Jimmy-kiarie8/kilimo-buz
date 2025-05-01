<?php

namespace Modules\Usermanagement\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Upload;
class ProductName extends Model
{
    protected $fillable = [];

    public function coverImage()
    {
      return $this->belongsTo(Upload::class,'product_image');
    }
}
