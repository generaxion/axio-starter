# Image

## Install

1. Insert directory

## Contents

Helper component for displaying images (from WordPress uploads).

## Usage

Image sizes are defined in `/inc/_conf/register-images.php`. Tips for creating image sizes:

  * Base images on commonly used aspect ratios (16:9, 1:1)
  * Make "medium" half of the text columns and "large" full text column
  * Add additional sizes for responsive images (for example teaser_lg, teaser_md, teaser_sm)

### Embed images

```php
<?php X_Image::render([
  'id'        => 123,
  'size'      => 'large',
]); ?>
```

Theme has its own function for getting image markup that gives the developer control of which responsive sizes should be used and include lazy loading.

After you have setup WordPress image sizes go to `/inc/_conf/register-image-sizes.php` and setup your "human-sizes" (the sizes you will use as arguments). These human-sizes hold info of the primary image size, supporting sizes and what size the image is displayed.

```php
switch ($human_size) {

  case 'hero':
    return [
      'primary'    => 'hero_md',
      'supporting' => ['hero_lg', 'hero_md', 'hero_sm'],
      'sizes'      => '100vw'
    ];

  case 'thumbnail':
    return [
      'primary'    => 'thumbnail',
      'supporting' => ['full', 'thumbnail'],
      'sizes'      => '250px'
    ];

  default:
    x_debug('Image size error - Missing human readable size {' . $human_size . '}', ['x_get_image']);

}
```

Notice that many "human-sizes" can use same WordPress image sizes. This is useful for example when same image might be displayed different size on different devices so you can pass different "sizes" attributes for browser. [Read more about sizes attribute](https://css-tricks.com/responsive-images-css/#article-header-id-1).

**Protip:** If you use CSS property `object-fit` it needs special handling to work in IE11 and older. Theme has [object-fit-polyfill](https://github.com/constancecchen/object-fit-polyfill) installed and all you need to do is add special data attribute for img tag like
```php
X_Image::render([
  'id'    => 123,
  'size'  => 'medium',
  'attr'  => ['data-object-fit' => 'cover']
])
```

### Lazy load

By default the image function has lazy loading on. Lazy loading uses HTML's native `loading` attribute When emedding image there's three possibilities:

  * Default: Use lazyload `loading="lazy"`
  ```php
  X_Image::render([
    'id'    => 123,
    'size'  => 'medium'
  ])
  ```
  * No lazyload:
  ```php
  X_Image::render([
    'id'      => 123,
    'size'    => 'medium',
    'loading' => 'eager',
  ])
  ```

