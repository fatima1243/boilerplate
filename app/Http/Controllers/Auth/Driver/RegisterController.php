<?php

namespace App\Http\Controllers\Auth\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\DriverRegisterRequest;
use App\Notifications\UserCreatedNotification;
use App\Services\UserAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class RegisterController extends Controller
{

    private $userAuthService;
    public function __construct(UserAuthService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }

    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->userAuthService->driverRegister($request);
            DB::commit();
            // Notification::send($user, new UserCreatedNotification($user));
            return response()->json(['success', "Register successfully.Admin will contact you after verify your account.", ['user' => $user]]);
        } catch (\Exception $e) {
            DB::rollBack();
                return response()->json(['error', $e->getMessage()]);
        }
    }

    public function showRegistrationForm()
    {
        return view('user.driver.register');
    }
}
