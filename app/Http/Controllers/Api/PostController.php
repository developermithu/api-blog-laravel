<?php

namespace App\Http\Controllers\Api;

use App\Actions\UploadPostImage;
use App\Filters\Posts\SearchFilter;
use App\Filters\Posts\StatusFilter;
use App\Filters\Posts\TrashFilter;
use App\Filters\Posts\FeaturedFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly UploadPostImage $uploadPostImage
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Post::class);

        $posts = Post::query()->with(['author', 'category']);

        $posts = app(Pipeline::class)
            ->send($posts)
            ->through([
                TrashFilter::class,
                StatusFilter::class,
                SearchFilter::class,
                FeaturedFilter::class,
            ])
            ->thenReturn()
            ->latest()
            ->paginate(6);

        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request): PostResource
    {
        $this->authorize('create', Post::class);

        $data = $request->validated();
        $post = auth()->user()->posts()->create($data);

        $this->uploadPostImage->execute($post, $request->file('cover_image'));

        return new PostResource($post->load(['author', 'category']));
    }

    public function show(Post $post): PostResource
    {
        $this->authorize('view', $post);

        return new PostResource($post->load(['author', 'category']));
    }

    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $this->authorize('update', $post);

        $post->update($request->validated());
        $this->uploadPostImage->execute($post, $request->file('cover_image'));

        return new PostResource($post->load(['author', 'category']));
    }

    public function destroy(Post $post): JsonResponse
    {
        $this->authorize('delete', $post);

        $post->delete();
        return response()->json(['message' => 'Post deleted successfully'], 200);
    }

    public function restore($id): JsonResponse
    {
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('restore', $post);

        $post->restore();
        return response()->json(['message' => 'Post restored successfully']);
    }

    public function forceDelete($id): JsonResponse
    {
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $post);

        $post->forceDelete();
        return response()->json(['message' => 'Post permanently deleted']);
    }
}
