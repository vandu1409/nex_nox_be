<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{

    public function createToUser(array $data)
    {
        return User::create($data);
    }

    public function updateToUser($id, array $data)
    {
        $user = User::findOrFail($id);
        return $user->update($data);
    }

    public function getById($id)
    {
     return User::find($id);
    }

}
