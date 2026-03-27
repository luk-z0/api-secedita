<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Model, SoftDeletes};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    const PAGINATION_LIMIT = 20;

    protected $fillable = [
        'title',
        'summary',
        'content',
        'image_url',
        'file_url',
        'category',
        'sub_category',
        'department',
        'status',
        'published_at',
        'user_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at');
    }

    public function scopeOfCategory(Builder $query, ?string $category): Builder
    {
        return $query->when($category, fn($q) => $q->where('category', $category));
    }

    public function scopeFindPublished(Builder $query, int $id): Builder
    {
        return $query->published()->where('id', $id);
    }

    public function scopeByAuthor(Builder $query, ?int $userId): Builder
    {
        return $query->when($userId, fn($q) => $q->where('user_id', $userId));
    }


}
