<?php

namespace App\Http\Controllers\Post;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\PostService;
use App\Http\Requests\Post\{StorePostRequest, UpdatePostRequest};
use App\Models\{Post, User};
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{

    public function __construct(
        private PostService $service
    ) {
        $this->authorizeResource(Post::class, 'post');
    }

    public function store(StorePostRequest $request): Response
    {
        $data = $request->validated();

        $data['image_url'] = $this->service->uploadFile($request->file('image'), $data);
        $data['file_url']  = $this->service->uploadFile($request->file('file'), $data);

        $data['user_id'] = Auth::id();
        $post = Post::create($data);

        return response(Response::HTTP_ACCEPTED);
    }

    public function update(UpdatePostRequest $request, Post $post): Response
    {

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $this->service->deleteFile($post->image_url);

            $data['image_url'] = $this->service->uploadFile(
                $request->file('image'),
                array_merge($post->toArray(), $data)
            );
        }

        if ($request->hasFile('file')) {
            $this->service->deleteFile($post->file_url);

            $data['file_url'] = $this->service->uploadFile(
                $request->file('file'),
                array_merge($post->toArray(), $data)
            );
        }

        $post->update($data);
        $post->fresh();
        return response(Response::HTTP_OK);
    }

    public function toggleStatus(Post $post)
    {
        $this->authorize('update', User::class);
        $updatedPost = $this->service->togglePublish($post);

        $isPublished = !is_null($updatedPost->published_at);

        return response()->json([
            'published_at' => $updatedPost->published_at,
            'is_published' => $isPublished
        ], Response::HTTP_OK);
    }

    public function destroy(Post $post)
    {
        $this->service->deletePost($post);

        return response()->noContent();
    }
}
