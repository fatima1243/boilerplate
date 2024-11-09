<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\JobPost;
use App\Models\JobPostGallery;
use Carbon\Carbon;

class JobPostRepository
{
    public function createTask(array $taskData)
    {
        $task = JobPost::create($taskData);

        if ($task && is_array($attachments) && count($attachments) > 0) {
            foreach ($attachments as $attachment) {
                $attachmentPath = storeFiles('task_gallery', $attachment);

                JobPostGallery::create([
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
}
