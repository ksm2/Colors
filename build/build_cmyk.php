<?php
/**
 * Translates HEX keys to CMYK in colors.json
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

    // Calculate max value
    $max = max($r, $g, $b);

    $k = 1 - $max;
    $inversedK = 1 - $k;

    $color['black'] = $k;
    if ($inversedK == 0) {
        $color['cyan'] = 0;
        $color['magenta'] = 0;
        $color['yellow'] = 0;
    } else {
        $color['cyan'] = ($inversedK - $r) / $inversedK;
        $color['magenta'] = ($inversedK - $g) / $inversedK;
        $color['yellow'] = ($inversedK - $b) / $inversedK;
    }
}

file_put_contents(__DIR__ . '/../colors.json', json_encode($colors));
