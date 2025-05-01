<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Usermanagement\Entities\County;
 use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;
use Modules\Usermanagement\Entities\Profile;
use Modules\Usermanagement\Entities\Station;
use Modules\Usermanagement\Entities\Orgainization;
use Modules\Usermanagement\Entities\Branch;
use Carbon\Carbon;


class User extends Authenticatable implements Auditable
{
    use Notifiable,HasRoles,\OwenIt\Auditing\Auditable;


   
   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sirname', 'email', 'password','telephone','username','confirmed_at','firstname','role_id','user_type','org_id','verification_code'
    ];


    protected $auditExclude = [
        'remember_token',
        'Password',
    ];



    public static function resolveId()
    {
        return Auth::check() ? Auth::user()->getAuthIdentifier() : null;
    }


    

    public function county()
    {
        return $this->belongsTo(County::class,'county_id');
    }


    public function station()
    {
      return $this->belongsTo(County::class,'org_id','CountyCode');
    }


    public function getRemainingDaysAttribute()
{

    if ($this->password_expiry) {
        $remaining_days = Carbon::now()->diffInDays(Carbon::parse($this->password_expiry));
    } else {
        $remaining_days = 0;
    }
    return $remaining_days;
}



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



     public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

     public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function setPasswordExpiryAttribute($value)
    {
         
        $this->attributes['password_expiry'] =date('Y-m-d', strtotime(date('Y-m-d'). ' + 60 days'));
    }
}
