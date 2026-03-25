<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use App\Http\Requests\Post\GetPublicPostsRequest;

class PostPublicController extends Controller
{
    public function __construct(private PostService $service) {}

    public function index(GetPublicPostsRequest $request)
    {
        $filters = $request->only(['category', 'author_id']);

        $posts = $this->service->getPublicPosts($request->category);

        return response()->json($posts);
    }
}
