<?php

namespace App\Repositories;

use App\Models\OrderStatusHistory;

class OrderStatusHistoryRepository
{
    public function create($data)
    {
        return OrderStatusHistory::create($data);
    }

    public function update($id, $data)
    {
        $order_status_history = OrderStatusHistory::findOrFail($id);
        $order_status_history->fill($data);
        $order_status_history->save();
        return $order_status_history;
    }
}
