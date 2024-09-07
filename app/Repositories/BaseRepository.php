<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(
        int $page = 1,
        int $perPage = 10,
        string|null $searchBy = null,
        string|null $keyword = null,
        string|null $sortBy = null,
        string $sortDirection = 'asc',
        array $fields = ['*']
    ) {
        $query = $this->model->query();

        if ($searchBy && $keyword) {
            $query->where($searchBy, 'like', '%' . $keyword . '%');
        }

        if ($sortBy) {
            $query->orderBy($sortBy, $sortDirection);
        }

        return $query->paginate($perPage, $fields, 'page', $page);
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    public function delete(int $id)
    {
        $record = $this->find($id);
        return $record->delete();
    }
}
