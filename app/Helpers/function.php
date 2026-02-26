<?php

use Illuminate\Support\Facades\File;

function deleteImageFile($image)
{
    $imageThumb = dirname($image) . '/thumbs/' . basename($image);
    File::delete(public_path($image));
    File::delete(public_path($imageThumb));
}

function money($number, $currency = 'đ'){
    return !empty($number) ? number_format($number). ' '.$currency: 'Miễn phí';
}