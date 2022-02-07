<?php
namespace App\Helpers;
use App\Models\ProductWishlist;
use Auth;

class Helper {

    public static function GetName($table, $fieldfetch, $colum, $id)
    {
        $name = '';
        $get_detail = $table::select($fieldfetch)->where($colum,'=',$id)->first();
        if($get_detail != ""){
            $name = $get_detail->$fieldfetch;
        }
        return $name;
    }

    public static function GetAllDetail($table, $colum, $id)
    {
        $name = '';
        $get_detail = $table::where($colum,'=',$id)->first();
        if($get_detail != ""){
            $name = $get_detail;
        }
        return $name;
    }

    public function wishlistCountUser()
    {
        $count_wishlist = ProductWishlist::where('user_id',Auth()->user()->id)->count();
        return $count_wishlist;
    }

}
