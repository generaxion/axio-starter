# Aucor Banner Notification

**Contributors:** [Aleksi Aaltonen](https://github.com/aleksi-aaltonen)

**Tags:** wordpress, aucor, notification, component

**License:** GPLv2 or later

![Notification Banner screenshot](https://bitbucket.org/aucor/aucor-code-library/raw/1bc03e82490121d67e32d2c86915ca0a8f36e7a3/wp-components/notification-banner/screenshot.png)

## Description

Component for rendering a banner style -notification. Recommended placement: above hero. Can be used for all kinds of notifications, displaying differences in opening hours etc. Uses a cookie to save "is closed" data. Also, if the text or link is changed, the notification will be displayed again even if the user had closed it.

## How to use

### Required files
* component-banner.js
* _component-banner.scss
* component-banner.php
* component-banner-acf-import.json
* .svg icons (close, warning, info)

### Steps to install
1. Move .scss file to theme/assets/styles/components. Import it in main.scss.
```@import "components/component-banner";```

1. Move .php file to /components, and require it in theme/functions.php
```require_once 'components/component-banner.php';```

1. Move .js file to assets/scripts/components, and include it in manifest.js

1. Import the .json in acf options, from WordPress admin. When registering new fields for additional languages, recommended field group naming is as follows: same field names as default, but with "lang_" prefix. For example _en_notification_text_. This way the code works out of the box.

1. Move the included .svg -files to assets/sprite (or use project specific icons).

1. Usage: call renderer
```<?php Aucor_Notification_Banner::render(); ?>```
