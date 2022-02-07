<?php

namespace App\Repositories;

use App\Models\ProductsImages;
use Illuminate\Support\Facades\Storage;

class ProductsImagesRepository
{
    public function create($data)
    {

        return ProductsImages::create($data);
    }

    public function update($id, $data)
    {
        $products_images = ProductsImages::findOrFail($id);
        if(isset($data['filename'])){
            Storage::delete($products_images->filename);
        }
        $products_images->fill($data);
        $products_images->save();
        return $products_images;
    }

    public function delete($id)
    {
        $products_images = ProductsImages::findOrFail($id);

        Storage::delete($products_images->filename);

        return ProductsImages::destroy($id);
    }
}
