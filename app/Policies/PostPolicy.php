<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

/**
 * Dibuat dengan: php artisan make:policy PostPolicy --model=Post
 *
 * Aturan otorisasi:
 * - admin  : boleh edit & hapus post siapa saja.
 * - editor : boleh edit & hapus HANYA post miliknya sendiri.
 * - user   : tidak boleh edit/hapus post sama sekali.
 */
class PostPolicy
{
    public function update(User $user, Post $post): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isEditor() && $post->user_id === $user->id;
    }

    public function delete(User $user, Post $post): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isEditor() && $post->user_id === $user->id;
    }
}
