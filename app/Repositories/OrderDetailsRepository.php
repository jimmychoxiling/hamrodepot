<?php

namespace App\Repositories;

use App\Models\OrderDetail;

class OrderDetailsRepository
{
    public function create($data)
    {
        return OrderDetail::create($data);
    }

    public function update($id, $data)
    {
        $order_detail = OrderDetail::findOrFail($id);
        $order_detail->fill($data);
        $order_detail->save();
        return $order_detail;
    }
}
