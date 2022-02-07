<?php

namespace App\Repositories;

use App\Models\UserAddress;

class UserAddressRepository
{
    public function create($data)
    {
        return UserAddress::create($data);
    }

    public function update($id, $data)
    {
        $user_address = UserAddress::findOrFail($id);
        $user_address->fill($data);
        $user_address->save();
        return $user_address;
    }

    public function delete($id)
    {
        $user_address = UserAddress::findOrFail($id);

        return UserAddress::destroy($id);
    }
}
