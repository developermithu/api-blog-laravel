<?php

namespace App\Filters\Posts;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class FeaturedFilter
{
    public function handle(Builder $query, Closure $next)
    {
        if (request()->has('is_featured')) {
            $query->where('is_featured', true);
        }

        return $next($query);
    }
}