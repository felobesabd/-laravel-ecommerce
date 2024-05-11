<?php

function getFolder()
{
    return app()->getLocale() === 'ar' ? 'css-rtl' : 'css';
}

define('PAGINATION_COUNT', 10);

function uploadImage($folder, $image)
{
    $image->store('/', $folder);
    $fileName = $image->hashName();
    $path = 'images/'. $folder . '/' . $fileName;
    return $fileName;
}
