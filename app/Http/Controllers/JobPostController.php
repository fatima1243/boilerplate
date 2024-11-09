<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Services\JobPostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobPostController extends Controller
{

    protected $jobPostService;

    public function __construct(JobPostService $jobPostService)
    {
        $this->jobPostService = $jobPostService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jobs = $this->jobPostService->getAllTask($request);
        $roleId = $this->jobPostService->getUserRole();
        return view('recruiter.jobPosts.ListJobPosts',compact('jobs','roleId'),);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roleId = $this->jobPostService->getUserRole();
        return view('recruiter.jobPosts.create_job',compact('roleId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $requestData = $request->all();
            $requestData['recruiter_id'] = $this->getAuthenticatedUser()->id;
            $requestData['is_assigned'] = false;
            $return_object = $this->jobPostService->createTask($requestData);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Task created successfully.', $return_object
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get data.' . ' ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\Http\Response
     */
    public function show(JobPost $jobPost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\Http\Response
     */
    public function edit(JobPost $jobPost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobPost $jobPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobPost $jobPost)
    {
        //
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
}
