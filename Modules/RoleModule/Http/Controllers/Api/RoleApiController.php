<?php

namespace Modules\RoleModule\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\RoleModule\Entities\Permission;
use Modules\RoleModule\Entities\Role;
use Modules\UserModule\Entities\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Modules\UserModule\Services\UserService;

class RoleApiController extends Controller
{
    use ApiResponseHelper;
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Assign a role to a user
    public function assignRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'role' => 'required|string|exists:roles,name',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        $roleName = $request['role'];
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($user->hasRole($roleName)) {
            return response()->json(['message' => 'User already has this role'], 400);
        }

        // Assign the role to the user
        $user->assignRole($roleName);

        return response()->json(['message' => 'Role was assigned successfully'], 200);
    }



    // Revoke a role from a user
    public function revokeRole(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::where('email', $request->email)->first();
        $roleName = $request->role;

        if (!$user->hasRole($roleName)) {
            return response()->json(['message' => 'User does not have this role'], 400);
        }

        $user->removeRole($roleName);

        return response()->json(['message' => 'Role revoked successfully'], 200);
    }

    // // Assign a permission to a user
    // public function assignPermission(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email|exists:users,email',
    //         'permission' => 'required|string|exists:permissions,name',
    //     ]);

    //     $user = User::where('email', $request->email)->first();
    //     $permissionName = $request->permission;

    //     if ($user->hasPermissionTo($permissionName)) {
    //         return response()->json(['message' => 'User already has this permission'], 400);
    //     }

    //     $user->assignPermissionPermissionTo($permissionName);

    //     return response()->json(['message' => 'Permission assigned successfully'], 200);
    // }

    // // Revoke a permission from a user
    // public function revokePermission(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email|exists:users,email',
    //         'permission' => 'required|string|exists:permissions,name',
    //     ]);

    //     $user = User::where('email', $request->email)->first();
    //     $permissionName = $request->permission;

    //     if (!$user->hasPermissionTo($permissionName)) {
    //         return response()->json(['message' => 'User does not have this permission'], 400);
    //     }

    //     $user->revokePermissionTo($permissionName);

    //     return response()->json(['message' => 'Permission revoked successfully'], 200);
    // }
}
