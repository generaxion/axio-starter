#!/bin/bash
# Theme setup.

# Defaults
default_name="Axio by Generaxion"
default_url="https://axio-starter.local"
default_author="Generaxion"
default_authorurl="https://www.generaxion.com"

# Directories
basedir="$( cd "$( dirname "$0" )" && cd .. && pwd)"
assetsdir="$basedir/assets"
basedir_all_files="$basedir/."
setup_script="$basedir/bin/setup.sh"

# Text styles
bold=$(tput bold)
white=$(tput setaf 7)
blue=$(tput setaf 4)
green=$(tput setaf 2)
txtreset=$(tput sgr0)

echo "${bold}${blue}
            ___        ___
          gg@@@@a    a@@@@gg
           @@@@@@@  @@@@@@@
            *@@@@@@@@@@@@*
              _]\$@@@@@[_
            _@@@@@@@@@@@@_
           _@@@@@@h\`@@@@@@@_
          *N@@@@H    *@@@@N*
            \`\"\`        \`\"\`${txtreset}"
echo "${bold}
              A  X  I  O
             by Generaxion
      ${txtreset}"

echo "1) Set name for your theme. (Default: $default_name)"
read name
# use default if empty
if test -n "$name"; then
  echo ""
else
  name=$default_name
fi

echo "2) Set local development url. (Default: $default_url)"
read url

# use default if empty
if test -n "$url"; then
  echo ""
else
  url=$default_url
fi

echo "3) Set author name. (Default: $default_author)"
read author

# use default if empty
if test -n "$author"; then
  echo ""
else
  author=$default_author
fi

echo "4) Set author URL. (Default: $default_authorurl)"
read authorurl

# use default if empty
if test -n "$authorurl"; then
  echo ""
else
  authorurl=$default_authorurl
fi

while true; do
read -p "5) Is following information correct?

name: ${bold}${blue}$name${txtreset} (Default: $default_name)
url: ${bold}${blue}$url${txtreset} (Default: $default_url)
author name: ${bold}${blue}$author${txtreset} (Default: $default_author)
author url: ${bold}${blue}$authorurl${txtreset} (Default: $default_authorurl)

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


