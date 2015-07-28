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

$primary = false;
if ($argc > 2) {
    $primary = $argv[2] === '-p';
}

echo "Leave empty to skip.\n\n";

if ($primary) {
//    echo "Translate \033[1;32mdark\033[m:\n";
//    $dark = ask();
//    echo "Translate \033[1;32mlight\033[m:\n";
//    $light = ask();
//    echo "Translate \033[1;32mmedium\033[m:\n";
//    $medium = ask();

}

$primaryColors = array(
    'blue',
    'cyan',
    'gray',
    'green',
    'magenta',
    'orange',
    'red',
    'turquoise',
    'brown',
    'yellow',
    'violet',
);

foreach ($colors as &$color) {
    /** @var string $name */
    /** @var array $translations */
    extract($color);

    // Skip already set translations.
    if (isset($translations[$target])) {
        continue;
    }

    // Skip other colors if in primary mode.
    if ($primary && !in_array($name, $primaryColors)) {
        continue;
    }

    echo "Translate \033[1;32m$name\033[m:\n";
    foreach ($translations as $lang => $translation) {
        echo "\033[1;33m$lang\033[m = $translation\n";
    }
    echo "\033[1;33m$target\033[m = ";
    $text = ask();

    if (empty($text)) {
        echo "\033[0;31mLeft translation empty for $name\033[m\n";
        continue;
    }

    $color['translations'][$target] = $text;
    save($colors);
}

save($colors);

function save($colors)
{
    file_put_contents(__DIR__ . ' /../colors.json', json_encode($colors));
    echo "Saved translations.\n";
}

function ask()
{
    $handle = fopen("php://stdin", "r");
    $text = trim(fgets($handle));
    fclose($handle);

    return $text;
}
