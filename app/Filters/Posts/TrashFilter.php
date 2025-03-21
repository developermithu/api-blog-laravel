<?php

namespace App\Filters\Posts;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class TrashFilter
{
    public function handle(Builder $query, Closure $next)
    {
        $filter = request('filter', 'all');

        if ($filter === 'trash') {
            $query->onlyTrashed();
        } elseif ($filter === 'all') {
            $query->withoutTrashed();
        }

        return $next($query);
    }
}
