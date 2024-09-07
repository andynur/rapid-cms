<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository extends BaseRepository
{
    public function __construct(Post $post)
    {
        parent::__construct($post);
    }

    public function findDetail(int $id)
    {
        return $this->model->with(['user', 'comments'])->find($id);
    }

    public function findBySlug(string $slug)
    {
        return $this->model->select('id')->where('slug', $slug)->find();
    }
}
