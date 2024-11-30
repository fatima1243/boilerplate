<?php

namespace App\Http\Controllers\Apis\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Models\Recruiter;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function App\Helpers\returnToApi;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function createTask(CreateTaskRequest $request)
    {
        DB::beginTransaction();
        try {
            $requestData = $request->all();
            $requestData['user_id'] = auth()->id();
            $requestData['is_assigned'] = false;
            $return_object = $this->taskService->createTask($requestData);
            DB::commit();
            return returnToApi('success', 'Task created successfully.', $return_object);
        } catch (\Exception $e) {
            DB::rollBack();
            return returnToApi('error', 'Failed to get data.' . ' ' . $e->getMessage());
        }
    }

    public function updateTask(CreateTaskRequest $request)
    {
        DB::beginTransaction();
        try {
            $requestData = $request->all();
            $requestData['user_id'] = auth()->id();
            $return_object = $this->taskService->updateTask($requestData);
            DB::commit();
            return returnToApi('success', 'Task Update successfully.', $return_object);
        } catch (\Exception $e) {
            DB::rollBack();
            return returnToApi('error', 'Something went wrong please try again later');
        }
    }

    public function getAllTask($userId,Request $request)
    {
        $user = Recruiter::findOrFail($userId);
        $return_object = $this->taskService->getAllTask($request, $user);
        return returnToApi('success', 'Tasks fetched successfully.', $return_object);
    }

    public function getTaskById($id)
    {
        return view('driver.jobDetails');
        // $return_object = $this->taskService->getTaskById($id);
        // return returnToApi('success', 'Task fetched successfully.', $return_object);
    }



    public function getAllTaskList(Request $request)
    {
        $return_object = $this->taskService->getAllTaskList($request);
        return returnToApi('success', 'Tasks fetched successfully.', $return_object);
    }

    public function getDetailJob($id)
    {
        $return_object = $this->taskService->getDetailJob($id);
        return returnToApi('success', 'Job fetched successfully.', $return_object);
    }


    public function getTaskGallery($id)
    {
        $return_object = $this->taskService->getTaskGallery($id);
        return returnToApi('success', 'Task gallery fetched successfully.', $return_object);
    }

    public function deleteTask($id)
    {
        try {
            $return_object = $this->taskService->deleteTask($id);
            return returnToApi('success', 'Task deleted successfully.', $return_object);
        } catch (\Throwable $th) {
            return returnToApi('error', 'Something went wrong.' . ' ' . $th->getMessage());
        }
    }

    // public function createChatRoom(CreateRoomRequest $request)
    // {
    //     try {
    //         $return_object = $this->taskService->createChatRoom($request);
    //         return returnToApi('success', 'Chat room created successfully.', $return_object);
    //     } catch (\Throwable $th) {
    //         return returnToApi('error', 'Something went wrong.' . ' ' . $th->getMessage());
    //     }
    // }

    public function getTaskDetailById($id): object
    {
        $return_object = $this->taskService->getTaskDetailById($id);
        return returnToApi('success', 'Task fetched successfully.', $return_object);
    }



    // public function checkStripeCard()
    // {
    //     if (Card::where('user_id', auth()->id())->first()) {
    //         return returnToApi('success', 'Card found.', ['is_card_found' => true]);
    //     } else {
    //         return returnToApi('error', 'Please add your card first.', ['is_card_found' => false]);
    //     }
    // }

    public function isExistTasks()
    {
        $return_object = $this->taskService->isExistTasks();
        return returnToApi('success', 'Task fetched successfully.', ['is_exist_task' => $return_object]);
    }

    public function currentJOb()
    {
        $return_object = $this->taskService->currentJOb();
        return returnToApi('success', 'Successfully.', $return_object);
    }

    public function jobHistories(Request $request)
    {
        $return_object = $this->taskService->jobHistories($request);
        return returnToApi('success', 'Successfully.', $return_object);
    }
}
