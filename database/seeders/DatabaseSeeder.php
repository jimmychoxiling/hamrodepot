<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // $this->call([UsersTableSeeder::class]);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
        $this->call(SettingTableSeeder::class);

    }
}
