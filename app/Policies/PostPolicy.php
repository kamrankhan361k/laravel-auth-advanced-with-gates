<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('editor') || $user->hasRole('author');
    }

    public function view(User $user, Post $post)
    {
        if ($user->hasRole('admin') || $user->hasRole('editor')) {
            return true;
        }

        return $user->id === $post->user_id;
    }

    public function create(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('editor') || $user->hasRole('author');
    }

    public function update(User $user, Post $post)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('editor')) {
            return true;
        }

        return $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->id === $post->user_id;
    }

    public function publish(User $user, Post $post)
    {
        return $user->hasRole('admin') || $user->hasRole('editor');
    }

    public function restore(User $user, Post $post)
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Post $post)
    {
        return $user->hasRole('admin');
    }
}
