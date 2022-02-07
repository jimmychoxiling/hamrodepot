<?php

namespace App\Repositories;
use App\Models\ServiceCategory;

class ServiceCategoryRepository
{
    public function create($data)
        {
            return ServiceCategory::create($data);
        }
        public function update($id, $data)
        {
            $products = ServiceCategory::findOrFail($id);
            $products->fill($data);
            $products->save();
            return $products;
        }
}
