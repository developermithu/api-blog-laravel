<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy(PostObserver::class)]
class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'is_featured',
        'author_id',
        'category_id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
            'is_featured' => 'boolean',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PostStatus::PUBLISHED)
            ->whereNull('deleted_at');
    }

    /**
     * Scope a query to only include draft posts.
     */
    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', PostStatus::DRAFT)
            ->whereNull('deleted_at');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getCoverImageAttribute()
    {
        return $this->getFirstMediaUrl('images') ?: null;
    }
}
