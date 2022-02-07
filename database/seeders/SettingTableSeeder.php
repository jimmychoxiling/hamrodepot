<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('settings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $status = array(
            array('key' => 'Commission Admin (%)','value' => '1'),
        );

        foreach ($status as $key => $status_val) {
            $setting = Setting::create($status_val);
        }
    }
}
