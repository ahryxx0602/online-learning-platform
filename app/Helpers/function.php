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

function getHour($secs){
    $value = round($secs / 3600, 1);
    return $value . 'h';
}

function getMinute($secs) {
    $value = round($secs / 60, 1);
    return $value . ' phút';
}
