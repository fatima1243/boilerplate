<?php

namespace App\Http\Controllers\Apis\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\SendTaskCancelRequest;
use App\Http\Requests\Task\UserAcceptTaskRequest;
use App\Services\BidService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function App\Helpers\returnToApi;
use function App\Helpers\sendSuccess;

class BidController extends Controller
{
    protected $bidService;
    public function __construct(BidService $bidService)
    {
        $this->bidService = $bidService;
    }

    public function getAllBids($id)
    {
        $bids = $this->bidService->getAllBids($id);
        return sendSuccess('success', $bids);
    }

    public function  userAcceptBid(UserAcceptTaskRequest $request)
    {
        try {
            DB::beginTransaction();
            $return_object = $this->bidService->userAcceptBid($request);
            DB::commit();
            return returnToApi('success', 'Request accepted successfully.', $return_object);
        } catch (\Throwable $th) {
            DB::rollBack();
            return returnToApi('error', 'Something went wrong.' . ' ' . $th->getMessage());
        }
    }


    public function userCanceledBidRequest(SendTaskCancelRequest $request)
    {
        try {
            $return_object = $this->bidService->userCanceledBidRequest($request);
            return returnToApi('success', 'Cancel bid successfully.', $return_object);
        } catch (\Throwable $th) {
            return returnToApi('error',  $th->getMessage());
        }
    }

    public function bidding(Request $request)
    {
        try {
            $return_object = $this->bidService->bidding($request);
            $message = $request->bid_id ? "Updated Successfully" : "Bid Successfull";
            return returnToApi('success', $message, $return_object);
        } catch (\Throwable $th) {
            return returnToApi('error', 'Something went wrong.' . ' ' . $th->getMessage());
        }
    }

    public function deleteBid($id)
    {
        try {
            $return_object = $this->bidService->deleteBid($id);
            return returnToApi('success', 'Bid deleted successfully.', $return_object);
        } catch (\Throwable $th) {
            return returnToApi('error', 'Something went wrong.' . ' ' . $th->getMessage());
        }
    }
}
