<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository
{
    public function create($data)
    {
        return Setting::create($data);
    }

    public function update($id, $data)
    {
        $setting = Setting::findOrFail($id);
        $setting->fill($data);
        $setting->save();
        return $setting;
    }

    public function delete($id)
    {
        $setting = Setting::findOrFail($id);
        return Setting::destroy($id);
    }

    public function CommissionAdmin()
    {
        return Setting::select('value')->where('id','1')->first();
    }
}
