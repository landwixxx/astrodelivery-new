<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Shopkeeper\ImageController;

trait TreatImageProduct
{
    /**
     * Upload de imagem, tipos suportados: jpg, jpeg, png, gif, bmp, webp
     *
     * @param  mixed $file_request Ex: $request->file('image')
     * @param  integer $width
     * @param  integer $height
     * @return null|string Path da imagem salva
     */
    public static function save($file_request, int $width = 500, int $height = 500): ?string
    {
        // Se a imagem enviada for null, a path retorna null
        if (is_null($file_request))
            return null;

        //Path to the image file
        $file_img = $file_request;
        $image_original = $file_img->getPathname();

        $extension_image_original = strtolower(explode('/', mime_content_type($image_original))[1]);
        // dd($extension_image_original);

        switch ($extension_image_original) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'bmp':
            case 'webp':
                break;
            default:
                die('Unsupported image format');
        }

        /* ===== Imagem de bg ======*/

        // Path to the background image file
        $bg_path = __DIR__ .  '/../../public/assets/img/bg-white.png';

        // Get the background image dimensions
        list($bg_width, $bg_height) = getimagesize($bg_path);

        // Set the new width and height of the background image
        $new_bg_width = $bg_width;
        $new_bg_height = $bg_height;
        $new_bg_width = 500;
        $new_bg_height =  500;

        // Create a new background image resource
        $new_bg_image = imagecreatetruecolor($new_bg_width, $new_bg_height);

        // Fill the new background image with white background
        $white = imagecolorallocate($new_bg_image, 255, 255, 255);
        imagefill($new_bg_image, 0, 0, $white);

        // Load the original background image into the new background image resource
        $bg_image = imagecreatefrompng($bg_path);
        imagecopyresampled($new_bg_image, $bg_image, 0, 0, 0, 0, $new_bg_width, $new_bg_height, $bg_width, $bg_height);


        /* Imagem do produtos */

        // Get the original image dimensions
        list($original_width, $original_height) = getimagesize($image_original);

        // Set the new width and height of the image
        $new_width = $original_width;
        $new_height = $original_height;

        // calcullar dimensões da img produto
        if ($new_width >= $new_height) {
            $porc = (500 / $new_width) * 100;
            $h = ($new_height * $porc) / 100;
            $new_width = 500;
            $new_height = intval($h);
        } else {
            $porc = (500 / $new_height) * 100;
            $h = ($new_width * $porc) / 100;
            $new_height = 500;
            $new_width = intval($h);
        }

        // Create a new image resource
        $new_image = imagecreatetruecolor($new_width, $new_height);

        /* Criar imagem pelo tipo de imagem */

        // Get the image file extension
        // $ext = pathinfo($image_original, PATHINFO_EXTENSION);

        // Create a new image resource
        $original_image = null;

        // Open the image file based on the file extension
        switch ($extension_image_original) {
            case 'jpg':
            case 'jpeg':
                $original_image = imagecreatefromjpeg($image_original);
                break;
            case 'png':
                $original_image = imagecreatefrompng($image_original);
                break;
            case 'gif':
                $original_image = imagecreatefromgif($image_original);
                break;
            case 'bmp':
                $original_image = imagecreatefromwbmp($image_original);
                break;
            case 'webp':
                $original_image = imagecreatefromwebp($image_original);
                break;
            default:
                die('Unsupported image format');
        }

        /* ======================= */
        // Load the original image into the new image resource
        imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

        // Calculate the x and y coordinates to center the image
        $x = ($new_bg_width - $new_width) / 2;
        $y = ($new_bg_height - $new_height) / 2;

        // Copy the original image onto the background image
        imagecopy($new_bg_image, $new_image, $x, $y, 0, 0, $new_width, $new_height);

        $path_file = 'storage/app/public/products/' . time() . '_' . md5(uniqid(time())) . '.jpg';
        // local para salvar o arquivo
        $path_file_dir = __DIR__ . '/../../' . $path_file;
        // Save the new image to disk
        imagejpeg($new_bg_image, $path_file_dir, 100);

        // Clean up
        imagedestroy($bg_image);
        imagedestroy($original_image);
        imagedestroy($new_image);
        imagedestroy($new_bg_image);

        return str_replace('app/', '', $path_file);
    }

    public static function delete(string $path_image): bool
    {
        $path_image = str_replace('storage/', '', $path_image);
        return Storage::delete($path_image);
    }
    
    /**
     * imageToBase64
     *
     * @param  string $path path image jpg|jpeg
     * @param  int $newWidth
     * @return string
     */
    public static function imageToBase64($path, $newWidth = 500): string
    {
        $image = imagecreatefromjpeg($path);
        $width = imagesx($image);
        $height = imagesy($image);

        // Compress and resize the image
        $new_width = $newWidth;
        $new_height = ($height / $width) * $new_width;
        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        // Convert the image to a base64 string
        ob_start();
        imagejpeg($new_image);
        $image_data = ob_get_contents();
        ob_end_clean();
        $image_data_base64 = base64_encode($image_data);

        return "data:image/jpeg;base64,$image_data_base64";
    }
}
