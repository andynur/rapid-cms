<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function all(
        int $page,
        int $perPage,
        ?string $searchBy,
        ?string $keyword,
        ?string $sortBy,
        string $sortDirection,
        array $fields,
    );

    public function find(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}
