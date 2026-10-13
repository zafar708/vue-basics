<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine whether the user can create posts.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create posts');
    }

    /**
     * Determine whether the user can update the post: any post with
     * "edit posts", or only their own post with "edit own posts".
     */
    public function update(User $user, Post $post): bool
    {
        return $user->checkPermissionTo('edit posts')
            || ($user->checkPermissionTo('edit own posts') && $post->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the post: any post with
     * "delete posts", or only their own post with "delete own posts".
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->checkPermissionTo('delete posts')
            || ($user->checkPermissionTo('delete own posts') && $post->user_id === $user->id);
    }
}
