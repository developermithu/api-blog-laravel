<?php

namespace App\Http\Controllers\Api;

use App\Filters\SearchCategoryFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Pipeline\Pipeline;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Category::class);

        $categories = Category::query()->withCount('posts');

        $categories = app(Pipeline::class)
            ->send($categories)
            ->through([
                SearchCategoryFilter::class,
            ])
            ->thenReturn()
            ->latest()
            ->paginate(6);

        return CategoryResource::collection($categories);
    }

    public function store(CategoryRequest $request): CategoryResource
    {
        $this->authorize('create', Category::class);

        $category = Category::create($request->validated());
        return new CategoryResource($category);
    }

    public function show(Category $category): CategoryResource
    {
        $this->authorize('view', $category);

        return new CategoryResource($category->loadCount('posts'));
    }

    public function update(CategoryRequest $request, Category $category): CategoryResource
    {
        $this->authorize('update', $category);

        $category->update($request->validated());
        return new CategoryResource($category);
    }

    public function destroy(Category $category): JsonResponse|Response
    {
        $this->authorize('delete', $category);

        try {
            $category->delete();
            return response()->noContent();
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') { // Foreign key violation
                return response()->json([
                    'message' => 'This category cannot be deleted because it has associated posts.',
                ], 409);
            }
            throw $e;
        }
    }
}
