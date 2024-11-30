<?php

namespace App\Services;
use App\Http\Requests\BiddingRequest;
use App\Models\JobPost;
use App\Models\JobPostGallery;
use App\Models\Task;
use App\Models\TaskGallery;
use App\Repositories\JobPostRepository;
use Illuminate\Support\Facades\Auth;

use function App\Helpers\storeFiles;

class JobPostService
{
    protected $jobPostRepository;

    public function __construct(JobPostRepository $jobPostRepository)
    {
        $this->jobPostRepository = $jobPostRepository;
    }

    public function createTask(array $taskData)
    {
        $picup_lat_long = explode(',', $taskData['pickup_lat_long']);
        $drop_lat_long = explode(',', $taskData['dropup_lat_long']);
        if (count($picup_lat_long) == 2) {
            $taskData['pickup_lat'] = filter_var(trim($picup_lat_long[0]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $taskData['pickup_long']  = filter_var(trim($picup_lat_long[1]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        }
        if (count($drop_lat_long) == 2) {
            $taskData['drop_lat'] = filter_var(trim($drop_lat_long[0]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $taskData['drop_long']  = filter_var(trim($drop_lat_long[1]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        }
            // $taskData['user_id'] = auth()->user()->id
        $jobPost = Task::create($taskData);

        if ($jobPost) {

            if (isset($taskData['pictures']) && is_array($taskData['pictures']) && count($taskData['pictures']) > 0) {
                foreach ($taskData['pictures'] as $attachment) {
                    $attachmentPath = storeFiles('task_gallery/images', $attachment);
                    TaskGallery::create([
                        'attachment' => $attachmentPath,
                        'task_id' => $jobPost->id,
                        'type' => 1, // 1 for images
                    ]);
                }
            }
            if (isset($taskData['videos']) && is_array($taskData['videos']) && count($taskData['videos']) > 0) {
                foreach ($taskData['videos'] as $attachment) {
                    $attachmentPath = storeFiles('task_gallery/videos', $attachment);

                    TaskGallery::create([
                        'attachment' => $attachmentPath,
                        'task_id' => $jobPost->id,
                        'type' => 0, // 0 for videos
                    ]);
                }
            }
        }

        return $jobPost;
    }

    public function getAuthenticatedUser()
    {
        if (Auth::guard('recruiter')->check()) {
            return Auth::guard('recruiter')->user(); // Get recruiter user object
        }

        if (Auth::guard('driver')->check()) {
            return Auth::guard('driver')->user(); // Get driver user object
        }

        return null; // Handle unauthenticated case
    }

    public function getUserRole()
    {
        $roleId = null;

        if (Auth::guard('recruiter')->check()) {
            $roleId = '0'; // You can set this to a specific ID or string identifier
        } elseif (Auth::guard('driver')->check()) {
            $roleId = '1'; // Similarly, set this for driver
        }
        return $roleId;

    }


    public function getAllTask($request)
    {
        $data = Task::all();

        return $data;
    }
}
