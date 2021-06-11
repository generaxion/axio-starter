# Axio Starter Custom

Axio Starter  
axio-starter-6.0.0

- https://github.com/generaxion/axio-starter
- https://github.com/aucor/aucor-core

## Clone

Clone my Axio Starter Fork  
(assuming I can keep mod branch up to date with axio-starter master )

```bash
git clone https://github.com/kauaicreative/axio-starter.git
git git branch -av
git switch mod
```

### or

Clone Axio Starter  
Clone Axio Starter Custom  
(And overwrite files from axio-starter-custom)

```bash
cd wp-content

git clone https://github.com/generaxion/axio-starter.git themes
git clone https://github.com/aucor/aucor-core.git mu-plugin 

git clone https://github.com/kauaicreative/axio-starter-custom.git

cp -R axio-starter-custom/axio-starter/* themes/axio-starter -Force
cp -R axio-starter-custom/mu-plugins/* mu-plugins -Force
```

Create new git https://github.com/new

```bash
mv themes/axio-starter themes/SITE
cd themes/SITE

rm -rf .git # Linux
rm -r -Force .git # Powershell

git init
git add .
git commit -m "axio"
git branch -M main
git remote add origin https://github.com/kauaicreative/SITE.git
git push -u origin main
```


Install
```bash
bash # must be completed from WSL 
sh bin/setup.sh
sh bin/localizator.sh
# exit WSL

npm i
gulp vars
gulp fonts
gulp 

git add .;git commit -m "setup"; git push
```

Rename (hide) or delete
- modules/_button, _gravity-forms, _media-text
- inc/auto/_hide?

Edit
- modules/header/component.php

```bash
git add .;git commit -m "configured"; git push
```

Create `wp-content/mu-plugins`

```bash
mkdir mu-plugins
cd mu-plugins
git clone https://github.com/aucor/aucor-core.git
```

```php
/**
 * Config Aucor Core
 * https://github.com/aucor/aucor-core
 */
 
/** Admin */
add_filter( 'aucor_core_admin_gallery', '__return_false' );
add_filter( 'aucor_core_admin_image_link', '__return_false' );
add_filter( 'aucor_core_admin_profile_cleanup', '__return_false' );

/** Dashboard */
add_filter( 'aucor_core_dashboard_cleanup', '__return_false' );
add_filter( 'aucor_core_dashboard_remove_panels', '__return_false' );

/** ront-end */
add_filter( 'aucor_core_front_end', '__return_false' );

/** security */
// add_filter( 'aucor_core_security_remove_comment_moderation', '__return_false' );
// add_filter( 'aucor_core_security_remove_commenting', '__return_false' );

require WPMU_PLUGIN_DIR . '/aucor-core/plugin.php';
```
