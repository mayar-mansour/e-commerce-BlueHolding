<?php

namespace Modules\UserModule\Repository;

use Illuminate\Support\Facades\DB;
use Modules\UserModule\Entities\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{

    public function model()
    {
        return User::class;
    }

    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function updatePushToken(User $user, $push_token)
    {
        $user->update(['push_token' => $push_token]);
    }



    public function getQueryBuilder()
    {
        return $this->model->newQuery();
    }
}
