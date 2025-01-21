<?php

namespace Tests\Feature\Api;

use App\Models\Task;
use Database\Factories\TaskFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TaskTest extends TestCase
{
     use RefreshDatabase;

    public function test_can_list_tasks()
    {
        Task::factory()->count(3)->create();
        $this->getJson('/api/tasks')
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) =>
            $json->has('data', 3)
         );
    }

public function test_can_get_a_single_task()
{
     $task = Task::factory()->create();

     $this->getJson('/api/tasks/' . $task->id)
          ->assertStatus(200)
          ->assertJson(fn(AssertableJson $json) =>
            $json->where('data.id', $task->id)
            ->etc()
         );
}

public function test_cannot_get_a_single_task_if_not_exist()
{
    $this->getJson('/api/tasks/99')
        ->assertStatus(404)
        ->assertJsonPath('message','Task not found');
}

public function test_can_create_task()
{
    $taskData = Task::factory()->make()->toArray();
    $this->postJson('/api/tasks',$taskData)
        ->assertStatus(201)
        ->assertJson(fn(AssertableJson $json) =>
            $json->has('data.id')
                 ->etc()
            );
        $this->assertDatabaseHas('tasks', $taskData);
}

 public function test_cannot_create_task_if_validation_failed()
 {
     $taskData = [];

      $this->postJson('/api/tasks',$taskData)
           ->assertStatus(422)
           ->assertJson(fn(AssertableJson $json) =>
               $json->has('errors.title')
          );
}

public function test_can_update_task()
{
    $task = Task::factory()->create();
    $taskData = Task::factory()->make()->toArray();

    $this->putJson('/api/tasks/' . $task->id,$taskData)
        ->assertStatus(200)
        ->assertJsonPath('message', 'Task updated successfully');
     $this->assertDatabaseHas('tasks', $taskData);
}

public function test_cannot_update_task_if_not_exist()
{
    $taskData = Task::factory()->make()->toArray();

     $this->putJson('/api/tasks/99',$taskData)
        ->assertStatus(404)
        ->assertJsonPath('message','Task not found');
}

 public function test_cannot_update_task_if_validation_failed()
 {
     $task = Task::factory()->create();
     $taskData = ['completed' => 'not a boolean'];
      $this->putJson('/api/tasks/' . $task->id,$taskData)
           ->assertStatus(422)
           ->assertJson(fn(AssertableJson $json) =>
               $json->has('errors.completed')
          );
 }


   public function test_can_delete_task()
    {
        $task = Task::factory()->create();

        $this->deleteJson('/api/tasks/' . $task->id)
             ->assertStatus(200)
             ->assertJsonPath('message', 'Task deleted successfully');
         $this->assertDatabaseMissing('tasks',['id' => $task->id]);
    }

    public function test_cannot_delete_task_if_not_exist()
     {
        $this->deleteJson('/api/tasks/99')
            ->assertStatus(404)
            ->assertJsonPath('message','Task not found');
    }
}