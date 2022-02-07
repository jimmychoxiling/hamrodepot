<?php

namespace App\Repositories;

use App\Models\Orders;

class OrdersRepository
{

    public function create($data)
    {
        return Orders::create($data);
    }

    public function update($id, $data)
    {
        $orders = Orders::findOrFail($id);
        $orders->fill($data);
        $orders->save();
        return $orders;
    }
}
