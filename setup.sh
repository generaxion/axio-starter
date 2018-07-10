#!/bin/bash
# Theme setup.

# Defaults
default_name="Aucor Starter"
default_id="aucor_starter"
default_url="https://aucor_starter.local"
default_author="Aucor Oy"
default_authorurl="https://www.aucor.fi"
default_locale="fi"

# Directories
basedir="$( cd "$( dirname "$0" )" && pwd )/."
assetsdir="$basedir/assets"
basedir_all_files="$basedir/."
setup_script="$basedir/setup.sh"

# Text styles
bold=$(tput bold)
white=$(tput setaf 7)
pink=$(tput setaf 198)
green=$(tput setaf 2)
txtreset=$(tput sgr0)

echo "${bold}${pink}
    aucorauco     aucoraucor
  raucoraucorau   coraucoraucor
 corauc     or  aucora     ucora
ucora          ucora        ucora
ucor         aucora         ucora
 aucor      aucorauc       orauc
  oraucoraucorau coraucorauauco
    raucoraucor     aucoraucor    ${txtreset}"
echo "${bold}
        aucor-starter
      ${txtreset}"

echo "1) Set name for your theme. (Default: $default_name)"
read name
# use default if empty
if test -n "$name"; then
  echo ""
else
  id=$default_name
fi

echo "2) Set unique id for your theme. Use only a-z and _. (Default: $default_id)"
read id

# use default if empty
if test -n "$id"; then
  echo ""
else
  id=$default_id
fi

echo "3) Set local development url. (Default: $default_url)"
read url

# use default if empty
if test -n "$url"; then
  echo ""
else
  url=$default_url
fi

echo "4) Set author name. (Default: $default_author)"
read author

# use default if empty
if test -n "$author"; then
  echo ""
else
  author=$default_author
fi

echo "5) Set author URL. (Default: $default_authorurl)"
read authorurl

# use default if empty
if test -n "$authorurl"; then
  echo ""
else
  authorurl=$default_authorurl
fi

while true; do
read -p "5) Is following information correct?

name: ${bold}${pink}$name${txtreset} (Default: $default_name)
id: ${bold}${pink}$id${txtreset} (Default: $default_id)
url: ${bold}${pink}$url${txtreset} (Default: $default_url)
author name: ${bold}${pink}$author${txtreset} (Default: $default_author)
author url: ${bold}${pink}$authorurl${txtreset} (Default: $default_authorurl)

Proceed to install? [y/N]
" yn
  case $yn in
    [Yy]* ) break;;
    [Nn]* ) exit;;
    * ) echo "Please answer y or n.";;
  esac
done

echo "
Run setup:
=========="

# style.css
find "$basedir" -name 'style.css' -type f -exec perl -p -i -e "s|$default_name|$name|g" {} \;

# PHP files
find "$basedir_all_files" -name '*.php' -type f -exec perl -p -i -e "s|$default_name|$name|g" {} \;

# README.md
find "$basedir" -name 'README.md' -type f -exec perl -p -i -e "s|$default_name|$name|g" {} \;

echo "--> Search & replace name ... ${green}done${txtreset}"

# PHP files
find "$basedir_all_files" -name '*.php' -type f -exec perl -p -i -e "s|$default_id|$id|g" {} \;

# style.css
find "$basedir" -name 'style.css' -type f -exec perl -p -i -e "s|$default_id|$id|g" {} \;

# bower.json
find "$basedir" -name 'bower.json' -type f -exec perl -p -i -e "s|$default_id|$id|g" {} \;

# package.json
find "$basedir" -name 'package.json' -type f -exec perl -p -i -e "s|$default_id|$id|g" {} \;

# README.md
find "$basedir" -name 'README.md' -type f -exec perl -p -i -e "s|$default_id|$id|g" {} \;

echo "--> Search & replace id ..... ${green}done${txtreset}"

# manifest.json
find "$assetsdir" -name 'manifest.js' -type f -exec perl -p -i -e "s|$default_url|$url|g" {} \;

echo "--> Change url .............. ${green}done${txtreset}"
# style.css
find "$basedir" -name 'style.css' -type f -exec perl -p -i -e "s|$default_author|$author|g" {} \;

echo "--> Set author name ......... ${green}done${txtreset}"

# style.css
find "$basedir" -name 'style.css' -type f -exec perl -p -i -e "s|$default_authorurl|$authorurl|g" {} \;

echo "--> Set author url .......... ${green}done${txtreset}"

echo "--> ${green}Setup complete!${txtreset}"

echo "--> setup.sh removed"
rm "$setup_script"


