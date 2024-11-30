<?php

namespace App\Services;

use App\Models\Bidding;
use App\Models\ChatRoom;
use App\Models\ChatRoomService;
use App\Models\Task;
use App\Utilities\Constants;
use Illuminate\Support\Facades\Log;

class BidService
{

    public function getAllBids($id)
    {
        return Bidding::with('driver:id,first_name,last_name')->whereTaskId($id)->get();
    }

    public function userCanceledBidRequest($request)
    {
        $bidding = Bidding::find($request->bid_id);
        $bidding->update(['status' => 'Reject']);

        // $bidding->update(['status' => 5]);
        // $placholder_value = [
        //     '[[TASK_TITLE]]' => $bidding->task->title,
        // ];

        // createDBNotification(
        //     auth('api')->id(), // Sender ID
        //     $bidding->pro_id, // Recipient ID
        //     Constants::NOTIFICATION_MESSAGE['1'],
        //     $placholder_value,
        //     Constants::TASK_STATUS['reject'],
        //     'App/Models/Task',
        //     $bidding->task->id
        // );

        // $this->taskRepository->removeCooldownTime($taskHistory->category_id);

        return $bidding;
    }

    public function userAcceptBid($request)
    {
        
        $task = Task::findOrFail($request->task_id);
        $task->update(['is_assigned' => true, 'status' => 1]);
       
        $bidding = Bidding::find($request->bid_id);
      
        $bidding->update(['status' => 'Accepted']);
        
        // $this->createChatRoom($request);
       
        $message = 'has accepted your service request for ' . $task->title . ' task';
        $title = 'has accepted your service request';
        $placholder_value = [
            '[[USER_NAME]]' => auth('api')->user()->first_name . ' ' . auth('api')->user()->last_name,
        ];

        $this->sendEmail($request, $bidding, $task, $title, $message, 2, Constants::NOTIFICATION_MESSAGE['9'], $placholder_value);
        // $this->partialPayment($request, $task, $bidding);


        return $bidding;
    }

    public function bidding($request)
    {      
        Log::info($request->all());
        $bidding = Bidding::updateOrCreate(
            [
                'task_id' => '1',
                'driver_id' => '3',
            ],
            [
                'price' => "100",
                'description' => "abc",
                'status' => 'Pending'
            ]
        );

        return $bidding;
    }

    public function deleteBid($id)
    {
        return Bidding::find($id)->delete();
    }

    // public function createChatRoom($request)
    // {
    //     $room = $this->createOrUpdateRoom($request->user_id);
    //     $this->chatRoomService($room->id, $request->task_id);
    // }

    // public function createOrUpdateRoom($userId)
    // {
    //     return ChatRoom::updateOrCreate([
    //         'customer_user_id' => auth('api')->user()->id,
    //         'service_provider_user_id' => $userId
    //     ]);
    // }

    // public function chatRoomService($chat_room_id, $task_id)
    // {
    //     return ChatRoomService::create([
    //         'chat_room_id' => $chat_room_id,
    //         'task_id' => $task_id
    //     ]);
    // }

    public function sendEmail($request, $bid, $task, $title, $message, $status, $notificationMessage, $placholder_value)
    {

        $userName = auth('api')->user()->first_name . ' ' . auth('api')->user()->last_name;
        $user = $bid->load('user.notificationSetting');
        // dd($user);
        // if ($user->bid?->notificationSetting?->is_email_notification == 1) {
        //     sendEmailNotification(
        //         $user->pro->email,
        //         $userName . ' ' . $title,
        //         $userName . ' ' . $message,
        //         'emails.job-notification'
        //     );
        // }

        createDBNotification(
            auth('api')->id(), // Sender ID
            $request->user_id, // Recipient ID
            $notificationMessage,
            $placholder_value,
            $status,
            'App/Models/Task',
            $task->id,
            $user->user?->notificationSetting?->is_push_notification,
        );

        return true;
    }
}
