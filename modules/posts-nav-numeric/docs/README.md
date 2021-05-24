# Numeric posts navigation

## Install

1. Insert directory

## Contents

Helper component for better pagination.

## Usage

Main query:
```php
if(have_posts())
  while (have_posts()) : the_post();
    ...
  endwhile;
  X_Posts_Nav_Numeric::render();
endif;
```

Custom query:
```php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = [
  'post_type'       => 'post',
  'posts_per_page'  => 10,
  'paged'           => $paged,
];
$loop = new WP_Query($args);
if($loop->have_posts())
  while ($loop->have_posts()) : $loop->the_post();
    ...
  endwhile;
  X_Posts_Nav_Numeric::render(['wp_query' => $loop]);
endif;
```

Custom query with your own pagination variable "current_page"
```php
$paged = (isset($_GET['current_page']) && !empty($_GET['current_page'])) ? absint($_GET['current_page']) : 1;
$args = [
  'post_type'       => 'post',
  'posts_per_page'  => 10,
  'paged'           => $paged,
];
$loop = new WP_Query($args);
if ($loop->have_posts())
  while ($loop->have_posts() ) : $loop->the_post();
    ...
  endwhile;
  x_numeric_posts_nav([
    'wp_query'  => $loop,
    'paged_var' => 'current_page',
  ]);
endif;
```
