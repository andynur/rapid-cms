<?php

namespace App\Services;

use App\Data\CommentData;
use App\Data\PostData;

interface PostServiceInterface
{
	public function getAllPosts(
		$page,
		$perPage,
		$searchBy,
		$keyword,
		$sortBy,
		$sortDirection
	);

	public function getPostDetailById(int $id);

	public function createPost(PostData $postData);

	public function updatePost(int $id, PostData $postData);

	public function deletePost(int $id);

	public function addCommentToPost(CommentData $commentData);
}
