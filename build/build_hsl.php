<?php
/**
 * Translates HEX keys to Hue, Saturation, Lightness, Value in colors.json
 * @author Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 */

$file = __DIR__ . '/../colors.json';
$color_json = file_get_contents($file);
$colors = json_decode($color_json, true);
rename($file, $file . '.old');

foreach ($colors as &$color) {
    extract($color);
    list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");

    // Normalize rgb
    $r /= 255;
    $g /= 255;
    $b /= 255;

    // Calculate min and max values
    $min = min($r, $g, $b);
    $max = max($r, $g, $b);

    $color['hue'] = (360 + hue($r, $g, $b, $min, $max)) % 360;
    $color['saturation'] = saturation($min, $max);
    $color['value'] = $max;
    $color['lightness'] = ($max + $min) / 2;
}

file_put_contents(__DIR__ . '/../colors.json', json_encode($colors));

function hue($r, $g, $b, $min, $max)
{
    if ($max == $min) {
        return 0;
    }

    $diff = $max - $min;
    if ($max == $r) {
        return 60 * (0 + (($g - $b) / $diff));
    }

    if ($max == $g) {
        return 60 * (2 + (($b - $r) / $diff));
    }

    return 60 * (4 + (($r - $g) / $diff));
}

function saturation($min, $max)
{
    if ($max == 0) {
        return 0;
    }

    if ($min == 1) {
        return 0;
    }

    return ($max - $min) / (1 - abs($max + $min - 1));
}
