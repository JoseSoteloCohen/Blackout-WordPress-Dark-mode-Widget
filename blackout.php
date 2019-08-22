<?php

/*
Plugin Name: Blackout: Dark Mode Widget
Description: Adds a toggle widget to your website that activates dark mode on click.
Version: 1.3.0
Author: José Sotelo
Author URI: https://inboundlatino.com
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
class BlackoutSettings
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $blackout_options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'blackout_settings_page' ) );
        add_action( 'admin_init', array( $this, 'blackout_page_init' ) );
    }
    /**
     * Add options page
     */
    public function blackout_settings_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Blackout Admin',
            'Blackout',
            'manage_options',
            'blackout_settings_admin_page',
            array( $this, 'blackout_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function blackout_admin_page()
    {
        // Set class property
        $this->options = get_option( 'blackout_options' );
        ?>
        <div class="wrap">
            <h2>Blackout Settings</h2>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'blackout_main_options_group' );
                do_settings_sections( 'blackout_settings_admin_page' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
    /**
     * Register and add settings
     */
    public function blackout_page_init()
    {
        register_setting(
            'blackout_main_options_group', // Option group
            'blackout_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'blackout_main_section', // ID
            'Custom Position', // Title
            array( $this, 'blackout_print_main_section_info' ), // Callback
            'blackout_settings_admin_page' // Page
        );
        add_settings_section(
            'blackout_positions_section', // ID
            'Pre-Defined Positions', // Title
            array( $this, 'blackout_print_positions_section_info' ), // Callback
            'blackout_settings_admin_page' // Page
        );
        add_settings_section(
            'blackout_widget_section', // ID
            'Widget Settings', // Title
            array( $this, 'blackout_print_main_section_info' ), // Callback
            'blackout_settings_admin_page' // Page
        );
        add_settings_section(
            'blackout_extras_section', // ID
            'Extra Settings', // Title
            array( $this, 'blackout_print_extra_settings' ), // Callback
            'blackout_settings_admin_page' // Page
        );
        add_settings_field(
            'blackout_only_posts',
            'Show in posts only',
            array( $this, 'blackout_only_posts_callback' ),
            'blackout_settings_admin_page',
            'blackout_main_section'
        );
        add_settings_field(
            'blackout_bottom', // ID
            'Bottom', // Title
            array( $this, 'blackout_bottom_callback' ), // Callback
            'blackout_settings_admin_page', // Page
            'blackout_main_section' // Section
        );

        add_settings_field(
            'blackout_right',
            'Right',
            array( $this, 'blackout_right_callback' ),
            'blackout_settings_admin_page',
            'blackout_main_section'
        );

        add_settings_field(
            'blackout_left',
            'Left',
            array( $this, 'blackout_left_callback' ),
            'blackout_settings_admin_page',
            'blackout_main_section'
        );

        add_settings_field(
            'blackout_time',
            'Time',
            array( $this, 'blackout_time_callback' ),
            'blackout_settings_admin_page',
            'blackout_main_section'
        );

        add_settings_field(
            'blackout_button_dark',
            'Button Dark',
            array( $this, 'blackout_button_dark_callback' ),
            'blackout_settings_admin_page',
            'blackout_widget_section'
        );
        add_settings_field(
            'blackout_button_light',
            'Button Light',
            array( $this, 'blackout_button_light_callback' ),
            'blackout_settings_admin_page',
            'blackout_widget_section'
        );
        add_settings_field(
            'blackout_button_size',
            'Button Size',
            array( $this, 'blackout_button_size_callback' ),
            'blackout_settings_admin_page',
            'blackout_widget_section'
        );
        add_settings_field(
            'blackout_icon_size',
            'Icon Size',
            array( $this, 'blackout_icon_size_callback' ),
            'blackout_settings_admin_page',
            'blackout_widget_section'
        );
        add_settings_field(
            'blackout_left_bottom',
            'Bottom Left',
            array( $this, 'blackout_left_bottom_callback' ),
            'blackout_settings_admin_page',
            'blackout_positions_section'
        );
        add_settings_field(
            'blackout_right_bottom',
            'Bottom Right',
            array( $this, 'blackout_right_bottom_callback' ),
            'blackout_settings_admin_page',
            'blackout_positions_section'
        );
        add_settings_field(
            'blackout_cookies',
            'Want to create a cookie?',
            array( $this, 'blackout_cookies_callback' ),
            'blackout_settings_admin_page',
            'blackout_extras_section'
        );
        add_settings_field(
            'blackout_match_os',
            'Want to match the OS mode?',
            array( $this, 'blackout_match_os_callback' ),
            'blackout_settings_admin_page',
            'blackout_extras_section'
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
        if( isset( $input['blackout_time'] ) )
            $new_input['blackout_time'] = sanitize_text_field( $input['blackout_time'] );

        if( isset( $input['blackout_right'] ) )
            $new_input['blackout_right'] = sanitize_text_field( $input['blackout_right'] );

        if( isset( $input['blackout_bottom'] ) )
            $new_input['blackout_bottom'] = sanitize_text_field( $input['blackout_bottom'] );

        if( isset( $input['blackout_left'] ) )
            $new_input['blackout_left'] = sanitize_text_field( $input['blackout_left'] );

        if( isset( $input['blackout_button_dark'] ) )
            $new_input['blackout_button_dark'] = sanitize_text_field( $input['blackout_button_dark'] );

        if( isset( $input['blackout_button_light'] ) )
            $new_input['blackout_button_light'] = sanitize_text_field( $input['blackout_button_light'] );

        if( isset( $input['blackout_icon_size'] ) )
            $new_input['blackout_icon_size'] = sanitize_text_field( $input['blackout_icon_size'] );

        if( isset( $input['blackout_button_size'] ) )
            $new_input['blackout_button_size'] = sanitize_text_field( $input['blackout_button_size'] );

        if( isset( $input['blackout_only_posts'] ) )
            $new_input['blackout_only_posts'] = absint( $input['blackout_only_posts'] );

        if( isset( $input['blackout_left_bottom'] ) )
            $new_input['blackout_left_bottom'] = absint( $input['blackout_left_bottom'] );

        if( isset( $input['blackout_right_bottom'] ) )
            $new_input['blackout_right_bottom'] = absint( $input['blackout_right_bottom'] );

        if( isset( $input['blackout_match_os'] ) )
            $new_input['blackout_match_os'] = absint( $input['blackout_match_os'] );
        if( isset( $input['blackout_cookies'] ) )
            $new_input['blackout_cookies'] = absint( $input['blackout_cookies'] );

        return $new_input;
    }
    /**
     * Print the Section text
     */
    public function blackout_print_main_section_info()
    {
        print 'Enter your settings below:';
    }
    public function blackout_print_positions_section_info()
    {
        print 'Choose the position that you prefer:';
    }
    public function blackout_print_extra_settings()
    {
        echo '<p>The cookies will allow the plugin to keep the dark mode active if the user enabled it previously.
              </br>The match OS will allow the plugin to activate dark mode if the OS or browser are in Dark Mode</p>';
    }
    /**
     * Get the settings option array and print one of its values
     */
    public function blackout_bottom_callback()
    {
        printf(
            '<input type="text" id="blackout_bottom" placeholder="32px" name="blackout_options[blackout_bottom]" value="%s" />',
            isset( $this->options['blackout_bottom'] ) ? esc_attr( $this->options['blackout_bottom']) : ''
        );
    }

    public function blackout_right_callback()
    {
        printf(
            '<input type="text" id="blackout_right" name="blackout_options[blackout_right]" placeholder="32px" value="%s" />',
            isset( $this->options['blackout_right'] ) ? esc_attr( $this->options['blackout_right']) : ''
        );
    }
    public function blackout_left_callback()
    {
        printf(
            '<input type="text" id="blackout_left" placeholder="32px" name="blackout_options[blackout_left]" value="%s" />',
            isset( $this->options['blackout_left'] ) ? esc_attr( $this->options['blackout_left']) : ''
        );
    }
    public function blackout_time_callback()
    {
        printf(
            '<input type="text" id="blackout_time" placeholder="0.3s" name="blackout_options[blackout_time]" value="%s" />',
            isset( $this->options['blackout_time'] ) ? esc_attr( $this->options['blackout_time']) : ''
        );
    }
    public function blackout_button_dark_callback()
    {
        printf(
            '<input type="color" id="blackout_button_dark" name="blackout_options[blackout_button_dark]" value="%s" />',
            isset( $this->options['blackout_button_dark'] ) ? esc_attr( $this->options['blackout_button_dark']) : ''
        );
    }
    public function blackout_button_light_callback()
    {
        printf(
            '<input type="color" id="blackout_button_light" name="blackout_options[blackout_button_light]" value="%s" />',
            isset( $this->options['blackout_button_light'] ) ? esc_attr( $this->options['blackout_button_light']) : ''
        );
    }
    public function blackout_button_size_callback()
    {
        printf(
            '<input type="range" min="1" max="5" step="1" id="blackout_button_size" name="blackout_options[blackout_button_size]" value="%s" />',
            isset( $this->options['blackout_button_size'] ) ? esc_attr( $this->options['blackout_button_size']) : ''
        );
    }
    public function blackout_icon_size_callback()
    {
        printf(
            '<input type="range" min="1.5" max="5.5" step="1" id="blackout_icon_size" name="blackout_options[blackout_icon_size]" value="%s" />',
            isset( $this->options['blackout_icon_size'] ) ? esc_attr( $this->options['blackout_icon_size']) : ''
        );
    }
    public function blackout_only_posts_callback()
    {
        printf(
            '<input type="checkbox" id="blackout_only_posts" name="blackout_options[blackout_only_posts]" value="1"' . checked( 1, $this->options['blackout_only_posts'], false ) . ' />',
            isset( $this->options['blackout_only_posts'] ) ? esc_attr( $this->options['blackout_only_posts']) : ''
        );
    }
    public function blackout_left_bottom_callback()
    {
        printf(
            '<input type="checkbox" id="blackout_left_bottom" name="blackout_options[blackout_left_bottom]" value="1"' . checked( 1, $this->options['blackout_left_bottom'], false ) . ' />',
            isset( $this->options['blackout_left_bottom'] ) ? esc_attr( $this->options['blackout_left_bottom']) : ''
        );
    }
    public function blackout_right_bottom_callback()
    {
        printf(
            '<input type="checkbox" id="blackout_right_bottom" name="blackout_options[blackout_right_bottom]" value="1"' . checked( 1, $this->options['blackout_right_bottom'], false ) . ' />',
            isset( $this->options['blackout_right_bottom'] ) ? esc_attr( $this->options['blackout_right_bottom']) : ''
        );
    }
    public function blackout_match_os_callback()
    {
        printf(
            '<input type="checkbox" id="blackout_match_os" name="blackout_options[blackout_match_os]" value="1"' . checked( 1, $this->options['blackout_match_os'], false ) . ' />',
            isset( $this->options['blackout_match_os'] ) ? esc_attr( $this->options['blackout_match_os']) : ''
        );
    }
    public function blackout_cookies_callback()
    {
        printf(
            '<input type="checkbox" id="blackout_cookies" name="blackout_options[blackout_cookies]" value="1"' . checked( 1, $this->options['blackout_cookies'], false ) . ' />',
            isset( $this->options['blackout_cookies'] ) ? esc_attr( $this->options['blackout_cookies']) : ''
        );
    }
}
function blackout_enqueues(){
    $blackout_options = get_option('blackout_options');
    wp_enqueue_script('blackout_script', plugin_dir_url( __FILE__ ) . 'js/blackout.js', array(), '1.0', 'true');
    wp_enqueue_style('blackout_style', plugin_dir_url( __FILE__ ) . 'css/blackout.css');
    $blackout_custom_css = ".darkmode-toggle>img{
            width: {$blackout_options['blackout_icon_size']}rem !important;
            height:{$blackout_options['blackout_icon_size']}rem !important;
        }
        .darkmode-toggle {
            width:{$blackout_options['blackout_button_size']}rem !important;
            height:{$blackout_options['blackout_button_size']}rem !important;
        }
        ";
    wp_add_inline_style('blackout_style', $blackout_custom_css);
}
function blackout_position(){
    $blackout_options = get_option('blackout_options');
    $blackout_cookies = "false";
    $blackout_match_os = "false";
    if ($blackout_options['blackout_cookies'] == 1){
        $blackout_cookies = "true";
    }else{
        $blackout_cookies = "false";
    }
    if ($blackout_options['blackout_match_os'] == 1){
        $blackout_match_os= "true";
    }else{
        $blackout_match_os = "false";
    }
    if ($blackout_options['blackout_left_bottom'] == '1'){
        $blackout_custom_js = "
        var options = {
            bottom: '{$blackout_options['blackout_bottom']}', // default: '32px'
            right: 'unset',
            left: '32px', // default: '32px'
            time: '{$blackout_options['blackout_time']}', // default: '0.3s'
            buttonColorDark: '{$blackout_options['blackout_button_dark']}',  // default: '#100f2c'
            buttonColorLight: '{$blackout_options['blackout_button_light']}', // default: '#fff'
            saveInCookies: '{$blackout_cookies}', // default: true
            autoMatchOsTheme: '{$blackout_match_os}', // default: true
            label: '🌓' // default: ''
        }
        const darkmode = new Darkmode(options);
        darkmode.showWidget();";
    }elseif ($blackout_options['blackout_right_bottom'] == '1'){
        $blackout_custom_js = "
        var options = {
            bottom: '{$blackout_options['blackout_bottom']}', // default: '32px'
            right: '{$blackout_options['blackout_right']}', // default: '32px'
            left: 'unset', // default: 'unset'
            time: '{$blackout_options['blackout_time']}', // default: '0.3s'
            buttonColorDark: '{$blackout_options['blackout_button_dark']}',  // default: '#100f2c'
            buttonColorLight: '{$blackout_options['blackout_button_light']}', // default: '#fff'
            saveInCookies: '{$blackout_cookies}', // default: true
            autoMatchOsTheme: '{$blackout_match_os}', // default: true
            label: '🌓' // default: ''
        }
        const darkmode = new Darkmode(options);
        darkmode.showWidget();";
    }else{
        $blackout_custom_js = "
        var options = {
            bottom: '{$blackout_options['blackout_bottom']}', // default: '32px'
            right: '{$blackout_options['blackout_right']}', // default: '32px'
            left: '{$blackout_options['blackout_left']}', // default: 'unset'
            time: '{$blackout_options['blackout_time']}', // default: '0.3s'
            buttonColorDark: '{$blackout_options['blackout_button_dark']}',  // default: '#100f2c'
            buttonColorLight: '{$blackout_options['blackout_button_light']}', // default: '#fff'
            saveInCookies: '{$blackout_cookies}', // default: true
            autoMatchOsTheme: '{$blackout_match_os}', // default: true
            label: '🌓' // default: ''
        }
        const darkmode = new Darkmode(options);
        darkmode.showWidget();";
    }


    wp_add_inline_script('blackout_script', $blackout_custom_js);
}
function blackout_init(){
    $blackout_options = get_option('blackout_options');
    if($blackout_options['blackout_only_posts'] == '1'){
        if(is_single()){
            add_action( 'wp_enqueue_scripts', 'blackout_enqueues' );
            add_action( 'wp_enqueue_scripts', 'blackout_position' );
        }
    }else{
        add_action( 'wp_enqueue_scripts', 'blackout_enqueues' );
        add_action( 'wp_enqueue_scripts', 'blackout_position' );
    }
}
$blackout_options = get_option('blackout_options');
if( is_admin() ) {
    $blackout_settings = new BlackoutSettings();
}else{
    add_action('wp', 'blackout_init');
}
