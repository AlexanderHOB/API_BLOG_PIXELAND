<?php

namespace App\Policies;

use App\User;
use App\Reader;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReaderPolicy
{
    use HandlesAuthorization,AdminActions;

   
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reader  $reader
     * @return mixed
     */
    public function view(User $user, Reader $reader)
    {

        return $user->id === $reader->id;
    }

    public function create(User $user, Reader $reader)
    {
        return $user->id === $reader->id;
    }

   
}
