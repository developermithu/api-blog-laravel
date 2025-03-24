<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        $post->updated_at = now();
        $post->save();
    }

    /**
     * Handle the Post "saving" event.
     */
    public function saving(Post $post): void
    {
        if ($post->is_featured) {
            DB::transaction(function () use ($post) {
                Post::where('id', '!=', $post->id)
                    ->where('is_featured', true)
                    ->update(['is_featured' => false]);
            });
        }
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
