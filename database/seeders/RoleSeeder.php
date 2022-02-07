<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $roles = array(
          array('name' => 'Admin'),
          array('name' => 'Seller'),
          array('name' => 'User')
        );

        foreach ($roles as $key => $role_val){
            $role = Role::create($role_val);

            if($key == '0'){
                $permissions = Permission::pluck('id','id')->all();
                $role->syncPermissions($permissions);
            }

        }


    }
}
