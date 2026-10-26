<?php

/*
Plugin Name: Advanced Custom Fields: Price
Plugin URI: https://github.com/speccode/acf-field-price
Description: ACF Price field with number format.
Version: 1.3.0
Author: Maciej Czerpiński
Author URI: http://maciej.czerpinski.com
License: MIT
License URI: http://opensource.org/licenses/MIT
Text Domain: acf-price
*/

if( ! defined( 'ABSPATH' ) ) exit;

class acf_plugin_price
{
    /**
     * Declared explicitly: assigning an undeclared property triggers a
     * "creation of dynamic property" deprecation on PHP 8.2+, which is
     * printed during activation when WP_DEBUG_DISPLAY is on and surfaces
     * as the "unexpected output during activation" warning.
     */
    public $settings;

    public function __construct()
    {
        $this->settings = array(
            'version'   => '1.3.0',
            'url'       => plugin_dir_url( __FILE__ ),
            'path'      => plugin_dir_path( __FILE__ )
        );

        load_plugin_textdomain( 'acf-price', false, plugin_basename( dirname( __FILE__ ) ) . '/lang' );

        add_action('acf/include_field_types',   array($this, 'include_field_types')); // v5
        add_action('acf/register_fields',       array($this, 'include_field_types')); // v4
    }

    function include_field_types( $version = false )
    {
        if( ! $version ) {
            $version = 4;
        }

        require( dirname( __FILE__ )  . '/fields/acf-price-common.php');
        require( dirname( __FILE__ )  . '/fields/acf-price-v' . $version . '.php');

        new acf_price( $this->settings );
    }
}

new acf_plugin_price;