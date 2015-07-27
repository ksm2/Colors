<?php
/**
 * Translates HEX keys to RGB in colors.json
 * @author Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 */

$file = __DIR__ . '/../colors.json';
$color_json = file_get_contents($file);
$colors = json_decode($color_json, true);
rename($file, $file . '.old');

foreach ($colors as &$color) {
    extract($color);
    list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
    $color['red'] = $r;
    $color['green'] = $g;
    $color['blue'] = $b;
}

file_put_contents(__DIR__ . '/../colors.json', json_encode($colors));
