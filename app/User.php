<?php

namespace App;
use App\ActiveCode;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','two_factor_type' , 'phone_number','is_superuser','is_staff'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }


public function  sendEmailVerificationNotification()
{
    $this->notify( new VerifyEmail);
}




    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function activeCode()
    {
        return $this->hasMany(ActiveCode::class);
    }

    public function hasTwoFactor($key)
    {
        return $this->two_factor_type == $key;
    }

    public function hasTwoFactorAuthenticatedEnabled()
    {
        return $this->two_factor_type !== 'off';
    }
public function isSuperUser(){
return  $this->is_superuser;
}

public function isStaffUser(){
return $this->is_staff;
}

public function roles()
{
    return $this->belongsToMany(Role::class);
}

public function permissions()
{
    return $this->belongsToMany(Permission::class);
}

public function hasRole($roles)
{
    return !! $roles->intersect($this->roles)->all();
}

public function hasPermission($permission)
{
    return $this->permissions->contains('name' , $permission->name) || $this->hasRole($permission->roles);
}

}
