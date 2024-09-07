<?php

namespace App\Services;

use App\Data\CommentData;
use App\Data\PostData;
use App\Repositories\CommentRepositoryInterface;
use App\Repositories\PostRepositoryInterface;

class PostService implements PostServiceInterface
{
    protected $postRepository;
    protected $commentRepository;

    public function __construct(PostRepositoryInterface $postRepository, CommentRepositoryInterface $commentRepository)
    {
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
    }

    public function getAllPosts($page, $perPage, $searchBy, $keyword, $sortBy, $sortDirection)
    {
        $fields = ['id', 'title', 'slug', 'main_image', 'categories', 'published_at'];
        return $this->postRepository->all($page, $perPage, $searchBy, $keyword, $sortBy, $sortDirection, $fields);
    }

    public function getPostDetailById(int $id)
    {
        return $this->postRepository->findDetail($id);
    }

    public function createPost(PostData $postData)
    {
        return $this->postRepository->create($postData->toArray());
    }

    public function updatePost(int $id, PostData $postData)
    {
        return $this->postRepository->update($id, $postData->toArray());
    }

    public function deletePost(int $id)
    {
        return $this->postRepository->delete($id);
    }

    public function addCommentToPost(CommentData $commentData)
    {
        return $this->commentRepository->create($commentData->toArray());
    }
}
