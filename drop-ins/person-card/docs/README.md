# Aucor Person Card

**Contributors:** [Janne Argillander](https://github.com/jargillander)

**Tags:** wordpress, aucor, person card, component

**License:** GPLv2 or later

![Person card screenshot](https://bitbucket.org/aucor/aucor-code-library/raw/23ee66d76045a8e24d7e16447db582201a801869/wp-components/person-card/screenshot.png)

## Description

Component for person card

## How to use

### Required files
* _person_card.scss
* person-card.php
* person-card-acf-import.json
* person-card-cpt.php

### Steps to install
1. Move .scss file to theme/assets/styles/components. Import it in main.scss.
```@import "components/person-card";```

2. Register person card custom post type by requiring it in theme/plugin.
```require_once 'cpt/person-card-cpt.php';```

3. Move .php file to /components, and require it in theme/functions.php.
```require_once 'components/person-card.php';```

4. Import the .json in acf options, from WordPress admin.

5. Usage: call renderer
```<?php Aucor_Person_Card::render(); ?>```
