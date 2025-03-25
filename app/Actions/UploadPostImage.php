<?php

namespace App\Actions;

use App\Models\Post;
use Illuminate\Http\UploadedFile;

class UploadPostImage
{
    public function execute(Post $post, ?UploadedFile $image): void
    {
        if (!$image) {
            return;
        }

        // Clear existing media if exists
        $post->clearMediaCollection('images');

        // Upload new image
        $post->addMedia($image)
            ->toMediaCollection('images', 'public_images');
    }
}
