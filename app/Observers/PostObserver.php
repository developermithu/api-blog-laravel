<?php

namespace App\Observers;

use App\Models\Post;
use App\Enums\PostStatus;
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
     * Handle the Post "updating" event.
     */
    public function updating(Post $post): void
    {
        $post->updated_at = now();
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
     * Handle the Post "deleting" event.
     * Update status to draft and remove featured flag 
     */
    public function deleting(Post $post): void
    {
        $post->update([
            'status' => PostStatus::DRAFT,
            'is_featured' => false
        ]);
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
        $post->update([
            'status' => PostStatus::PUBLISHED
        ]);
    }

    /**
     * Handle the Post "force deleted" event.
     * Clean up any associated media when post is permanently deleted
     */
    public function forceDeleted(Post $post): void
    {
        $post->clearMediaCollection('images');
    }
}
