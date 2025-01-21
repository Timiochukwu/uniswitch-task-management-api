<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    private $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

     public function index(): JsonResponse
    {
        $tasks = $this->taskRepository->getAll();
        return response()->json(['data' => $tasks], Response::HTTP_OK);
    }


    public function show(int $id): JsonResponse
    {
        $task = $this->taskRepository->getById($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['data' => $task], Response::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
          $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $task = $this->taskRepository->create($request->all());
        return response()->json(['data' => $task], Response::HTTP_CREATED);
    }
    
    public function update(Request $request, int $id): JsonResponse
    {
          $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean'
        ]);

         if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

         $updated = $this->taskRepository->update($id, $request->all());

        if(!$updated){
             return response()->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

         return response()->json(['message' => 'Task updated successfully'], Response::HTTP_OK);
    }
    
    public function destroy(int $id): JsonResponse
    {
         $deleted = $this->taskRepository->delete($id);

        if (!$deleted) {
           return response()->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['message' => 'Task deleted successfully'], Response::HTTP_OK);
    }
}