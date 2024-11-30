<?php

namespace App\Services;

use App\Http\Requests\BiddingRequest;
use App\Models\Bidding;
use App\Models\Task;
use App\Models\TaskGallery;
use App\Models\TaskHistory;
use App\Models\Transaction;
use App\Repositories\TaskRepository;
use App\Services\PaymentService;
use App\Services\StripeService;
use App\Utilities\Constants;

class TaskService
{
    protected $taskRepository;
    protected $stripeService;
    protected $paymentService;
    protected $uploadFileService;

    public function __construct(TaskRepository $taskRepository, UploadFileService $uploadFileService)
    {
        $this->taskRepository = $taskRepository;
        // $this->stripeService = $stripeService;
        // $this->paymentService = $paymentService;
        $this->uploadFileService = $uploadFileService;
    }

    public function updateStatus($taskId, $newStatus)
    {
        return $this->taskRepository->updateStatus($taskId, $newStatus);
    }

    // public function createTask(array $taskData)
    // {
    //     $picup_lat_long = explode(',', $taskData['pickup_lat_long']);
    //     $drop_lat_long = explode(',', $taskData['dropup_lat_long']);
    //     if (count($picup_lat_long) == 2) {
    //         $taskData['pickup_lat'] = filter_var(trim($picup_lat_long[0]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    //         $taskData['pickup_long']  = filter_var(trim($picup_lat_long[1]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    //     }
    //     if (count($drop_lat_long) == 2) {
    //         $taskData['drop_lat'] = filter_var(trim($drop_lat_long[0]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    //         $taskData['drop_long']  = filter_var(trim($drop_lat_long[1]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    //     }

    //     $task = Task::create($taskData);

    //     if ($task) {

    //         if (isset($taskData['pictures']) && is_array($taskData['pictures']) && count($taskData['pictures']) > 0) {
    //             foreach ($taskData['pictures'] as $attachment) {
    //                 $attachmentPath = storeFiles('task_gallery/images', $attachment);
    //                 TaskGallery::create([
    //                     'attachment' => $attachmentPath,
    //                     'task_id' => $task->id,
    //                     'type' => 1, // 1 for images
    //                 ]);
    //             }
    //         }
    //         if (isset($taskData['videos']) && is_array($taskData['videos']) && count($taskData['videos']) > 0) {
    //             foreach ($taskData['videos'] as $attachment) {
    //                 $attachmentPath = storeFiles('task_gallery/videos', $attachment);

    //                 TaskGallery::create([
    //                     'attachment' => $attachmentPath,
    //                     'task_id' => $task->id,
    //                     'type' => 0, // 0 for videos
    //                 ]);
    //             }
    //         }
    //     }

    //     return $task;
    // }

    // public function updateTask(array $taskData)
    // {
    //     $picup_lat_long = explode(',', $taskData['pickup_lat_long']);
    //     $drop_lat_long = explode(',', $taskData['dropup_lat_long']);
    //     if (count($picup_lat_long) == 2) {
    //         $taskData['pickup_lat'] = filter_var(trim($picup_lat_long[0]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    //         $taskData['pickup_long']  = filter_var(trim($picup_lat_long[1]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    //     }
    //     if (count($drop_lat_long) == 2) {
    //         $taskData['drop_lat'] = filter_var(trim($drop_lat_long[0]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    //         $taskData['drop_long']  = filter_var(trim($drop_lat_long[1]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    //     }
    //     $task = Task::find($taskData['id']);
    //     if (!$task) {
    //         throw new \Exception('Task not found.');
    //     }

    //     $task->update($taskData);
    //     // Handle pictures
    //     if (isset($taskData['pictures']) && is_array($taskData['pictures']) && count($taskData['pictures']) > 0) {
    //         // Store new pictures
    //         foreach ($taskData['pictures'] as $attachment) {
    //             $attachmentPath = storeFiles('task_gallery/images', $attachment);
    //             TaskGallery::create([
    //                 'attachment' => $attachmentPath,
    //                 'task_id' => $task->id,
    //                 'type' => 1, // 1 for images
    //             ]);
    //         }
    //     }

    //     // Handle videos
    //     if (isset($taskData['videos']) && is_array($taskData['videos']) && count($taskData['videos']) > 0) {
    //         foreach ($taskData['videos'] as $attachment) {
    //             $attachmentPath = storeFiles('task_gallery/videos', $attachment);
    //             TaskGallery::create([
    //                 'attachment' => $attachmentPath,
    //                 'task_id' => $task->id,
    //                 'type' => 0, // 0 for videos
    //             ]);
    //         }
    //     }

    //     return $task;
    // }


