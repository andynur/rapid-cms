<?php

namespace App\Http\Controllers;

use App\Data\PostData;
use App\Http\Requests\PostRequest;
use App\Services\PostService;
use App\Helpers\JsonResponse;
use App\Helpers\PaginationHelper;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $page       = $request->query('page', 1);
        $perPage    = $request->query('per_page', 10);
        $searchBy   = $request->query('search_by');
        $keyword    = $request->query('keyword');
        $sortBy     = $request->query('sort_by', 'id');
        $sortOrder  = $request->query('sort_order', 'asc');

        $posts = $this->postService->getAllPosts($page, $perPage, $searchBy, $keyword, $sortBy, $sortOrder);
        $meta = PaginationHelper::meta($posts);

        return JsonResponse::success(PostResource::collection($posts)->collection, 'Posts retrieved successfully', $meta);
    }

    public function show(int $id)
    {
        $post = $this->postService->getPostDetailById($id);
        if (!$post) {
            return JsonResponse::notFound('Post not found');
        }

        return JsonResponse::success(new PostDetailResource($post), 'Post retrieved successfully');
    }

    public function store(PostRequest $request)
    {
        $postData = $request->toData();
        $postData->user_id = $request->user()->id;
        $post = $this->postService->createPost($postData);

        return JsonResponse::created(new PostResource($post), 'Post created successfully');
    }

    public function update(PostRequest $request, Post $post)
    {
        $postData = PostData::from($request->validated());
        $postData->user_id = $request->user()->id;

        $postUpdate = $this->postService->updatePost($post->id, $postData);
        if (!$postUpdate) {
            return JsonResponse::notFound('Post not found');
        }

        return JsonResponse::success(new PostResource($postUpdate), 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        $this->postService->deletePost($post->id);

        return JsonResponse::success(null, 'Post deleted successfully');
    }

    public function comment(Post $post, CommentRequest $request)
    {
        $commentData = $request->toData();
        $commentData->post_id = $post->id;
        $comment = $this->postService->addCommentToPost($commentData);

        return JsonResponse::created(new CommentResource($comment), 'Comment created successfully');
    }
}
