<?php

namespace App\Filters\Posts;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class SearchFilter
{
    public function handle(Builder $query, Closure $next)
    {
        $searchParams = trim(request('search'));

        if ($searchParams) {
            $query->whereAny(['title', 'slug', 'content'], 'like', "%$searchParams%")
                ->orWhereHas('category', function ($query) use ($searchParams) {
                    $query->whereAny(['name', 'slug'], 'like', "%$searchParams%");
                });
        }

        return $next($query);
    }
}
