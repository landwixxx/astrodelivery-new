<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Traits\TreatImageProduct;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    /**
     * store
     *
     * @param  mixed $file_request ex: $request->file('foto')
     * @param  mixed $product_id
     * @param  mixed $store_id
     * @param  mixed $principal
     * @param  mixed $width
     * @param  mixed $descricao
     * @return object
     */
    public static function store($file_request, $product_id, $store_id, $principal = 'S', $width = 500, $descricao = null): ?object
    {
        $pathImage = TreatImageProduct::save($file_request, $width);
        $imageBase64 = TreatImageProduct::imageToBase64(public_path($pathImage), $width);
        $extensao = pathinfo(public_path($pathImage), PATHINFO_EXTENSION);
        $mimetype = mime_content_type(public_path($pathImage));

        TreatImageProduct::delete($pathImage);

        $image = Image::create([
            'foto' => $imageBase64,
            'descricao' => $descricao,
            'principal' => $principal,
            'extensao' => $extensao,
            'mimetype' => $mimetype,
            'product_id' => $product_id,
            'store_id' => $store_id,
        ]);

        return $image;
    }

    public static function destroy($product_id)
    {
        $image = new Image;
        $image = Image::where('product_id', $product_id)->first();
        $image->delete();
    }
}
