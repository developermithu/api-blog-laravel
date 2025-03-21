<?php

namespace App\Http\Controllers\Api;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $filter = request('filter', 'all');
        
        $posts = Post::with(['author', 'category'])
            ->when($filter === 'trash', function ($query) {
                $query->onlyTrashed();
            })
            ->when($filter === 'all', function ($query) {
                $query->withoutTrashed();
            })
            ->latest()
            ->paginate(6);

        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request): PostResource
    {
        $data = $request->validated();
        $post = auth()->user()->posts()->create($data);

        if ($request->hasFile('cover_image')) {
            $post->addMediaFromRequest('cover_image')
                ->toMediaCollection('images');
        }

        return new PostResource($post->load(['author', 'category']));
    }

    public function show(Post $post): PostResource
    {
        if ($post->status !== PostStatus::PUBLISHED) {
            throw new NotFoundHttpException('Post not found');
        }

        return new PostResource($post->load(['author', 'category']));
    }

    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $post->update($request->validated());

        if ($request->hasFile('cover_image')) {
            // Clear existing media in the collection
            $post->clearMediaCollection('images');
            
            // Add new media
            $post->addMediaFromRequest('cover_image')
                ->toMediaCollection('images');
        }

        return new PostResource($post->load(['author', 'category']));
    }

    public function destroy(Post $post): JsonResponse
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully'], 200);
    }

    public function restore($id): JsonResponse
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        return response()->json(['message' => 'Post restored successfully']);
    }

    public function forceDelete($id): JsonResponse
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->clearMediaCollection('images');
        $post->forceDelete();
        
        return response()->json(['message' => 'Post permanently deleted']);
    }
}
