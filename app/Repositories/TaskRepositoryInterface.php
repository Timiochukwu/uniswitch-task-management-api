<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;


interface TaskRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Task;
    public function create(array $data) : Task;
    public function update(int $id, array $data) : bool;
    public function delete(int $id): bool;
}