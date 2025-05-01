<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Mymodel extends Model implements AuditableContract
{
    
    protected $rules = array();
    protected  $messages = array();
      use Auditable;
    use SoftDeletes;


    protected $errors;

    public function validate($data)
    {
        // make a new validator object
        $v = Validator::make($data, $this->rules,$this->messages);

        // check for failure
        if ($v->fails())
        {
            // set errors and return false
            //$this->errors = $v->errors();
            $this->setErrors($v->messages());
            return false;
        }

        // validation pass
        return true;
    }

    public function errors()
    {
        return $this->errors;
    }

  protected function setErrors($errors)
    {
        $this->errors = $errors;
        return $this->errors;

    }
}