    public function getAllTask($request,$user)
    {
        $data = Task::with('image', 'minBid')->withCount('biddings')->where('recruiter_id', $user->id)
            ->orderByDesc('id')
            ->when($request->search, function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->query('search') . '%');
            })
            ->when($request->orderBy, fn ($q) => $q->orderBy('id', $request->query('orderBy')))
            ->simplePaginate($request->query('pagination') ?? Constants::DEFAULT_PAGINATION);

        return $data;
    }

    public function getAllTaskList($request)
    {
        return Task::with('image', 'biddings.driver:id,first_name,last_name', 'minBid')->when($request->zipcode, function ($query) use ($request) {
            $query->where('zipcode', $request->zipcode);
        })->whereIsAssigned(false)
            ->where('status', Constants::TASK_STATUS['pending'])
            ->orderByDesc('id')
            ->paginate($request->pagination ?? Constants::DEFAULT_PAGINATION);
    }



    public function getTaskById($taskId)
    {
        return Task::where('user_id', auth()->id())
            ->with('taskHistories.pro:id,slug,first_name,last_name,phone,profile_pic,email,account_status', 'taskGalleries', 'category', 'taskTags.tags')
            ->findOrFail($taskId);
    }

    public function getDetailJob($id)
    {
        return Task::with('taskGalleries', 'recruiter:id,first_name,last_name,email', 'isBid', 'video', 'image')->withCount('biddings')
            ->findOrFail($id);
    }

    public function getTaskGallery($taskId)
    {
        return TaskGallery::where('task_id', $taskId)->get();
    }

    public function updateTaskStatus($request)
    {
        $task = Task::findOrFail($request->task_id);
        $task->update(['status' => $request->status]);
        // if ($request->status == Constants::TASK_STATUS['reject']) {
        //     TaskHistory::where('task_id', $request->task_id)->delete();
        // } else {

        //     TaskHistory::where('task_id', $request->task_id)
        //         ->update(['status' => $request->status]);;
        // }
        return $task->load('taskGalleries');
    }

    public function updateBudget($request)
    {
        $task = Task::findOrFail($request->task_id);
        $task->update(['final_budget' => $request->initial_qutation, 'initial_qutation' => $request->initial_qutation]);
        // $placholder_value = [
        //     '[[TASK_TITLE]]' => $task->title,
        // ];

        // createDBNotification(
        //     auth()->id(), // Sender ID
        //     $task->user_id, // Recipient ID
        //     Constants::NOTIFICATION_MESSAGE['6'],
        //     $placholder_value,
        //     6
        // );
        return $task->load('taskGalleries');
    }

    // public function updateSchedule($request)
    // {
    //     $task = Task::with('taskHistories')->findOrFail($request->task_id);
    //     $task->update(['expected_date' => $request->expected_date, 'expected_time' => $request->expected_time]);

    //     $placholder_value = [
    //         '[[TASK_TITLE]]' => $task->title,
    //     ];
    //     if ($task->taskHistories->count() > 0) {
    //         foreach ($task->taskHistories as $key => $value) {
    //             createDBNotification(
    //                 auth()->id(), // Sender ID
    //                 $value->pro_id, // Recipient ID
    //                 Constants::NOTIFICATION_MESSAGE['5'],
    //                 $placholder_value,
    //                 5,
    //                 'App/Models/Task',
    //                 $task->id
    //             );
    //         }
    //     }



    //     return $task->load('taskGalleries');
    // }

    // public function updateTaskHistoryStatus($request)
    // {
    //     $taskHistory = TaskHistory::with('pro', 'user')->where('task_id', $request->task_id)
    //         ->where('pro_id', auth()->id())
    //         ->firstOrFail();
    //     $task = Task::findOrFail($request->task_id);
    //     $newStatus = $request->status;

    //     $taskHistory->update(['status' => $newStatus]);
    //     $task->update(['status' => $newStatus]);

    //     $notificationMap = [
    //         Constants::TASK_STATUS['accept'] => 2, // Task approval
    //         Constants::TASK_STATUS['reject'] => 1, // Lead rejection
    //         Constants::TASK_STATUS['completed'] => 4,
    //         Constants::TASK_STATUS['done'] => 3,
    //     ];

    //     if (array_key_exists($newStatus, $notificationMap)) {
    //         $placholder_value = [
    //             '[[TASK_TITLE]]' => $task->title,
    //         ];

    //         $notificationMessage = str_replace(
    //             Constants::NOTIFICATION_MESSAGE['0'], // Placeholder for TASK_TITLE
    //             $task->title, // Actual task title
    //             Constants::NOTIFICATION_MESSAGE[$notificationMap[$newStatus]]
    //         );

    //         $userName = auth()->user()->first_name . ' ' . auth()->user()->last_name;
    //         $user = $taskHistory->load('user.notificationSetting');

    //         if ($user->user?->notificationSetting?->is_email_notification == 1 && $newStatus == Constants::TASK_STATUS['done']) {
    //             sendEmailNotification(
    //                 $user->user->email,
    //                 $userName . ' has done task',
    //                 $userName . ' has done assigned task ' . $task->title . '',
    //                 'emails.job-notification'
    //             );
    //         }

    //         createDBNotification(
    //             auth()->id(), // Sender ID
    //             $taskHistory->user_id, // Recipient ID
    //             $notificationMessage,
    //             $placholder_value,
    //             $notificationMap[$newStatus],
    //             'App/Models/Task',
    //             $task->id,
    //             $user->user?->notificationSetting?->is_push_notification,
    //         );
    //     }

    //     return $taskHistory;
    // }



    public function deleteTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        // TaskHistory::where('task_id', $taskId)->delete();
        $task->delete();
        return $task;
    }



    public function sendRequest($request)
    {
        $task = Task::findOrFail($request->task_id);
        // $task_history = TaskHistory::create([
        //     'task_id' => $task->id,
        //     'category_id' => $task->category_id,
        //     'pro_id' => auth()->id(),
        //     'user_id' => $request->user_id,
        //     'status' => 0,
        // ]);

        // Notification 
        $userName = auth()->user()->first_name . ' ' . auth()->user()->last_name;
        // $user = $task_history->load('user.notificationSetting');
        $placholder_value = [
            '[[PRO_NAME]]' => $userName,
        ];
        // $notification = createDBNotification(
        //     auth()->id(),
        //     $request->user_id,
        //     Constants::NOTIFICATION_MESSAGE['8'],
        //     $placholder_value,
        //     0,
        //     'App/Models/Task',
        //     $task->id,
        //     $user->user?->notificationSetting?->is_push_notification,
        // );

        // if ($user->user?->notificationSetting?->is_email_notification == 1) {
        //     sendEmailNotification(
        //         $user->user->email,
        //         $userName . ' has sent you a service request',
        //         $userName . ' has sent you a service request for ' . $task->title . ' task',
        //         'emails.job-notification'
        //     );
        // }

        $task['is_subscriped'] = true;
        return $task;
    }

    // public function createChatRoom($request)
    // {
    //     try {
    //         $room = $this->taskRepository->createOrUpdateRoom($request);
    //         $this->taskRepository->chatRoomService($room->id, $request->task_id);
    //         return returnToApi('success',  $room);
    //     } catch (\Throwable $th) {
    //         return returnToApi('error',  $th->getMessage());
    //     }
    // }



    public function getTaskDetailById($id)
    {
        return Task::with([
            'taskGalleries', 'category', 'tags', 'user:id,first_name,last_name,email,phone,address,profile_pic', 'taskHistories'
        ])
            ->findOrFail($id);
    }



    public function getAllPopularTask($request)
    {
        return Task::with('taskGallery')->when($request->zipcode, function ($query) use ($request) {
            $query->where('zipcode', $request->zipcode);
        })
            ->where('status', Constants::TASK_STATUS['budget_pending'])
            ->inRandomOrder()
            ->get();
        // ->paginate($request->pagination ?? Constants::DEFAULT_PAGINATION);
    }

    public function isExistTasks()
    {
        return Task::where('status', Constants::TASK_STATUS['budget_pending'])->exists();
    }

    public function partialPayment($request, $task, $taskHistory)
    {
        $amount = $task->final_budget;

        $adminFee = round(Constants::ADMIN_CHARGE_AMOUNT * $task->final_budget, 2);
        $stripeTransaction = $this->stripeService->transferServicePaymentToProFromUser($request->pro_id, auth()->id(), $amount * 100, true, $adminFee);
        $amount = number_format($stripeTransaction['amount'] / 100, 2, '.', '');
        $placholder_value = [
            '[[TASK_TITLE]]' => $task->title,
        ];
        $title = 'has sent you a payment.';
        $message = 'has sent you a payment of $' . $amount . ' for the task ' . $task->title . '';

        // $this->sendEmail($request, $taskHistory, $task, $title, $message, 10, Constants::NOTIFICATION_MESSAGE['11'], $placholder_value);

        $data = $this->paymentService->saveTransaction(auth()->id(), $request->pro_id, $amount, $stripeTransaction, $stripeTransaction->payment_intent_id, $request->task_id, 3, $stripeTransaction['admin_charge'], $stripeTransaction['charge_id']);
        $message = 'Payment Transfer.';

        return $data;
    }

    // public function sendEmail($request, $taskHistory, $task, $title, $message, $status, $notificationMessage, $placholder_value)
    // {

    //     $userName = auth()->user()->first_name . ' ' . auth()->user()->last_name;
    //     $user = $taskHistory->load('pro.notificationSetting');
    //     if ($user->pro?->notificationSetting?->is_email_notification == 1) {
    //         sendEmailNotification(
    //             $user->pro->email,
    //             $userName . ' ' . $title,
    //             $userName . ' ' . $message,
    //             'emails.job-notification'
    //         );
    //     }

    //     createDBNotification(
    //         auth()->id(), // Sender ID
    //         $request->pro_id, // Recipient ID
    //         $notificationMessage,
    //         $placholder_value,
    //         $status,
    //         'App/Models/Task',
    //         $task->id,
    //         $user->user?->notificationSetting?->is_push_notification,
    //     );

    //     return true;
    // }

    public function currentJOb()
    {
        $data = Task::with('image')->withWhereHas('minBid', function ($q) {
            $q->where('driver_id', auth()->id());
        })->first();

        return $data;
    }

    public function jobHistories($request)
    {
        $data = Task::with('image')->withWhereHas('minBid', function ($q) {
            $q->where('driver_id', auth()->id());
        })->paginate($request->pagination ?? Constants::DEFAULT_PAGINATION);;

        return $data;
    }
}
