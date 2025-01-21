<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAll(): Collection
    {
        return Task::all();
    }

    public function getById(int $id): ?Task
    {
        return Task::find($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(int $id, array $data): bool
   {
        $task = Task::find($id);
        if($task) {
            return $task->update($data);
        }
        return false;
   }

   public function delete(int $id): bool
    {
        $task = Task::find($id);
         if($task) {
            return $task->delete();
         }
        return false;
    }
}