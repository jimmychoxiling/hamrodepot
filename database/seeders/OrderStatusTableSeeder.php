<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('order_statuses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $status = array(
            array('name' => 'Pending'),
            array('name' => 'Confirm'),
            array('name' => 'Processing'),
            array('name' => 'Dispatched'),
            array('name' => 'Completed'),
            array('name' => 'Cancel'),
            array('name' => 'Return'),
            array('name' => 'Remit'),
        );

        foreach ($status as $key => $status_val) {
            $order_status = OrderStatus::create($status_val);
        }
    }
}
