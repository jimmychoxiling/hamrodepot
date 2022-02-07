<?php

namespace App\Repositories;
use App\Models\Voucher;
use Illuminate\Support\Facades\Storage;

class VoucherRepository
{
    public function __constuct()
    {

    }
    public function create($data)
    {
        return Voucher::create($data);
    }
    public function update($id, $data)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->fill($data);
        $voucher->save();
        return $voucher;
    }
}
