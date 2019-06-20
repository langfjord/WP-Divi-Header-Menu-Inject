<?php
/**
* Plugin Name: WP Divi Header Menu Inject
* Description: This plugin contains all of the custom functions.
* Author: Langfjord
* Version: 0.2
*/

/* SETTINGS START */

// add a new option
add_option('langfjord_moduleid', '3066');
// get an option
$option = get_option('langfjord_moduleid');

/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */
 
/**
 * custom option and settings
 */
function wdhmi_settings_init() {
 // register a new setting for "wdhmi" page
 register_setting( 'wdhmi', 'wdhmi_options' );
 
 // register a new section in the "wdhmi" page
 add_settings_section(
 'wdhmi_section_developers',
 __( 'The Matrix has you.', 'wdhmi' ),
 'wdhmi_section_developers_cb',
 'wdhmi'
 );
 
 // register a new field in the "wdhmi_section_developers" section, inside the "wdhmi" page
 add_settings_field(
 'wdhmi_field_pill', // as of WP 4.6 this value is used only internally
 // use $args' label_for to populate the id inside the callback
 __( 'Pill', 'wdhmi' ),
 'wdhmi_field_pill_cb',
 'wdhmi',
 'wdhmi_section_developers',
 [
 'label_for' => 'wdhmi_field_pill',
 'class' => 'wdhmi_row',
 'wdhmi_custom_data' => 'custom',
 ]
 );
}
 
/**
 * register our wdhmi_settings_init to the admin_init action hook
 */
add_action( 'admin_init', 'wdhmi_settings_init' );
 
/**
 * custom option and settings:
 * callback functions
 */
 
// developers section cb
 
// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function wdhmi_section_developers_cb( $args ) {
 ?>
 <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Find your Divi Layout ID and post it here.', 'wdhmi' ); ?></p>
 <?php
}
 
// pill field cb
 
// field callbacks can accept an $args parameter, which is an array.
// $args is defined at the add_settings_field() function.
// wordpress has magic interaction with the following keys: label_for, class.
// the "label_for" key value is used for the "for" attribute of the <label>.
// the "class" key value is used for the "class" attribute of the <tr> containing the field.
// you can add custom key value pairs to be used inside your callbacks.
function wdhmi_field_pill_cb( $args ) {
 // get the value of the setting we've registered with register_setting()
 $options = get_option( 'wdhmi_options' );
 // output the field
 ?>
 <input type="text" name="new_option_name" value="<?php echo esc_attr( get_option('wdhmi_custom_data') ); ?>
 
 <p class="description">
 <?php esc_html_e( 'Please check the url for correct ID number when you edit the Divi Layout', 'wdhmi' ); ?>
 </p>

 <?php
}
 
/**
 * top level menu
 */
function wdhmi_options_page() {
 // add top level menu page
 add_menu_page(
 'WDHMI',
 'WDHMI Options',
 'manage_options',
 'wdhmi',
 'wdhmi_options_page_html'
 );
}
 
/**
 * register our wporg_options_page to the admin_menu action hook
 */
add_action( 'admin_menu', 'wporg_options_page' );
 
/**
 * top level menu:
 * callback functions
 */
function wporg_options_page_html() {
 // check user capabilities
 if ( ! current_user_can( 'manage_options' ) ) {
 return;
 }
 
 // add error/update messages
 
 // check if the user have submitted the settings
 // wordpress will add the "settings-updated" $_GET parameter to the url
 if ( isset( $_GET['settings-updated'] ) ) {
 // add settings saved message with the class of "updated"
 add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'wporg' ), 'updated' );
 }
 
 // show error/update messages
 settings_errors( 'wporg_messages' );
 ?>
 <div class="wrap">
 <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
 <form action="options.php" method="post">
 <?php
 // output security fields for the registered setting "wporg"
 settings_fields( 'wporg' );
 // output setting sections and their fields
 // (sections are registered for "wporg", each field is registered to a specific section)
 do_settings_sections( 'wporg' );
 // output save settings button
 submit_button( 'Save Settings' );
 ?>
 </form>
 </div>
 <?php
}

/* SETTINGS END */



/* PLUGIN CODE START */

/* Top bar replacement NOT WORKING */
//add_filter( 'et_html_top_header', 'top_header_layout' );
//function top_header_layout() {
// return do_shortcode('[et_pb_section global_module=3066][/et_pb_section]');
//}

/* Below menu injection */
add_action( 'et_before_main_content', 'before_content_layout' );
function before_content_layout() {
 echo do_shortcode('[et_pb_section global_module=3066][/et_pb_section]');
}

/* PLUGIN CODE END */



/*

https://www.elegantthemes.com/documentation/developers/hooks/divi-template-hooks/
https://pavenum.com/en/divi-header-include-builder-layouts-using-wordpress-hooks/
https://www.elegantthemes.com/blog/tips-tricks/17-wordpress-functions-php-file-hacks
*/



?>
