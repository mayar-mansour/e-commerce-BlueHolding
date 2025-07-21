<?php

namespace Modules\LayoutModule\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\UserModule\Services\UserService;

class LayoutModuleController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Show the dashboard if authenticated
     */
    public function index()
    {

        // Check if the user is authenticated
        if (Auth::guard('web')->user() != null) {
            return view('layoutmodule::layouts.dashboard');
        }

        // Redirect to login if not authenticated
        return redirect()->route('loginWeb');
        if (Auth::check()) {
            return view('layoutmodule::layouts.dashboard');
        }

        return redirect()->route('login');
    }

    /**
     * Show login form
     */
    public function loginGet()
    {
        return view('layoutmodule::Authentication.login');
    }

    /**
     * Show forgot password form
     */
    public function forgetPassGet()
    {
        return view('layoutmodule::Authentication.forgotPassword');
    }

    /**
     * Handle login request
     */
    public function loginUser(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'email.required' => 'email is required.',
                'password.required' => 'Password is required.',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();

            // Ensure the user has 'admin' role
            if (!$user->hasRole('admin')) {
                Auth::guard('web')->logout();
                return redirect()->back()->with('error', 'Access denied. Admins only.');
            }

            return redirect()->intended('admin/dashboard');
        }

        return redirect()->back()->with('error', 'Incorrect email or password.');
    }


    /**
     * Show change password form
     */
    public function changePassword()
    {
        return view('usermodule::user.change_password');
    }

    

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect()->route('loginWeb')->with('success', 'Logged out successfully.');
    }
}