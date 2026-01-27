<?php

use Illuminate\Support\Facades\Storage;
function getVideoInfo($video)
{
    $getID3 = new \getID3;
    $path = Storage::disk('public')->path(str_replace('storage', '', $video));
    $file = $getID3->analyze($path);
    return [
        'filename' => $file['filename'],
        'duration' => $file['playtime_seconds'],
        'size' => $file['filesize'],
    ];
}