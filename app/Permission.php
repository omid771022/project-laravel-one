<?php

namespace App;

use App\Role;
use App\User;
use Illuminate\Database\Eloquent\Model;


class Permission extends Model
{
protected $fillable =['name' , 'label'];
  
public function users(){
  
    return $this->belongsToMany(User::class);
}
public function roles(){
    return $this->belongsToMany(Role::class);
}

}
