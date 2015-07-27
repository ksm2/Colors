<?php
/**
 * Interactive CLI program to ask for translations
 * @author Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 */

$file = __DIR__ . '/../colors.json';
$color_json = file_get_contents($file);
$colors = json_decode($color_json, true);
rename($file, $file . '.old');

if ($argc < 2) {
    echo "Please specify a target language, e.g.:\n\nphp " . __FILE__ . " de";
    exit(1);
}

// Pass target as first parameter
$target = $argv[1];

echo "Leave empty to skip.\n\n";

foreach ($colors as &$color) {
    extract($color);

    if (isset($translations[$target])) {
        continue;
    }

    echo "Translate \033[1;32m$name\033[m to $target: ";
    $handle = fopen("php://stdin", "r");
    $text = trim(fgets($handle));
    $text = mb_convert_encoding($text, 'UTF-8');
    fclose($handle);

    if (empty($text)) {
        echo "\033[0;31mLeft translation empty for $name\033[m\n";
        continue;
    }

    $color['translations'][$target] = $text;
    echo "\n";
    save($colors);
//    foreach ($translations as $lang => $translation) {
//        if (!isset($xliffConfigs[$lang])) {
//            $xliffConfigs[$lang] = [];
//        }
//
//        $xliffConfigs[$lang][$transUnit] = ['source' => $en, 'target' => $translation];
//    }
}
save($colors);

function save($colors) {
    file_put_contents(__DIR__ . '/../colors.json', json_encode($colors));
    echo "Saved translations.\n";
}
