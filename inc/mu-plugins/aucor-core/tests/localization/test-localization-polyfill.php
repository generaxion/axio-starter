<?php
/**
 * Class LocalizationPolyfillTest
 *
 * @package Aucor_Core
 */

class LocalizationPolyfillTest extends WP_UnitTestCase {

  private $local;

  public function setUp() {
    parent::setUp();
    $this->local = new Aucor_Core_Localization;
  }

  public function tearDown() {
    unset($this->local);
    parent::tearDown();
  }

  // test localization sub feature

  public function test_localization_polyfill() {
    $class = $this->local->get_sub_features()['aucor_core_localization_polyfill'];
    // key
    $this->assertNotEmpty(
       $class->get_key()
    );
    // name
    $this->assertNotEmpty(
      $class->get_name()
    );
    // status
    $this->assertTrue(
      $class->is_active()
    );

    /**
     * Run
     * - nothing is actually run in the run function, but the "semi-class" provides
     *  polyfill functions for the Polylang plugin
     */

    // AUCOR_CORE_GET_SITE_LOCALE()

    // mock (invalid) args
    add_filter('locale', function($locale) {
      $locale = 'a'; // invalid locale

      return $locale;
    });

    // check that function return correct value
    $this->assertSame(
      '', aucor_core_get_site_locale()
    );

    // // mock (valid) args
    add_filter('locale', function($locale) {
      $locale = 'en_US';

      return $locale;
    });

    // check that function return correct value
    $this->assertSame(
      'en', aucor_core_get_site_locale()
    );

    // FOR ALL THE POLYFILLS

    // check that the function exists, mock args and check return values
    // for the _e()-functions buffer the output

    $this->assertTrue(
      function_exists('pll__')
    );
    $string = 'Test';
    $this->assertSame(
      $string, pll__($string)
    );

    $this->assertTrue(
      function_exists('pll_e')
    );
    $string2 = 'Test 2';
    ob_start();
    pll_e($string2);
    $output = ob_get_contents();
    ob_clean();
    $this->assertSame(
      $string2, $output
    );

    $this->assertTrue(
      function_exists('pll_esc_html__')
    );
    $html = '<a href="http://www.example.com/">A link</a>';
    $this->assertSame(
      '&lt;a href=&quot;http://www.example.com/&quot;&gt;A link&lt;/a&gt;', pll_esc_html__($html)
    );

    $this->assertTrue(
      function_exists('pll_esc_html_e')
    );
    $html2 = '<div class="example">A div</div>';
    pll_esc_html_e($html2);
    $output2 = ob_get_contents();
    ob_clean();
    $this->assertSame(
      '&lt;div class=&quot;example&quot;&gt;A div&lt;/div&gt;', $output2
    );

    $this->assertTrue(
      function_exists('pll_esc_attr__')
    );
    $attr = 'A & B';
    $this->assertSame(
      'A &amp; B', pll_esc_attr__($attr)
    );

    $this->assertTrue(
      function_exists('pll_esc_attr_e')
    );
    $attr2 = '"Quotes"';
    pll_esc_attr_e($attr2);
    $output3 = ob_get_clean();
    $this->assertSame(
      '&quot;Quotes&quot;', $output3
    );

    $this->assertTrue(
      function_exists('pll_current_language')
    );
    add_filter('locale', function($locale) {
      $locale = 'fi';

      return $locale;
    });
    $this->assertSame(
      'fi', pll_current_language()
    );

    $this->assertTrue(
      function_exists('pll_get_post_language')
    );
    add_filter('locale', function($locale) {
      $locale = 'sv_SE';

      return $locale;
    });
    $post = $this->factory->post->create();
    $this->assertSame(
      'sv', pll_get_post_language($post)
    );

    $this->assertTrue(
      function_exists('pll_get_post')
    );
    $post2 = $this->factory->post->create();
    $this->assertSame(
      $post2, pll_get_post($post2, 'test_slug')
    );

    $this->assertTrue(
      function_exists('pll_get_term')
    );
    $term = $this->factory->term->create();
    $this->assertSame(
      $term, pll_get_term($term, 'test_slug2')
    );

    $this->assertTrue(
      function_exists('pll_translate_string')
    );
    $string3 = 'Test 3';
    $this->assertSame(
      $string3, pll_translate_string($string3, 'test_lang')
    );

    $this->assertTrue(
      function_exists('pll_home_url')
    );
    $this->assertSame(
      get_home_url(), pll_home_url('test_slug3')
    );

  }

}
