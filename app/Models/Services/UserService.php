<?php

namespace App\Models\Services;

use App\Models\User;

class UserService
{

    /**
     * @param $id
     * @return User
     */
    public function getUserById($id)
    {
        return User::find($id);
    }


}