<?php

namespace App\Repositories;

use App\Models\SellerOpeningHour;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class SellerRepository
{
    private $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thrusday', 'Friday', 'Saturday'];

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
        if(isset($data['image'])){
            Storage::delete($user->image);
        }
        if(isset($data['banner_image'])){
            Storage::delete($user->banner_image);
        }
        $user->fill($data);
        $user->save();
        return $user;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        Storage::delete($user->image);
        Storage::delete($user->banner_image);

        return User::destroy($id);
    }
    public function getDefaultHours()
    {
        $hours = [];
        foreach ($this->days as $day) {
            $hour = new SellerOpeningHour();
            $hour['day'] = $day;
            $hour['isOpen'] = 1;
            $hour['opening_time'] = "00:00";
            $hour['closing_time'] = "00:00";
            array_push($hours, $hour);
        }
        return $hours;
    }
}
