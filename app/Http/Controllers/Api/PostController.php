<?php

namespace App\Http\Controllers\Api;

use App\Actions\UploadPostImage;
use App\Enums\PostStatus;
use App\Filters\Posts\SearchFilter;
use App\Filters\Posts\StatusFilter;
use App\Filters\Posts\TrashFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pipeline\Pipeline;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    public function __construct(
        private readonly UploadPostImage $uploadPostImage
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $posts = Post::query()->with(['author', 'category']);

        $posts = app(Pipeline::class)
            ->send($posts)
            ->through([
                TrashFilter::class,
                StatusFilter::class,
                SearchFilter::class,
            ])
            ->thenReturn()
            ->latest()
            ->paginate(6);

        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request): PostResource
    {
        $data = $request->validated();
        $post = auth()->user()->posts()->create($data);

        $this->uploadPostImage->execute($post, $request->file('cover_image'));

        return new PostResource($post->load(['author', 'category']));
    }

    public function show(Post $post): PostResource
    {
        // Only published posts are visible to public, drafts visible to authors
        if ($post->status !== PostStatus::PUBLISHED && !auth()->user()?->isAdmin()) {
            throw new NotFoundHttpException('Post not found');
        }

        return new PostResource($post->load(['author', 'category']));
    }

    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $post->update($request->validated());

        $this->uploadPostImage->execute($post, $request->file('cover_image'));

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
