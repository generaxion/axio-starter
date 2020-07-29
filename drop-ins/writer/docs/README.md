# Aucor Writer

**Contributors:** [Patric Manner](https://github.com/patricmanner)

**Tags:** wordpress, aucor, writer, component

**License:** GPLv2 or later

![Writer screenshot](https://bitbucket.org/aucor/aucor-code-library/raw/44ae52cc816a57bc9271d66e8815355c8b627150/wp-components/writer/screenshot.png)

## Description

A writer taxonomy and markup for post types. Supports multiple writers per post.

## How to use

### Required files
* _writer.scss
* writer-acf-import.json
* writer-tax.php
* writer.php

### Steps to install
1. Move .scss file to theme/assets/styles/components. Import it in main.scss.
```@import "components/writer";```

2. Register writer taxonomy by requiring it in theme/plugin.
```require_once 'tax/writer-tax.php';```

3. Move .php file to /components, and require it in theme/functions.php.
```require_once 'components/writer.php';```

4. Import the .json in ACF options, from WordPress admin.

5. Usage: call renderer
```<?php Aucor_Writer::render(); ?>```
