<?php

namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class SearchCategoryFilter
{
    public function handle(Builder $query, Closure $next)
    {
        $searchParams = trim(request('search'));

        if ($searchParams) {
            $query->whereAny(['name', 'slug'], 'like', "%$searchParams%");
        }

        return $next($query);
    }
}
