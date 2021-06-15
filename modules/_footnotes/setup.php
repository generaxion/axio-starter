<?php
/**
 * Setup
 *
 *
 * @package lor
 */

// above footer
//add_action('theme_entry_footer', function() {
//}, 50, 1);

// after content
add_filter('the_content', function($data) {

  if (!is_single()) return $data;

  $data = Footnotes_SD::instance()->process($data);

  return $data . Aucor_Footnotes::get();

}, 20, 1);

/**
 * https://wordpress.org/plugins/footnotes-made-easy/
 * https://github.com/dartiss/footnotes-made-easy
 * Class Footnotes_SD
 */
class Footnotes_SD {
  private $options;
  private $start_number;
  private $footnotes;
  private $use_full_link; // Incremented when the options array changes
  private $styles;
  private $style;

  private static $instance;

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new Footnotes_SD();
    }

    return self::$instance;
  }

  function __construct() {

    // Define the implemented option styles

    $this->styles = [
      'decimal'              => '1,2...10',
      'decimal-leading-zero' => '01, 02...10',
      'lower-alpha'          => 'a,b...j',
      'upper-alpha'          => 'A,B...J',
      'lower-roman'          => 'i,ii...x',
      'upper-roman'          => 'I,II...X',
      'symbol'               => 'Symbol'
    ];

    // Define default options

    $this->options = [
      'superscript'             => true,
      'pre_backlink'            => ' ',
      'backlink'                => '&#8617;',
      'post_backlink'           => '',
      'pre_identifier'          => '',
      'inner_pre_identifier'    => '',
      'list_style_type'         => 'decimal',
      'list_style_symbol'       => '&dagger;',
      'inner_post_identifier'   => '',
      'post_identifier'         => '',
      'pre_footnotes'           => '',
      'post_footnotes'          => '',
      'no_display_home'         => false,
      'no_display_preview'      => false,
      'no_display_archive'      => false,
      'no_display_date'         => false,
      'no_display_category'     => false,
      'no_display_search'       => false,
      'no_display_feed'         => false,
      'combine_identical_notes' => true,
      'priority'                => 11,
      'footnotes_open'          => ' ((',
      'footnotes_close'         => '))',
      'pretty_tooltips'         => false,
    ];

    // Hook me up
    //add_action('the_content', [$this, 'process'], $this->current_options['priority']);
  }

  /**
   * Searches the text and extracts footnotes
   *
   * Adds the identifier links and creats footnotes list
   *
   * @param    $data    string    The content of the post
   *
   * @return            string    The new content with footnotes generated
   * @since    1.0
   *
   */
  function process($data) {
    global $post;

    // Ensure post exists

    if (!$post) {
      return $data;
    }

    // Check for and setup the starting number

    $this->start_number = $start_number = (1 === preg_match("|<!\-\-startnum=(\d+)\-\->|", $data, $start_number_array)) ? $start_number_array[1] : 1;
    // Regex extraction of all footnotes (or return if there are none)

    if (!preg_match_all("/(" . preg_quote($this->options['footnotes_open'], "/") . ")(.*)(" . preg_quote($this->options['footnotes_close'], "/") . ")/Us", $data, $identifiers, PREG_SET_ORDER)) {
      return $data;
    }

    // Check whether we are displaying them or not

    $display         = true;
    $this->footnotes = [];

    // Check if this post is using a different list style to the settings
    $this->style = $this->options['list_style_type'];

    // Create 'em

    for ($i = 0; $i < count($identifiers); $i++) {

      // Look for ref: and replace in identifiers array

      if ('ref:' === substr($identifiers[$i][2], 0, 4)) {
        $ref                     = ( int ) substr($identifiers[$i][2], 4);
        $identifiers[$i]['text'] = $identifiers[$ref - 1][2];
      }
      else {
        $identifiers[$i]['text'] = $identifiers[$i][2];
      }

      // if we're combining identical notes check if we've already got one like this & record keys

      if ($this->options['combine_identical_notes']) {
        for ($j = 0; $j < count($this->footnotes); $j++) {
          if ($this->footnotes[$j]['text'] === $identifiers[$i]['text']) {
            $identifiers[$i]['use_footnote']      = $j;
            $this->footnotes[$j]['identifiers'][] = $i;
            break;
          }
        }
      }

      if (!isset($identifiers[$i]['use_footnote'])) {

        // Add footnote and record the key

        $identifiers[$i]['use_footnote']                                    = count($this->footnotes);
        $this->footnotes[$identifiers[$i]['use_footnote']]['text']          = $identifiers[$i]['text'];
        $this->footnotes[$identifiers[$i]['use_footnote']]['symbol']        = isset($identifiers[$i]['symbol']) ? $identifiers[$i]['symbol'] : '';
        $this->footnotes[$identifiers[$i]['use_footnote']]['identifiers'][] = $i;
      }
    }

    // Footnotes and identifiers are stored in the array
    $this->use_full_link = false;
    if (is_feed()) $this->use_full_link = true;

    if (is_preview()) $this->use_full_link = false;

    // Display identifiers

    foreach ($identifiers as $key => $value) {

      $id_id      = "identifier_" . $key . "_" . $post->ID;
      $id_num     = ($this->style === 'decimal') ? $value['use_footnote'] + $start_number : $this->convert_num($value['use_footnote'] + $start_number, $this->style, count($this->footnotes));
      $id_href    = (($this->use_full_link) ? get_permalink($post->ID) : '') . "#footnote_" . $value['use_footnote'] . "_" . $post->ID;
      $id_title   = str_replace('"', "&quot;", htmlentities(html_entity_decode(wp_strip_all_tags($value['text']), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'));
      $id_replace = $this->options['pre_identifier'] . '<a href="' . $id_href . '" id="' . $id_id . '" class="footnote-link footnote-identifier-link" title="' . $id_title . '">' . $this->options['inner_pre_identifier'] . $id_num . $this->options['inner_post_identifier'] . '</a>' . $this->options['post_identifier'];
      if ($this->options['superscript']) $id_replace = '<sup>' . $id_replace . '</sup>';
      if ($display) $data = substr_replace($data, $id_replace, strpos($data, $value[0]), strlen($value[0]));
      else $data = substr_replace($data, '', strpos($data, $value[0]), strlen($value[0]));
    }


    /**
     * Display footnotes after content
     * Or
     * echo Footnotes_SD::$instance->display_footnotes();
     */
    //if ($display) {
    //	$data .= $this->display_footnotes();
    //}

    return $data;
  }


  function get_footnotes() {
    global $post;

    if (!$this->footnotes) return '';

    $footnotes_markup = '';
    $start            = ($this->start_number !== 1) ? 'start="' . $this->start_number . '" ' : '';
    $footnotes_markup = $footnotes_markup . '<ol ' . $start . '>';

    foreach ($this->footnotes as $key => $value) {
      $footnotes_markup = $footnotes_markup . '<li id="footnote_' . $key . '_' . $post->ID . '" class="footnote"';
      if ('symbol' === $this->style) {
        $footnotes_markup = $footnotes_markup . ' style="list-style-type:none;"';
      }
      elseif ($this->style !== $this->options['list_style_type']) {
        $footnotes_markup = $footnotes_markup . ' style="list-style-type:' . $this->style . ';"';
      }
      $footnotes_markup = $footnotes_markup . '>';
      if ('symbol' === $this->style) {
        $footnotes_markup = $footnotes_markup . '<span class="symbol">' . $this->convert_num($key + $this->start_number, $this->style, count($this->footnotes)) . '</span> ';
      }
      $footnotes_markup = $footnotes_markup . $value['text'];
      if (!is_feed()) {
        $footnotes_markup .= '<span class="footnote-back-link-wrapper">';
        foreach ($value['identifiers'] as $identifier) {
          $footnotes_markup = $footnotes_markup . $this->options['pre_backlink'] . '<a rel="nofollow" href="' . (($this->use_full_link) ? get_permalink($post->ID) : '') . '#identifier_' . $identifier . '_' . $post->ID . '" class="footnote-link footnote-back-link">' . $this->options['backlink'] . '</a>' . $this->options['post_backlink'];
        }
        $footnotes_markup .= '</span>';
      }
      $footnotes_markup = $footnotes_markup . '</li>';
    }
    $footnotes_markup = $footnotes_markup . '</ol>';

    return $footnotes_markup;
  }




  /**
   * Convert number
   *
   * Convert number to a specific style
   *
   * @param    $num      string    The number to be converted
   * @param    $style    string    The style of output required
   * @param    $total    string    The total length
   *
   * @return            string    The converted number
   * @since    1.0
   *
   */
  function convert_num($num, $style, $total) {

    switch ($style) {
      case 'decimal-leading-zero' :
        $width = max(2, strlen($total));

        return sprintf("%0{$width}d", $num);
      case 'lower-roman' :
        return $this->roman($num, 'lower');
      case 'upper-roman' :
        return $this->roman($num);
      case 'lower-alpha' :
        return $this->alpha($num, 'lower');
      case 'upper-alpha' :
        return $this->alpha($num);
      case 'symbol' :
        $sym = '';
        for ($i = 0; $i < $num; $i++) {
          $sym .= $this->options['list_style_symbol'];
        }

        return $sym;
    }

    return $this->alpha($num);
  }

  /**
   * Convert to a roman numeral
   *
   * Convert a provided number into a roman numeral
   *
   * @param int    $num  The number to convert.
   * @param string $case Upper or lower case.
   *
   * @return    string            The roman numeral
   * @since    1.0
   *
   */

  function roman($num, $case = 'upper') {

    $num        = ( int ) $num;
    $conversion = [
      'M'  => 1000,
      'CM' => 900,
      'D'  => 500,
      'CD' => 400,
      'C'  => 100,
      'XC' => 90,
      'L'  => 50,
      'XL' => 40,
      'X'  => 10,
      'IX' => 9,
      'V'  => 5,
      'IV' => 4,
      'I'  => 1
    ];
    $roman      = '';

    foreach ($conversion as $r => $d) {
      $roman .= str_repeat($r, ( int ) ($num / $d));
      $num   %= $d;
    }

    return ($case === 'lower') ? strtolower($roman) : $roman;
  }

  function alpha($num, $case = 'upper') {
    $j = 1;
    for ($i = 'A'; $i <= 'ZZ'; $i++) {
      if ($j === $num) {
        if ('lower' === $case)
          return strtolower($i);
        else
          return $i;
      }
      $j++;
    }

    return '';
  }

  /**
   * Tooltip Scripts
   *
   * Add scripts and CSS for pretty tooltips
   *
   * @since    1.0
   */

  function tooltip_scripts() {

    wp_enqueue_script(
      'wp-footnotes-tooltips',
      plugins_url('js/tooltips.min.js', __FILE__),
      [
        'jquery',
        'jquery-ui-widget',
        'jquery-ui-tooltip',
        'jquery-ui-core',
        'jquery-ui-position'
      ]
    );

    wp_enqueue_style('wp-footnotes-tt-style', plugins_url('css/tooltips.min.css', __FILE__), [], null);
  }
}
