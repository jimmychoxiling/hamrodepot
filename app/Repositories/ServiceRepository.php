<?php

namespace App\Repositories;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use DB;

class ServiceRepository
{
   
    public function create($data)
    {
        return Service::create($data);
    }

    public function update($id, $data)
    {
        $service = Service::findOrFail($id);
        if(isset($data['image'])){
            Storage::delete($service->image);
        }
        $service->fill($data);
        $service->save();
        return $service;
    }
    public function delete($id)
    {
        
    }
}
