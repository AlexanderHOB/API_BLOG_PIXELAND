<?php

namespace App\Policies;

use App\Post;
use App\User;
use App\Reader;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization,AdminActions;

   
    public function update(User $user, Post $post)
    {
        return $user->id == $post->writter->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reader  $reader
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        return $user->id == $post->writter->id;
        
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reader  $reader
     * @return mixed
     */
    public function restore(User $user, Reader $reader)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reader  $reader
     * @return mixed
     */
    public function forceDelete(User $user, Reader $reader)
    {
        //
    }
}
