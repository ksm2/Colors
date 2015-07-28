<?php
/**
 * Build Xliff translations out of colors.json
 * @author Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 */

$file = __DIR__ . '/../colors.json';
$color_json = file_get_contents($file);
$colors = json_decode($color_json, true);

$output = realpath(__DIR__ . '/../xliff');
$xliffConfigs = [];

foreach ($colors as $color) {
    extract($color);
    $transUnit = $name;
    $en = $translations['en'];

    foreach ($translations as $lang => $translation) {
        if (!isset($xliffConfigs[$lang])) {
            $xliffConfigs[$lang] = [];
        }

        $xliffConfigs[$lang][$transUnit] = ['source' => $en, 'target' => $translation];
    }
}

foreach ($xliffConfigs as $lang => $transUnits) {
    $rows = "";
    foreach ($transUnits as $transUnit => $config) {
        $rows .= <<<XLIFF
            <trans-unit id="$transUnit">
                <source>${config['source']}</source>
                <target>${config['target']}</target>
            </trans-unit>

XLIFF;
    }

    $contents = <<<XLIFF
<?xml version="1.0"?>
<xliff version="1.2"
       xmlns="urn:oasis:names:tc:xliff:document:1.2"
       xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
       xsi:schemaLocation="urn:oasis:names:tc:xliff:document:1.2 xliff-core-1.2.xsd">
    <file original="colors.json" source-language="en" target-language="$lang" datatype="plaintext">
        <body>
$rows
        </body>
    </file>
</xliff>
XLIFF;

    file_put_contents($output . '/colors.' . $lang . '.xlf', $contents);
}
