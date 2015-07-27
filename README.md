Color properties and translations
=================================

This is a repository containing color properties and translations for general purpose.


## Usage

This is how a color entry looks like: 

```json
{
    "name": "red",
    "html": "Red",
    "hex": "#FF0000",
    "translations": {
        "de": "rot",
        "en": "red",
        "es": "rojo",
        "fr": "rouge",
        "pl": "czerwony"
    },
    "red": 255,
    "green": 0,
    "blue": 0,
    "hue": 0,
    "saturation": 1,
    "value": 1,
    "lightness": 0.5
    "black": 0,
    "cyan": 0,
    "magenta": 1,
    "yellow": 1
}
```

### RGB values

red: 0 … 255
green: 0 … 255
blue: 0 … 255

### HSL values

hue: degrees, 0 … 360
saturation: 0 … 1
lightness: 0 … 1

### HSV values

value: 0 … 1

### CMYK values

black: 0 … 1
cyan: 0 … 1
magenta: 0 … 1
yellow: 0 … 1


## Build resources

You can build all resources by yourself, but they are all checked in, too.

Use the PHP scripts in the `build` directory:

- **build_cmyk.php** calculates CMYK values for the `colors.json`
- **build_hsl.php** calculates HSL values for the `colors.json`
- **build_rgb.php** calculates RGB values for the `colors.json`
- **build_xliff.php** builds XLIFF translation files by all existing translation keys
