<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function joblistingComponent()
    {
        return view('driver.job_list');
    }

    public function updateStatus(Request $request, $taskId)
    {
        $updated = $this->taskService->updateStatus($taskId, $request->new_status);

        if ($updated) {
            return redirect()->route('tasks.index')->with('success', 'Task status updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update task status.');
        }
    }

    public function create(CreateTaskRequest $request)
    {
        $createdTask = $this->taskService->createTask($request->all());

        if ($createdTask) {
            return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create task.');
        }
    }
}
