<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

public function edit( User $userid , User $authUser ){
        return $userid->id == $authUser->id;
}
}