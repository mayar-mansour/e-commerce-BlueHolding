<?php

namespace Modules\UserModule\Services;

use App\Helpers\FcmHelper;
use App\Helpers\UploaderHelper;
use App\Helpers\ApiResponseHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

use Modules\UserModule\Repository\UserRepository;

class UserService
{
    use UploaderHelper;

    private $userRepository;
    private $favouriteRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function findWhere($arr)
    {
        return $this->userRepository->findWhere($arr);
    }



    public function findOne($id)
    {
        return $this->userRepository->find($id);
    }
    public function findByEmail($email)
    {
        return $this->userRepository->findByEmail($email);
    }



    public function login($data)
    {
        $user = $this->userRepository->findWhere(
            [
                'phone' => $data['phone']
            ]
        )->first();
        if (!$user)
            return null;

        // is the passwords match?
        if (!Hash::check($data['password'], $user->password))
            return null;

        Auth::login($user);
        $auth_user = Auth::user();

        ///update push_token if found//
        if (key_exists('push_token', $data)) {
            $this->userRepository->updatePushToken($user, $data['push_token']);
            $auth_user->push_token = $data['push_token'];
        }
        $user->token = $user->createToken('token')->accessToken;
        ///////////////////////////
        return $auth_user;
    }






    public function register($data)
    {
        return $this->userRepository->create($this->validationUpdateOrRegister($data->all()));
    }

    public function update($data)
    {
        $user_data = [];

        if (isset($data['name'])) {
            $user_data['name'] = $data['name'];
        }

        if (isset($data['email'])) {
            $user_data['email'] = $data['email'];
        }

        if (isset($data['password'])) {
            $user_data['password'] = bcrypt($data['password']);
        }

        if (isset($data['phone'])) {
            $user_data['phone'] = $data['phone'];
        }

        if (isset($data['country_code'])) {
            $user_data['country_code'] = $data['country_code'];
        }

        if (isset($data['push_token'])) {
            $user_data['push_token'] = $data['push_token'];
        }

        return $this->userRepository->update($user_data, $data['id']);
    }

    private function validationUpdateOrRegister($data)
    {
        $user_data = [];

        if (key_exists('name', $data)) {
            $user_data['name'] = $data['name'];
        }

        if (key_exists('email', $data)) {
            $user_data['email'] = $data['email'];
        }

        if (key_exists('password', $data)) {
            $user_data['password'] = bcrypt($data['password']);
        }

        if (key_exists('phone', $data)) {
            $user_data['phone'] = $data['phone'];
        }


        if (key_exists('push_token', $data)) {
            $user_data['push_token'] = $data['push_token'];
        }



        return $user_data;
    }




    public function getAllUsersWithRolesPaginated($perPage)
    {
        return $this->userRepository->getQueryBuilder()
            ->with('roles')
            ->latest()
            ->paginate($perPage);
    }
}
