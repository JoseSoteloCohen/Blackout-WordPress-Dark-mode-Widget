<?php

/*
Plugin Name: Darky
Description: Adds a toggle widget to your website that activates dark mode on click.
Version: 1.0
Author: José Sotelo
Author URI: https://inboundlatino.com
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
class DarkySettings
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $darky_options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'darky_settings_page' ) );
        add_action( 'admin_init', array( $this, 'darky_page_init' ) );
    }

    /**
     * Add options page
     */
    public function darky_settings_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Darky Admin',
            'Darky',
            'manage_options',
            'darky_settings_admin_page',
            array( $this, 'darky_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function darky_admin_page()
    {
        // Set class property
        $this->options = get_option( 'darky_options' );
        ?>
        <div class="wrap">
            <h2>Darky Settings</h2>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'darky_main_options_group' );
                do_settings_sections( 'darky_settings_admin_page' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function darky_page_init()
    {
        register_setting(
            'darky_main_options_group', // Option group
            'darky_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'darky_main_section', // ID
            'My Custom Settings', // Title
            array( $this, 'darky_print_main_section_info' ), // Callback
            'darky_settings_admin_page' // Page
        );

        add_settings_field(
            'darky_bottom', // ID
            'Bottom', // Title
            array( $this, 'darky_bottom_callback' ), // Callback
            'darky_settings_admin_page', // Page
            'darky_main_section' // Section
        );

        add_settings_field(
            'darky_right',
            'Right',
            array( $this, 'darky_right_callback' ),
            'darky_settings_admin_page',
            'darky_main_section'
        );

        add_settings_field(
            'darky_left',
            'Left',
            array( $this, 'darky_left_callback' ),
            'darky_settings_admin_page',
            'darky_main_section'
        );

        add_settings_field(
            'darky_time',
            'Time',
            array( $this, 'darky_time_callback' ),
            'darky_settings_admin_page',
            'darky_main_section'
        );

        add_settings_field(
            'darky_button_dark',
            'Button Dark',
            array( $this, 'darky_button_dark_callback' ),
            'darky_settings_admin_page',
            'darky_main_section'
        );
        add_settings_field(
            'darky_button_light',
            'Button Light',
            array( $this, 'darky_button_light_callback' ),
            'darky_settings_admin_page',
            'darky_main_section'
        );
        add_settings_field(
            'darky_button_size',
            'Button Size',
            array( $this, 'darky_button_size_callback' ),
            'darky_settings_admin_page',
            'darky_main_section'
        );
        add_settings_field(
            'darky_icon_size',
            'Icon Size',
            array( $this, 'darky_icon_size_callback' ),
            'darky_settings_admin_page',
            'darky_main_section'
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
        if( isset( $input['darky_time'] ) )
            $new_input['darky_time'] = sanitize_text_field( $input['darky_time'] );

        if( isset( $input['darky_right'] ) )
            $new_input['darky_right'] = sanitize_text_field( $input['darky_right'] );

        if( isset( $input['darky_bottom'] ) )
            $new_input['darky_bottom'] = sanitize_text_field( $input['darky_bottom'] );

        if( isset( $input['darky_left'] ) )
            $new_input['darky_left'] = sanitize_text_field( $input['darky_left'] );

        if( isset( $input['darky_button_dark'] ) )
            $new_input['darky_button_dark'] = sanitize_text_field( $input['darky_button_dark'] );

        if( isset( $input['darky_button_light'] ) )
            $new_input['darky_button_light'] = sanitize_text_field( $input['darky_button_light'] );

        if( isset( $input['darky_icon_size'] ) )
            $new_input['darky_icon_size'] = sanitize_text_field( $input['darky_icon_size'] );

        if( isset( $input['darky_button_size'] ) )
            $new_input['darky_button_size'] = sanitize_text_field( $input['darky_button_size'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function darky_print_main_section_info()
    {
        print 'Enter your settings below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function darky_bottom_callback()
    {
        printf(
            '<input type="text" id="darky_bottom" placeholder="32px" name="darky_options[darky_bottom]" value="%s" />',
            isset( $this->options['darky_bottom'] ) ? esc_attr( $this->options['darky_bottom']) : ''
        );
    }

    public function darky_right_callback()
    {
        printf(
            '<input type="text" id="darky_right" name="darky_options[darky_right]" placeholder="32px" value="%s" />',
            isset( $this->options['darky_right'] ) ? esc_attr( $this->options['darky_right']) : ''
        );
    }


    public function darky_left_callback()
    {
        printf(
            '<input type="text" id="darky_left" placeholder="32px" name="darky_options[darky_left]" value="%s" />',
            isset( $this->options['darky_left'] ) ? esc_attr( $this->options['darky_left']) : ''
        );
    }

    public function darky_time_callback()
    {
        printf(
            '<input type="text" id="darky_time" placeholder="0.3s" name="darky_options[darky_time]" value="%s" />',
            isset( $this->options['darky_time'] ) ? esc_attr( $this->options['darky_time']) : ''
        );
    }

    public function darky_button_dark_callback()
    {
        printf(
            '<input type="color" id="darky_button_dark" name="darky_options[darky_button_dark]" value="%s" />',
            isset( $this->options['darky_button_dark'] ) ? esc_attr( $this->options['darky_button_dark']) : ''
        );
    }

    public function darky_button_light_callback()
    {
        printf(
            '<input type="color" id="darky_button_light" name="darky_options[darky_button_light]" value="%s" />',
            isset( $this->options['darky_button_light'] ) ? esc_attr( $this->options['darky_button_light']) : ''
        );
    }

    public function darky_button_size_callback()
    {
        printf(
            '<input type="range" min="1" max="5" step="1" id="darky_button_size" name="darky_options[darky_button_size]" value="%s" />',
            isset( $this->options['darky_button_size'] ) ? esc_attr( $this->options['darky_button_size']) : ''
        );
    }

    public function darky_icon_size_callback()
    {
        printf(
            '<input type="range" min="1.5" max="5.5" step="1" id="darky_icon_size" name="darky_options[darky_icon_size]" value="%s" />',
            isset( $this->options['darky_icon_size'] ) ? esc_attr( $this->options['darky_icon_size']) : ''
        );
    }
}
function darky_enqueues(){
    wp_enqueue_script('darky_script', plugin_dir_url( __FILE__ ) . 'js/darky.js', array(), '1.0', 'true');
    wp_enqueue_style('darky_style', plugin_dir_url( __FILE__ ) . 'css/darky.css');
    $darky_options = get_option('darky_options');
    $darky_custom_js = "
    var options = {
            bottom: '{$darky_options['darky_bottom']}', // default: '32px'
            right: '{$darky_options['darky_right']}', // default: '32px'
            left: '{$darky_options['darky_left']}', // default: 'unset'
            time: '{$darky_options['darky_time']}', // default: '0.3s'
            buttonColorDark: '{$darky_options['darky_button_dark']}',  // default: '#100f2c'
            buttonColorLight: '{$darky_options['darky_button_light']}', // default: '#fff'
            label: '🌓' // default: ''
        }
        const darkmode = new Darkmode(options);
        darkmode.showWidget();";
    wp_add_inline_script('darky_script', $darky_custom_js);
    $darky_custom_css = ".darkmode-toggle>img{
            width: {$darky_options['darky_icon_size']}rem !important;
            height:{$darky_options['darky_icon_size']}rem !important;
        }
        .darkmode-toggle {
            width:{$darky_options['darky_button_size']}rem !important;
            height:{$darky_options['darky_button_size']}rem !important;
        }";
    wp_add_inline_style('darky_style', $darky_custom_css);
}

if( is_admin() ) {
    $darky_settings = new DarkySettings();
}
    else{
        add_action( 'wp_enqueue_scripts', 'darky_enqueues' );
}
