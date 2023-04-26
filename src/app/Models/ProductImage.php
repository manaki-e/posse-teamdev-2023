<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProductImage extends Model
{
    use HasFactory;
    public function createImageAndSaveToPublicWithTextOverlay($file_name){
        $file_path=public_path('images/'.$file_name);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }
        $image=Image::canvas(600,600,'#ffffff')
        ->text($file_name,300,300,function ($font){
            $font->file(public_path('fonts/OpenSans-Bold.ttf'));
            $font->size(48);
            $font->color('#000000');
            $font->align('center');
            $font->valign('middle');
        });
        $image->save($file_path);
    }
}