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
        try {
            $tasks = $this->taskRepository->getAll();
            return response()->json(['message' => 'Success', 'data' => $tasks], Response::HTTP_OK);
        } catch (Exception $e) {
           return response()->json(['message' => 'Error fetching tasks', 'error' => $e->getMessage()], 
           Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function show(int $id): JsonResponse
    {
        try {
        $task = $this->taskRepository->getById($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['message' => 'Success','data' => $task], Response::HTTP_OK);
    } catch (Exception $e) {
       return response()->json(['message' => 'Error fetching tasks', 'error' => $e->getMessage()], 
       Response::HTTP_INTERNAL_SERVER_ERROR);
    }
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
        try {
        $task = $this->taskRepository->create($request->all());
        return response()->json(['message' => 'Task Created Succesfully', 'data' => $task], Response::HTTP_CREATED);
    } catch (Exception $e) {
       return response()->json(['message' => 'Error creating tasks', 'error' => $e->getMessage()], 
       Response::HTTP_INTERNAL_SERVER_ERROR);
    }
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

        try {

         $updated = $this->taskRepository->update($id, $request->all());

        if(!$updated){
             return response()->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

         return response()->json(['message' => 'Task updated successfully'], Response::HTTP_OK);

    } catch (Exception $e) {
        return response()->json(['message' => 'Error updating tasks', 'error' => $e->getMessage()], 
        Response::HTTP_INTERNAL_SERVER_ERROR);
     }
    }
    
    public function destroy(int $id): JsonResponse
    {
        try {
         $deleted = $this->taskRepository->delete($id);

        if (!$deleted) {
           return response()->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['message' => 'Task deleted successfully'], Response::HTTP_OK);

    } catch (Exception $e) {
        return response()->json(['message' => 'Error deleting tasks', 'error' => $e->getMessage()], 
        Response::HTTP_INTERNAL_SERVER_ERROR);
     }
    }
}