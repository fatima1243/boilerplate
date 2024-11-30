<?php

namespace App\Http\Controllers;

use App\Services\UserAuthService;
use Illuminate\Http\Request;

use function App\Helpers\returnToApi;

class UserAuthController extends Controller
{
    private $userAuthService, $stripeService;

    public function __construct(UserAuthService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }

    public function logout(Request $request)
    {
        try {
            $this->userAuthService->logout($request);

            return returnToApi('success', Constants::MESSAGES['logout_success'], null);
        } catch (\Exception $e) {
            return returnToApi('error', $e->getMessage());
        }
    }
}
