# SVG

## Install

1. Insert directory

## Contents

Helper component for SVG sprites.

## Usage

Displays a svg image from assets/sprite

In PHP you can get these icons with:

```php
<?php X_SVG::render([
  'name' => 'facebook'
]); ?>
```

Theme includes one big SVG sprite `/assets/images/icons.svg` that has by default a caret (dropdown arrow) and a few social icons. Add your own svg icons in `/assets/sprite/` and Gulp will add them to this sprite with id from filename.

Example: Print out SVG `/assets/sprite/facebook.svg`
```php
<?php X_SVG::render([
  'name' => 'facebook'
]); ?>
```
