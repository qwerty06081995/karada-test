<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = $request->user()->tasks()->orderBy('priority','desc')->get();
        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $data = $request->only(['title','description','status','priority','due_date','karada_project']);
        $task = $request->user()->tasks()->create($data);
        return response()->json($task, 201);
    }

    public function show(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Запрещено'], 403);
        }
        return response()->json($task);
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Запрещено'], 403);
        }
        $data = $request->only(['title','description','status','priority','due_date','karada_project']);
        $task->update($data);
        return response()->json($task);
    }

    public function destroy(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Запрещено'], 403);
        }
        $task->delete();
        return response()->json(['message' => 'Удален']);
    }
}
