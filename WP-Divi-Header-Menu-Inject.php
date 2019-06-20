<?php
/**
* Plugin Name: WP Divi Header Menu Inject
* Description: This plugin contains all of the custom functions.
* Author: Langfjord
* Version: 0.3
*/

/* SETTINGS START */

class MySettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'WDHMI Settings', 
            'manage_options', 
            'my-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <h1>WDHMI Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );
                do_settings_sections( 'my-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'my_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'My Custom Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

        add_settings_field(
            'id_number', // ID
            'ID Number', // Title 
            array( $this, 'id_number_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'title', 
            'Title', 
            array( $this, 'title_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = absint( $input['id_number'] );

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your Layout ID and a describing title below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        printf(
            '<input type="text" id="id_number" name="my_option_name[id_number]" value="%s" />',
            isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="my_option_name[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }
}

if( is_admin() )
    $my_settings_page = new MySettingsPage();


/* SETTINGS END */



/* PLUGIN CODE START */

/* GET LAYOUT ID */
$wdhmioptions = get_option('my_option_name');
$wdhmi_id_number = $wdhmioptions['id_number'];
// ID VALUE IN $wdhmioptions['id_number'];

/* Top bar replacement NOT WORKING */
//add_filter( 'et_html_top_header', 'top_header_layout' );
//function top_header_layout() {
// return do_shortcode('[et_pb_section global_module=3066][/et_pb_section]');
//}

/* Below menu injection */
if(is_numeric($wdhmi_id_number)){
 add_action( 'et_before_main_content', 'before_content_layout' );
 function before_content_layout() use($wdhmi_id_number) {
  $wdhmshortcode='[et_pb_section global_module="'.$wdhmi_id_number.'"][/et_pb_section]';
  echo do_shortcode("[et_pb_section global_module=3066$wdhmi_id_number][/et_pb_section]");
 }
}

/* PLUGIN CODE END */



/*

https://www.elegantthemes.com/documentation/developers/hooks/divi-template-hooks/
https://pavenum.com/en/divi-header-include-builder-layouts-using-wordpress-hooks/
https://www.elegantthemes.com/blog/tips-tricks/17-wordpress-functions-php-file-hacks
*/



?>
