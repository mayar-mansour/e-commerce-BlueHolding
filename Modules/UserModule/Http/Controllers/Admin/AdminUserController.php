<?php

namespace Modules\UserModule\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\UserModule\Services\UserService;
use Modules\RoleModule\Entities\Role;

class AdminUserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsersWithRolesPaginated(20);
        return view('usermodule::admin.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('usermodule::admin.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required|unique:users',
            'password' => 'required|string|min:6',
            'roles'    => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userData = $request->only(['name', 'email', 'phone', 'password']);
        $userData['is_verified'] = true;
        $user = $this->userService->register($request);

        if ($request->roles && is_array($request->roles)) {
            foreach ($request->roles as $roleId) {

                $role = Role::find($roleId);
                $user->assignRole($role);
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = $this->userService->findOne($id)->load('roles');
        $roles = Role::all();
        return view('usermodule::admin.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = $this->userService->findOne($id);

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'required|unique:users,phone,' . $user->id,
            'password' => 'nullable|string|min:6',
            'roles'    => 'nullable|array',
            'roles.*'  => 'exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userData = $request->only(['name', 'email', 'phone']);
        if ($request->filled('password')) {
            $userData['password'] = $request->password;
        }

        $this->userService->update(array_merge($userData, ['id' => $user->id]));

        // Sync roles
        if ($request->filled('roles')) {
            $user->roles()->sync([]);
            foreach ($request->roles as $roleId) {
                $role = Role::find($roleId);
                $user->assignRole($role);
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    
}
