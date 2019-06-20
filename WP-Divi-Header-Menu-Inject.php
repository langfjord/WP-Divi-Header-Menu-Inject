<?php
/**
* Plugin Name: WP Divi Header Menu Inject
* Description: This plugin contains all of the custom functions.
* Author: Langfjord
* Version: 0.1
*/

/* PLUGIN CODE START */

function mp_custom_header_above( $main_header ) {
	$custom_header = '<header id="custom-header-above">';
        $custom_header .= do_shortcode('[et_pb_section global_module="3066"][/et_pb_section]');
    $custom_header .= '</header> <!-- #custom-header-above -->';
	return $custom_header . $main_header;
}
add_filter( 'et_html_main_header', 'mp_custom_header_above' );

/* PLUGIN CODE END */



/*

https://www.elegantthemes.com/documentation/developers/hooks/divi-template-hooks/

*/



?>
