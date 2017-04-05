<?php
/**
 * Theme functions for YOLO Framework.
 * This file include the framework functions, it should remain intact between themes.
 * For theme specified functions, see file functions-<theme name>.php
 *
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
// Load the Options Panel
require_once get_template_directory() . '/framework/yolo-framework.php';

function _remove_script_version( $src ){
  $parts = explode( '?ver', $src );
        return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

// Minify HTML @see: https://gist.github.com/setuix/8e0d9808a11b082c0d4b
class WP_HTML_Compression {
  // Settings
  protected $compress_css = true;
  protected $compress_js = false;
  protected $info_comment = true;
  protected $remove_comments = true;

  // Variables
  protected $html;
  public function __construct($html) {
    if (!empty($html)) {
      $this->parseHTML($html);
    }
  }
  public function __toString() {
    return $this->html;
  }
  protected function bottomComment($raw, $compressed) {
    $raw = strlen($raw);
    $compressed = strlen($compressed);
     
    $savings = ($raw-$compressed) / $raw * 100;
     
    $savings = round($savings, 2);
     
    return '<!--HTML compressed, size saved '.$savings.'%. From '.$raw.' bytes, now '.$compressed.' bytes-->';
  }
  protected function minifyHTML($html) {
    $pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
    preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
    $overriding = false;
    $raw_tag = false;
    // Variable reused for output
    $html = '';
    foreach ($matches as $token) {
      $tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;
     
      $content = $token[0];
     
      if (is_null($tag)) {
        if ( !empty($token['script']) ) {
          $strip = $this->compress_js;
        }
        else if ( !empty($token['style']) ) {
          $strip = $this->compress_css;
        }
        else if ($content == '<!--wp-html-compression no compression-->') {
          $overriding = !$overriding;
           
          // Don't print the comment
          continue;
        }
        else if ($this->remove_comments) {
          if (!$overriding && $raw_tag != 'textarea') {
            // Remove any HTML comments, except MSIE conditional comments
            $content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
          }
        }
      }
      else {
        if ($tag == 'pre' || $tag == 'textarea') {
          $raw_tag = $tag;
        }
        else if ($tag == '/pre' || $tag == '/textarea') {
          $raw_tag = false;
        } 
        else{
          if ($raw_tag || $overriding) {
            $strip = false;
          }
          else {
            $strip = true;
           
            // Remove any empty attributes, except:
            // action, alt, content, src
            $content = preg_replace('/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content);
           
            // Remove any space before the end of self-closing XHTML tags
            // JavaScript excluded
            $content = str_replace(' />', '/>', $content);
          }
        }
      }
     
      if ($strip) {
        $content = $this->removeWhiteSpace($content);
      }
     
      $html .= $content;
    }
    return $html;
  }
   
  public function parseHTML($html) {
    $this->html = $this->minifyHTML($html);
   
    if ($this->info_comment) {
      $this->html .= "\n" . $this->bottomComment($html, $this->html);
    }
  }
  
  protected function removeWhiteSpace($str) {
    $str = str_replace("\t", ' ', $str);
    $str = str_replace("\n",  '', $str);
    $str = str_replace("\r",  '', $str);
   
    while (stristr($str, '  ')) {
      $str = str_replace('  ', ' ', $str);
    }
   
    return $str;
  }
}

function wp_html_compression_finish($html) {
  return new WP_HTML_Compression($html);
}
if (!function_exists('wp_html_compression_start')) {
  $html_minifier = yolo_get_options();
  function wp_html_compression_start() {
    ob_start('wp_html_compression_finish');
  }
  if(isset($html_minifier['enable_minifile_html']) && $html_minifier['enable_minifile_html'] == 1)
  add_action('get_header', 'wp_html_compression_start');
}

/*
 *	Add relevant WooCommerce widget-id's to "sidebars_widgets" option so the custom product filters will work
 *
 * 	Note: WooCommerce use "is_active_widget()" to check for active widgets in: "../includes/class-wc-query.php"
 */
function yolo_add_woocommerce_widget_ids( $sidebars_widgets, $old_sidebars_widgets = array() ) {
	$shop_sidebar_id = 'woocommerce_filter';
	$shop_widgets = $sidebars_widgets[$shop_sidebar_id];

	if ( is_array( $shop_widgets ) ) {
		foreach ( $shop_widgets as $widget ) {
			$widget_id = _get_widget_id_base( $widget );

			if ( $widget_id === 'yolo_woocommerce_price_filter' ) {
				$sidebars_widgets[$shop_sidebar_id][] = 'woocommerce_price_filter-12345';
			} else if ( $widget_id === 'yolo_woocommerce_color_filter' ) {
				$sidebars_widgets[$shop_sidebar_id][] = 'woocommerce_layered_nav-12345';
			}
		}
	}

	return $sidebars_widgets;
}
add_action( 'pre_update_option_sidebars_widgets', 'yolo_add_woocommerce_widget_ids' );
