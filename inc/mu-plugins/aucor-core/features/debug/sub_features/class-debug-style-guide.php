<?php
/**
 * Class Debug_Style_Guide
 */
class Aucor_Core_Debug_Style_Guide extends Aucor_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'aucor_core_debug_style_guide');

    // var: name
    $this->set('name', 'Add test markup to a page');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_filter('the_content', array($this, 'aucor_core_style_guide_markup'));
  }

  /**
   * Add style guide test markup if the GET parameter "?ac-debug=styleguide" is present in the url.
   * The aucor_core_custom_markup filter makes it possible to replace the default with custom markup
   *
   * @param string content from the_content()
   *
   * @return string style guide or custom markup
   */
  public static function aucor_core_style_guide_markup($content) {
    if (isset($_GET['ac-debug']) && $_GET['ac-debug'] == 'styleguide') {
      // get wp default large and medium image sizes
      $img_medium_w = get_option('medium_size_w');
      $img_large_w = get_option('large_size_w');
      // default style guide markup
      ob_start();
      ?>
      <p class="lead">Lead paragraph - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis massa tempor, tincidunt massa convallis, consequat massa. Curabitur eget erat libero. Ut ornare mollis suscipit. Praesent eu odio vestibulum, hendrerit nisi a, euismod urna. Sed eget diam ac purus malesuada consectetur.</p>

      <h2>Heading 2</h2>

      <p>Paragraph - Aenean id erat ut justo faucibus sollicitudin. Sed facilisis quam vitae mauris vehicula, id elementum dui mollis. Cras commodo neque id lorem vehicula, vel aliquet arcu volutpat. Duis consequat ligula elit, eget pellentesque diam molestie nec. Phasellus facilisis vulputate dui non luctus.</p>

      <h3>Heading 3</h3>

      <p>Paragraph - Nulla efficitur justo in turpis fermentum, eu pellentesque justo sagittis. Morbi pretium elit sed interdum sodales. Phasellus a dui mattis, sollicitudin mauris in, convallis est. Nullam a urna et est ultrices aliquet.</p>

      <p>Paragraph - Cras aliquam sed risus ac hendrerit. Donec nisi nisi, dapibus a dui eu, tristique faucibus felis. Quisque eleifend sit amet felis eget volutpat. Proin et cursus ex.</p>

      <h4>Heading 4</h4>

      <p>Paragraph - Aenean nec maximus augue. Nullam ac dapibus urna. Nunc dignissim magna leo. Duis at convallis nisi. Pellentesque eu congue odio. Proin imperdiet eros a tincidunt dignissim. Nam euismod id metus vitae maximus. Vestibulum in nulla vulputate, vehicula odio elementum, tincidunt risus.</p>

      <h5>Heading 5</h5>

      <p>Paragraph - Curabitur nibh sem, semper quis pellentesque a, mollis non elit. Mauris varius dolor ut eros placerat, ac ultricies urna rhoncus. Aliquam purus libero, gravida et laoreet in, pretium eget urna.</p>

      <p>Paragraph - Vestibulum nec ligula nulla. Nullam sed iaculis velit, dapibus aliquam felis. Praesent quis egestas justo.</p>

      <h6>Heading 6</h6>

      <p>Paragraph - Vivamus interdum metus eros, id semper libero euismod consectetur. Sed ac magna tincidunt, accumsan ligula sit amet, fringilla sapien.</p>

      <blockquote>Blockquote - Sed sollicitudin tristique cursus. Nullam vel libero quis neque molestie ornare. Quisque sollicitudin nulla id pulvinar dictum.</blockquote>

      <p><a href="#">Anchor</a></p>

      <p><a href="#" class="button">a-tag with button class</a></p>

      <ol>
        <li>Ordered</li>
        <li>List</li>
      </ol>

      <p><strong>Strong</strong></p>

      <ul>
        <li>Unordered</li>
        <li>List</li>
      </ul>

      <p><em>Emphasis</em></p>

      <table>
        <tr>
          <th>Header</th>
          <th>Header</th>
        </tr>
        <tr>
          <td>Data</td>
          <td>Data</td>
        </tr>
        <tr>
          <td>Data</td>
          <td>Data</td>
        </tr>
        <tr>
          <td>Data</td>
          <td>Data</td>
        </tr>
      </table>

      <p>Paragraph - Aenean id erat ut justo faucibus sollicitudin. Sed facilisis quam vitae mauris vehicula, id elementum dui mollis. Cras commodo neque id lorem vehicula, vel aliquet arcu volutpat. Duis consequat ligula elit, eget pellentesque diam molestie nec. Phasellus facilisis vulputate dui non luctus.</p>

      <p>
        <img class="size-large alignnone" src="https://source.unsplash.com/<?php echo $img_large_w . 'x' . $img_large_w; ?>/?doge" width="<?php echo $img_large_w; ?>" alt="Large image, align none">
      </p>

      <p>Paragraph - Nulla efficitur justo in turpis fermentum, eu pellentesque justo sagittis. Morbi pretium elit sed interdum sodales. Phasellus a dui mattis, sollicitudin mauris in, convallis est. Nullam a urna et est ultrices aliquet.</p>

      <p>
        <img class="size-medium alignleft" src="https://source.unsplash.com/<?php echo $img_medium_w . 'x' . $img_medium_w; ?>/?doge" width="<?php echo $img_medium_w; ?>" alt="Medium image, align left">
      </p>

      <p>Paragraph - Aenean nec maximus augue. Nullam ac dapibus urna. Nunc dignissim magna leo. Duis at convallis nisi. Pellentesque eu congue odio. Proin imperdiet eros a tincidunt dignissim. Nam euismod id metus vitae maximus. Vestibulum in nulla vulputate, vehicula odio elementum, tincidunt risus.</p>

      <p>Paragraph - Curabitur nibh sem, semper quis pellentesque a, mollis non elit. Mauris varius dolor ut eros placerat, ac ultricies urna rhoncus. Aliquam purus libero, gravida et laoreet in, pretium eget urna.</p>

      <p>Paragraph - Aenean nec maximus augue. Nullam ac dapibus urna. Nunc dignissim magna leo. Duis at convallis nisi. Pellentesque eu congue odio. Proin imperdiet eros a tincidunt dignissim. Nam euismod id metus vitae maximus. Vestibulum in nulla vulputate, vehicula odio elementum, tincidunt risus.</p>

      <p>Paragraph - Vestibulum nec ligula nulla. Nullam sed iaculis velit, dapibus aliquam felis. Praesent quis egestas justo.</p>

      <p>Paragraph - Aenean id erat ut justo faucibus sollicitudin. Sed facilisis quam vitae mauris vehicula, id elementum dui mollis. Cras commodo neque id lorem vehicula, vel aliquet arcu volutpat. Duis consequat ligula elit, eget pellentesque diam molestie nec. Phasellus facilisis vulputate dui non luctus.</p>

      <p>
        <img class="size-medium alignright" src="https://source.unsplash.com/<?php echo $img_medium_w . 'x' . $img_medium_w; ?>/?doge" width="<?php echo $img_medium_w; ?>" alt="Medium image, align right">
      </p>

      <p>Paragraph - Vivamus interdum metus eros, id semper libero euismod consectetur. Sed ac magna tincidunt, accumsan ligula sit amet, fringilla sapien.</p>

      <p>Paragraph - Cras turpis ante, varius quis auctor in, molestie non sapien. Duis efficitur, ante in volutpat vulputate, est turpis lacinia metus, et tincidunt nulla turpis sit amet nibh. In tincidunt, tortor quis euismod interdum, metus neque elementum sem, quis lacinia nisi mi non enim. Vestibulum scelerisque, massa id congue hendrerit, justo libero congue sapien, eleifend pellentesque tellus eros et ipsum. Maecenas quis dapibus nibh, id malesuada nunc. Etiam pretium eros in arcu commodo aliquam. Duis orci leo, faucibus sit amet auctor sed, dictum hendrerit massa. Nunc at nunc euismod odio feugiat malesuada. Nunc quam mauris, varius non euismod vitae, porttitor ac neque. Vivamus lacus dolor, efficitur aliquam egestas ac, rhoncus nec urna. Mauris nec sem turpis. Sed pharetra ipsum non nisl pretium condimentum.</p>

      <p>Paragraph - Suspendisse rutrum nibh vel efficitur semper. Fusce accumsan tristique arcu ut egestas. Nullam tempus est vel lectus tincidunt euismod. Etiam venenatis elit eu odio volutpat rutrum. Fusce id auctor lacus. Pellentesque sit amet aliquet enim, in dapibus sem. Sed mauris nulla, convallis ac risus sit amet, porta tincidunt purus. Vivamus at magna sed sem porttitor sagittis aliquam et urna. Etiam mattis risus a nunc malesuada condimentum. Ut felis est, rutrum vel dapibus ac, tincidunt sit amet orci.</p>
      <figure class="wp-caption alignnone" style="width:<?php echo $img_large_w; ?>px">
        <img class="size-large" src="https://source.unsplash.com/<?php echo $img_large_w . 'x' . $img_large_w; ?>/?doge" width="<?php echo $img_large_w; ?>" alt="Large image with caption, align none">
        <figcaption class="wp-caption-text">Caption - Proin imperdiet eros a tincidunt dignissim. Nam euismod id metus vitae maximus.</figcaption>
      </figure>

      <p>Paragraph - Aenean id erat ut justo faucibus sollicitudin. Sed facilisis quam vitae mauris vehicula, id elementum dui mollis. Cras commodo neque id lorem vehicula, vel aliquet arcu volutpat. Duis consequat ligula elit, eget pellentesque diam molestie nec. Phasellus facilisis vulputate dui non luctus.</p>

      <figure class="wp-caption aligncenter" style="width:<?php echo $img_medium_w; ?>px">
        <img class="size-medium" src="https://source.unsplash.com/<?php echo $img_medium_w . 'x' . $img_medium_w; ?>/?doge" width="<?php echo $img_medium_w; ?>" alt="Medium image with caption, align center">
        <figcaption class="wp-caption-text">Caption - Sed sollicitudin tristique cursus.</figcaption>
      </figure>

      <p>Paragraph - Nulla efficitur justo in turpis fermentum, eu pellentesque justo sagittis. Morbi pretium elit sed interdum sodales. Phasellus a dui mattis, sollicitudin mauris in, convallis est. Nullam a urna et est ultrices aliquet.</p>

      <figure class="wp-caption alignleft" style="width:<?php echo $img_medium_w; ?>px">
        <img class="size-medium" src="https://source.unsplash.com/<?php echo $img_medium_w . 'x' . $img_medium_w; ?>/?doge" width="<?php echo $img_medium_w; ?>" alt="Medium image with caption, align left">
        <figcaption class="wp-caption-text">Caption - Sed sollicitudin tristique cursus.</figcaption>
      </figure>

      <p>Paragraph - Aenean id erat ut justo faucibus sollicitudin. Sed facilisis quam vitae mauris vehicula, id elementum dui mollis. Cras commodo neque id lorem vehicula, vel aliquet arcu volutpat. Duis consequat ligula elit, eget pellentesque diam molestie nec. Phasellus facilisis vulputate dui non luctus.</p>

      <p>Paragraph - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis massa tempor, tincidunt massa convallis, consequat massa. Curabitur eget erat libero. Ut ornare mollis suscipit. Praesent eu odio vestibulum, hendrerit nisi a, euismod urna. Sed eget diam ac purus malesuada consectetur.</p>

      <p>Paragraph - Aenean nec maximus augue. Nullam ac dapibus urna. Nunc dignissim magna leo. Duis at convallis nisi. Pellentesque eu congue odio. Proin imperdiet eros a tincidunt dignissim. Nam euismod id metus vitae maximus. Vestibulum in nulla vulputate, vehicula odio elementum, tincidunt risus.</p>

      <hr>

      <h1>Usually problematic cases</h1>

      <h3>--- Long words ---</h3>

      <p><em>In a header</em></p>

      <p>H2</p>

      <h2>Epäjärjestelmällistyttämättömyydelläänsäkäänköhän</h2>

      <p>H3</p>

      <h3>Epäjärjestelmällistyttämättömyydelläänsäkäänköhän</h3>

      <p><em>In a list</em><p>

      <ul>
        <li>Epäjärjestelmällistyttämättömyydelläänsäkäänköhän</li>
        <ul>
        <li>Epäjärjestelmällistyttämättömyydelläänsäkäänköhän</li>
        </ul>
      </ul>

      <h3>--- Long centences ---</h3>

      <p><em>In a header</em></p>

      <p>H2</p>

      <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae efficitur nibh. Donec aliquet odio in ipsum mollis, nec eleifend nisi lacinia.</h2>

      <p>H3</p>

      <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae efficitur nibh. Donec aliquet odio in ipsum mollis, nec eleifend nisi lacinia.</h3>

      <p><em>In a list with anchor</em></p>

      <ul>
        <li><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae efficitur nibh. Donec aliquet odio in ipsum mollis, nec eleifend nisi lacinia.</a></li>
      </ul>

      <h3>--- Nested lists ---</h3>

      <ul>
      <li>List 1</li>
        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed luctus sapien lectus, nec sagittis quam hendrerit ut. Donec vitae sapien velit. Etiam tempus tempor sem, tincidunt aliquam arcu condimentum vel. Curabitur a ante id lorem imperdiet finibus non quis neque. Etiam dapibus fringilla gravida.</li>
        <ul>
          <li>List 2</li>
          <li>Vivamus elementum feugiat massa quis vestibulum. Ut enim augue, aliquet vitae tempus nec, efficitur ut massa. Sed vestibulum cursus lacus, sed tincidunt justo rutrum id.</li>
          <ul>
            <li>List 3</li>
            <li>Ut pulvinar lobortis libero sit amet tristique. Aliquam eu magna at nibh euismod accumsan sed vitae massa. Curabitur non nulla est. Morbi a elementum massa. Ut volutpat odio arcu, elementum finibus metus faucibus non. Donec ut nibh eget orci gravida ultrices at ac justo. Aliquam in mi eu leo viverra tempor id a elit. Integer auctor, urna eu placerat sodales, orci nunc ullamcorper risus, et accumsan turpis ipsum ut elit. Pellentesque sagittis malesuada nibh non rhoncus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</li>
            <ul>
              <li>List 4</li>
              <li>Quisque id feugiat felis. Nulla scelerisque nulla quis odio maximus aliquet. Donec non nisi molestie, dignissim neque ut, malesuada eros. Proin mattis enim vitae turpis vulputate, et venenatis mauris pellentesque. Fusce tincidunt justo at mattis finibus. Morbi non consectetur tellus. Fusce at orci in odio venenatis pharetra. Phasellus ornare posuere mauris et imperdiet.</li>
            </ul>
            <li>List 3</li>
            <li>Morbi ac metus quis felis porta laoreet. Nullam posuere nibh et orci eleifend, nec fringilla odio pretium. Aenean varius faucibus felis vel feugiat. Quisque nulla mi, porta et urna eget, aliquet accumsan risus.</li>
          </ul>
          <li>List 2</li>
          <li>Nam dui nunc, bibendum sit amet magna non, imperdiet rhoncus tortor. Duis pretium diam interdum risus vestibulum pharetra. Ut placerat nibh eu tellus dignissim, vitae placerat urna varius. Curabitur id odio eget est molestie hendrerit.</li>
        </ul>
        <li>List 1</li>
        <li>Fusce aliquam sed metus non dignissim. Aliquam laoreet nunc sit amet consequat vulputate.</li>
      </ul>

      <h3>--- Mixed lists ---</h3>

      <ol>
        <li>Ordered list</li>
        <li>Ordered list</li>
        <ul>
          <li>Unordered list</li>
          <li>Unordered list</li>
          <ol>
          <li>Ordered list</li>
          <li>Ordered list</li>
          </ol>
        </ul>
      </ol>

      <ul>
        <li>Unordered list</li>
        <li>Unordered list</li>
        <ol>
          <li>Ordered list</li>
          <li>Ordered list</li>
          <ul>
            <li>Unordered list</li>
            <li>Unordered list</li>
          </ul>
        </ol>
      </ul>

      <br/>
      <br/>

      <?php
      $content = ob_get_clean();
      // (possibly) override with custom markup from theme/plugin
      $content = apply_filters('aucor_core_custom_markup', $content);
    }
    return $content;
  }
}
