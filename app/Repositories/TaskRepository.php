<?php

namespace App\Repositories;

use App\Models\Category;
use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Task;
use App\Models\TaskTag;
use App\Models\ChatRoom;
use App\Models\TaskGallery;
use App\Models\TaskHistory;
use App\Utilities\Constants;
use App\Models\ChatRoomService;
use App\Models\CooldownTimeManagement;
use Illuminate\Contracts\Queue\Job;

use function App\Helpers\storeFiles;

class TaskRepository
{
    // public function updateStatus($taskId, $newStatus)
    // {
    //     return TaskHistory::where('task_id', $taskId)->update([
    //         'status' => $newStatus
    //     ]);
    // }

    // public function removeCooldownTime($category)
    // {
    //     $cooldowntime = CooldownTimeManagement::where('category_id', $category)->where('user_id', auth()->id())->first();
    //     $cooldowntime->start_date_time = now();
    //     $cooldowntime->end_date_time = now()->addMinutes(30);
    //     $cooldowntime->existing_requests = $cooldowntime->existing_requests - 1;
    //     $cooldowntime->save();

    //     return true;
    // }

    // public function validateCooldownTime($category)
    // {
    //     $cooldowntime = CooldownTimeManagement::where('category_id', $category)->where('user_id', auth()->id())->first();

    //     if ($cooldowntime) {
    //         if ($cooldowntime->end_date_time > now()) {
    //             return ['error' => 'limit_exceded_time', 'time' => Carbon::parse($cooldowntime->end_date_time)->format('H:i:s')];
    //         } else if ($cooldowntime->existing_requests > 2) {
    //             if ($cooldowntime->existing_requests == 3) {
    //                 return ['error' => 'limit_exceded_request'];
    //             }
    //         } else {
    //             if ($cooldowntime->existing_requests == 2) {
    //                 $cooldowntime->start_date_time = now();
    //                 $cooldowntime->end_date_time = now()->addMinutes(30);
    //             }
    //             $cooldowntime->existing_requests = $cooldowntime->existing_requests + 1;
    //             $cooldowntime->save();
    //         }
    //     } else {
    //         CooldownTimeManagement::create([
    //             'category_id' => $category,
    //             'user_id' => auth()->id(),
    //             'start_date_time' => now(),
    //             'end_date_time' => now(),
    //             'existing_requests' => 1
    //         ]);
    //     }
    //     return true;
    //     // dd($cooldowntime);
    // }

    // public function addTag($tags, $taskId)
    // {
    //     $tag_array = explode(',', $tags);
    //     foreach ($tag_array as $tag) {
    //         $insertion = Tag::updateOrCreate([
    //             'title' => $tag
    //         ], [
    //             'title' => $tag
    //         ]);
    //         $this->assignTag($insertion->id, $taskId);
    //     }
    // }

    // public function assignTag($tagId, $taskId)
    // {
    //     return TaskTag::create(['tag_id' => $tagId, 'task_id' => $taskId]);
    // }

    public function createTask(array $taskData)
    {
        $task = Task::create($taskData);

        if ($task && is_array($attachments) && count($attachments) > 0) {
            foreach ($attachments as $attachment) {
                $attachmentPath = storeFiles('task_gallery', $attachment);

                TaskGallery::create([
                    'attachment' => $attachmentPath,
                    'task_id' => $task->id
                ]);
            }
        }
        // Notification 
        // $placholder_value = [
        //     '[[TASK_TITLE]]' => $task->title,
        // ];
        // $notification = createDBNotification(auth()->id(), $taskData['pro_id'], Constants::NOTIFICATION_MESSAGE['0'], $placholder_value, 0);


        return $task;
    }

    // public function assignTask($request)
    // {
    //     $task = assignTask::find($request->task_id);
    //     $cooldownTime = $this->validateCooldownTime($task->category_id);
    //     if (is_array($cooldownTime)) {
    //         return $cooldownTime;
    //     }


    //     $task_history = TaskHistory::create([
    //         'task_id' => $task->id,
    //         'category_id' => $task->category_id,
    //         'pro_id' => $request->pro_id,
    //         'user_id' => $task->user_id,
    //         'status' => 0,
    //     ]);

    //     // Notification 
    //     $placholder_value = [
    //         '[[TASK_TITLE]]' => $task->title,
    //     ];
    //     $notification = createDBNotification(auth()->id(), $request->pro_id, Constants::NOTIFICATION_MESSAGE['0'], $placholder_value, 0);


    //     return $task;
    // }

    // public function createOrUpdateRoom($pro_id)
    // {
    //     return ChatRoom::updateOrCreate([
    //         'customer_user_id' => auth()->user()->id,
    //         'service_provider_user_id' => $pro_id
    //     ]);
    // }

    // public function chatRoomService($chat_room_id, $task_id)
    // {
    //     return ChatRoomService::create([
    //         'chat_room_id' => $chat_room_id,
    //         'task_id' => $task_id
    //     ]);
    // }
}
