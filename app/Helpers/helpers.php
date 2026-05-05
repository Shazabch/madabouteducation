<?php

function getCurrency()
{
    return 'MYR  ';
}

function mainMenuActiveBySegment($s2, $s3 = '', $s4 = '')
{
    $result = false;

    if ($s4 != '') {
        $result = request()->segment(2) == $s2 && request()->segment(3) == $s3 && request()->segment(4) == $s4;
    } else if ($s3 != '') {
        $result = request()->segment(2) == $s2 && request()->segment(3) == $s3;
    } else {
        $result = request()->segment(2) == $s2;
    }

    return $result ? 'active' : '';
}

function subMenuActiveBySegment($s2, $s3 = '', $s4 = '')
{
    $result = false;

    if ($s4 != '') {
        $result = request()->segment(2) == $s2 && request()->segment(3) == $s3 && request()->segment(4) == $s4;
    } else if ($s3 != '') {
        $result = request()->segment(2) == $s2 && request()->segment(3) == $s3;
    } else {
        $result = request()->segment(2) == $s2;
    }

    return $result ? 'active' : '';
}

function activeByFirstSegment($s1)
{
    return request()->segment(1) == $s1 ? 'active' : '';
}

function deleteFile($path)
{
    if ($path != null && file_exists(public_path($path))) {
        unlink($path);
    }
}

function randomBg()
{
    return collect([
        ['', '-1'],
        ['-2', '-2'],
        ['-3', '-3'],
        // ['-5','-8'],
        ['-9', '-4'],
        ['-10', '-6'],
    ])->random();
}

function getGalleryImages()
{
    $path = public_path('storage/gallery');
    $images = [];
    foreach (glob($path . "/*.{jpeg,jpg,png,webp}", GLOB_BRACE) as $file) {
        $images[] = 'storage/gallery/' . pathinfo($file, PATHINFO_BASENAME);
    }
    return $images;
}

function ordinal($number)
{
    $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
    if ((($number % 100) >= 11) && (($number % 100) <= 13))
        return $number . 'th';
    else
        return $number . '' . $ends[$number % 10];
}

function getSstValue()
{
    return 8 / 100;
}
