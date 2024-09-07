<?php

namespace App\Repositories;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
	public function findDetail(int $id);

	public function findBySlug(string $slug);
}
