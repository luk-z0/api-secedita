<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;


class PostService
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function uploadFile($file, array $folder): string | null
    {
        if (!$file || !$file->isValid()) return null;

        $typeFolder = str_contains($file->getMimeType(), 'image') ? 'images' : 'attachments';

        $fullPath = "posts/" . Str::slug($folder['category']);
        if (!empty($folder['sub_category'])) $fullPath .= "/" . Str::slug($folder['sub_category']);
        if (!empty($folder['department'])) $fullPath .= "/" . Str::slug($folder['department']);

        $fullPath .= "/{$typeFolder}";

        $savedPath = Storage::put($fullPath, $file);

        return Storage::url($savedPath);
    }

    public function deleteFile(?string $url): void
    {
        if (!$url) return;

        $path = parse_url($url, PHP_URL_PATH);
        $path = str_replace("/storage/v1/object/public/" . env('SUPABASE_BUCKET') . "/", "", $path);

        Storage::delete($path);
    }

    public function togglePublish(Post $post): Post
    {
        $newStatus = $post->published_at ? null : now();

        $post->update([
            'published_at' => $newStatus
        ]);

        return $post;
    }

    public function getPublicPosts(array $filters = []): LengthAwarePaginator
    {
        return Post::published()
            ->ofCategory($filters['category'] ?? null)
            ->byAuthor($filters['author_id'] ?? null)
            ->with(['user:id,name'])
            ->paginate(Post::PAGINATION_LIMIT);
    }

    public function deletePost(Post $post): bool
    {
        if ($post->image_url)  $this->deleteFile($post->image_url);

        if ($post->file_url) $this->deleteFile($post->file_url);

        return $post->delete();
    }
}
