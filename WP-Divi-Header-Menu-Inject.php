<?php
/**
* Plugin Name: WP Divi Header Menu Inject
* Description: This plugin contains all of the custom functions.
* Author: Langfjord
* Version: 0.2
*/

/* PLUGIN CODE START */

/* Top bar replacement NOT WORKING */
add_filter( 'et_html_top_header', 'top_header_layout' );
function top_header_layout() {
 return do_shortcode('[et_pb_section global_module=3066][/et_pb_section]');
}

/* Below menu injection */
add_action( 'et_before_main_content', 'before_content_layout' );
function before_content_layout() {
 echo do_shortcode('[et_pb_section global_module=3066][/et_pb_section]');
}

/* PLUGIN CODE END */



/*

https://www.elegantthemes.com/documentation/developers/hooks/divi-template-hooks/
https://pavenum.com/en/divi-header-include-builder-layouts-using-wordpress-hooks/

*/



?>
