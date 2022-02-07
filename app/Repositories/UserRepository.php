<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function __constuct()
    {
        //
    }
    public function create($data)
    {
        return User::create($data);
    }

    public function update($id, $data)
    {
        $user = User::findOrFail($id);
        $user->fill($data);
        $user->save();
        return $user;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        return User::destroy($id);
    }
}
