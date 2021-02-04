# Directories
dir_bin="$( cd "$( dirname "$0" )" && pwd )/."
dir_theme="$( cd "$( dirname "$0" )" && cd .. && pwd)"

# Helpers
package_line_regex='(.*) \|\| (.*)'

echo "
╔══════════════════════════════╗
║                              ║
║           🤖 🤖 🤖           ║
║    L o c a l i z a t o r     ║
║            1.0.0             ║
║                              ║
╚══════════════════════════════╝

Protip: Make commit / backup before running Localizator.
"

echo "1) Input a supported locale code (en, fi)"
read locale
# use default if empty
if test -n "$locale"; then
  echo ""
else
  locale="en"
fi

echo "Searching packages at */localizator/$locale.txt"

# Find and process all Localizator packs
find "$dir_theme" -path "*/localizator/*" -name "$locale.txt" -type f | while read locale_package; do

echo "
📦 Processing package: $locale_package
"

  while IFS= read -r line value
  do

    [[ $line =~ $package_line_regex ]] || continue
    key=${BASH_REMATCH[1]}
    value=${BASH_REMATCH[2]}

    if [[ -n $key ]]; then
      if [[ -n $value ]]; then

      # remove leading whitespace characters
      key="${key#"${key%%[![:space:]]*}"}"
      value="${value#"${value%%[![:space:]]*}"}"

      # remove trailing whitespace characters
      key="${key%"${key##*[![:space:]]}"}"
      value="${value%"${value##*[![:space:]]}"}"

      ##
      # Regex pattern to replace strings
      #
      # String format:
      # 'String key'    => 'String value',
      # 'String key'=>'String value'
      #
      # Invalid formatting:
      # "String key"    => "String value",
      #
      # Rexex pattern finds
      # 1. string has character '
      # 2. string includes current $key
      # 3. string has character '
      # 4. string has 0-many whitespace characters (captured)
      # 5. string has =>
      # 6. string has 0-many whitespace characters (captured)
      # 7. string has character '
      # 8. string has any characters (captured)
      # 9. string has character '
      ##
      replacements=0
      find "$dir_theme/" -name '*.php' -type f -exec perl -p -i -e "s|'$key'(\s*)=>(\s*)'(.*)'|'$key'\1=>\2'$value'|g" {} \;

      # if [ "$replacements" -gt 0 ]; then
      #   echo "$key ... done"
      # else
      #   echo "$key ... not found"
      # fi

      echo "$key ... done"


      fi
    fi


  done < "$locale_package"

done

while true; do
read -p "
2) Remove Localizator packages? (recommended: yes) [y/N]
" yn
  case $yn in
    [Yy]* ) break;;
    [Nn]* ) exit;;
    * ) echo "Please answer y or n.";;
  esac
done

# Delete localizator packages
find "$dir_theme" -path "*/localizator/*" -type f -name "$locale.txt" -delete

echo "Packages deleted for locale $locale"
