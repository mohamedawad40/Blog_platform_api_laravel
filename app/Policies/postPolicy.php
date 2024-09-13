<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post)
    {
        //Admins can view all posts, and authors can view their own posts.
        // logger()->info('User role: ' . $user->role);
        return $user->role === 'admin' || $post->user_id === $user->id ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'author']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post)
    {
        return $user->role === 'admin' || $post->user_id === $user->id ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post)
    {
        return $user->role === 'admin' || $post->user_id === $user->id ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post)
    {
        //
    }
}
