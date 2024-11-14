<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Recruiter;
use App\Models\VerifyRecruiter;
use App\Notifications\VerifyRecruiterEmail;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Notification;
use Str;
use Validator;

class LoginRegisterController extends Controller
{
    public function register()
    {
        return view('user.recruiter.register');
    }

    public function registration(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:recruiters,email',
            'password' => 'required|min:6',
            'post_code' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create recruiter
        $recruiter = Recruiter::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'postal_code' => $request->post_code,
        ]);

        $verify_token = Str::random(32);

        VerifyRecruiter::create([
            'token' => $verify_token,
            'recruiter_id' => $recruiter->id,
        ]);

        // Send email verification notification
        Notification::send($recruiter, new VerifyRecruiterEmail($recruiter, $verify_token));

        return response()->json(['message' => 'Your account has been registered successfully. Please verify your email before login.'], 200);
    }


    public function verifyRecruiterEmail($token)
    {
        $verifiedRecruiter = VerifyRecruiter::where('token', $token)->first();

        if ($verifiedRecruiter) {
            $recruiter = Recruiter::find($verifiedRecruiter->recruiter_id);
            if ($recruiter && is_null($recruiter->email_verified_at)) {
                $recruiter->email_verified_at = Carbon::now();
                $recruiter->save();
                return redirect()->route('recruiter/login')->with('success', 'Your email has been verified successfully. Please log in.');
            }
        }

        return redirect()->route('recruiter/login')->with('error', 'Verification failed or token expired.');
    }

    public function showLoginForm()
    {
        return view('user.recruiter.login');
    }

    public function driverLoginForm()
    {
        return view('user.driver.login');
    }

    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        // Check for validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Attempt to log in using the recruiter guard
        if (Auth::guard('recruiter')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Retrieve the authenticated recruiter
            $recruiter = Auth::guard('recruiter')->user();
    
            // Check if the recruiter's email is verified
            if (is_null($recruiter->email_verified_at)) {
                // If email is not verified, log out the user and return a message
                Auth::guard('recruiter')->logout();
                return response()->json(['message' => 'Your email address is not verified. Please check your email to verify your account.'], 403);
            }
    
            // Generate an authentication token
            $token = $recruiter->createToken('RecruiterAuthToken')->plainTextToken;
    
            return response()->json([
                'message' => 'Login successful!',
                'data' => [
                    'user' => $recruiter,
                    'token' => $token,
                ],
            ], 200);
        }
    
        // If authentication fails, return an error message
        return response()->json(['message' => 'Invalid credentials, please try again.'], 401);
    }

    public function driverLogin(Request $request)
    {
        // Validate the incoming request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
    
        
        // Attempt to log in using the recruiter guard
        if (FacadesAuth::guard('driver')->attempt($credentials)) {
            // Authentication was successful
            $driver = Auth::guard('driver')->user();
    
            // Check if the recruiter's email is verified
            if (is_null($driver->email_verified_at)) {
                // If email is not verified, log out the user and return a message
                Auth::guard('driver')->logout();
                return response()->json(['message' => 'Your email address is not verified. Please check your email to verify your account.'], 403);
            }
    
            // Generate an authentication token
            $token = $driver->createToken('DriverAuthToken')->plainTextToken;
    
            return response()->json([
                'message' => 'Login successful!',
                'data' => [
                    'user' => $driver,
                    'token' => $token,
                ],
            ], 200);
        }
    
        // If authentication fails, return an error message
        return response()->json(['message' => 'Invalid credentials, please try again.'], 401);
    }
    
}
