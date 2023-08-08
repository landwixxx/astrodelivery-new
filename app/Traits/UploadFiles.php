<?php

namespace App\Traits;

use App\Http\Controllers\Shopkeeper\ImageController;
use Illuminate\Support\Facades\Storage;

trait UploadFiles
{
    public static function imgProducts($request, $product_id)
    {
    }

    public static function deleteImgProducts($file_data)
    {
        foreach ($file_data->image as $image) {
            Storage::delete("public/products/$image->end_imagem");
            ImageController::destroy($image->product_id);
        }
    }

    public static function deleteImgFlavors($file_data)
    {
        Storage::delete("public/flavors/$file_data->end_imagem");
        ImageController::destroy($file_data->id);
    }
}
