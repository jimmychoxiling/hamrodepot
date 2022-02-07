<?php

namespace App\Repositories;

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

class BrandRepository
{
    public function __constuct()
    {
        //
    }

    public function create($data)
    {
        return Brand::create($data);
    }

    public function update($id, $data)
    {
        $brand = Brand::findOrFail($id);
        if(isset($data['image'])){
            Storage::delete($brand->image);
        }
        $brand->fill($data);
        $brand->save();
        return $brand;
    }

    public function delete($id)
    {
        $brand = Brand::findOrFail($id);
        return Brand::destroy($id);
    }
}
