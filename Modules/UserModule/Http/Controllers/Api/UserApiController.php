<?php

namespace Modules\UserModule\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Mail\ContactMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Mail\VerificationCodeMail;
use App\Mail\WelcomeMail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Modules\RoleModule\Entities\Role;
use Modules\UserModule\Services\UserService;
use Tymon\JWTAuth\Facades\JWTAuth;
use Modules\UserModule\Transformers\UserAuthResource;
use Modules\UserModule\Transformers\UserResource;

class UserApiController extends Controller
{
    use ApiResponseHelper;
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'phone' => 'required|unique:users,phone',
            'push_token' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation Error',
            ], 400);
        }

        $user = $this->userService->register($request);

        $this->sendVerificationCode($user);

         if ($request['role']) {
             $user->assignRole($request['role']);
         }

        return $this->json(200, true, [], 'Successfully registered. Please check your email to verify your account.');
    }

    public function sendVerificationCode($user)
    {
        $verificationCode = rand(100000, 999999);


        $user->verification_code = $verificationCode;
        $user->save();

        $msg_data = [
            'verification_code' => $user->verification_code,
            'email' => $user->email,
            'subject' => "Verification Code",
        ];

        Mail::to($user->email)->send(new VerificationCodeMail($msg_data));
    }



    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'verification_code' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation Error',
            ], 400);
        }

        $user = $this->userService->findByEmail($request->email);

        if (!$user || $user->verification_code != $request->verification_code) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code.',
            ], 400);
        }

        $user->is_verified = 1;
         $user->verification_code = null;
        $user->save();


        $msg_data = [
            'name' => $user->name,
            'email' => $user->email,
            'subject' => "Verification Successful",
        ];

        Mail::to($user->email)->send(new WelcomeMail($msg_data));


        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'message' => 'Account successfully verified. You are now logged in.',
            'token' => $token,
        ], 200);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation Error',
            ], 400);
        }

        $credentials = $request->only('phone', 'password');
        $token = JWTAuth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();

        if (!$user->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Account not verified. Please check your email for the verification code.',
            ], 401);
        }

        return $this->json(200, true, [
            'token' => $token,
            UserAuthResource::make($user),
        ], 'Successfully logged in.');
    }

    public function getProfile()
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return $this->error(404, false, 'User not found');
        }
        $user = UserResource::make($user);
        return $this->json(200, true, $user, 'Success');
    }

    public function loginMessage()
    {
        return $this->json(200, true, [], 'Unauthorized please login');
    }

    public function logout()
    {
        Auth::logout();
        return $this->json(200, true, [], 'Successfully logged out');
    }
}
