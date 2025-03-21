<?php

namespace App\Filters\Posts;

use App\Enums\PostStatus;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class StatusFilter
{
    public function handle(Builder $query, Closure $next)
    {
        $status = request('status');
        $validStatuses = [PostStatus::PUBLISHED->value, PostStatus::DRAFT->value];

        if (in_array($status, $validStatuses)) {
            $query->where('status', $status);
        }

        return $next($query);
    }
}
