<?php
/**
 * Plugin Name: OpenAI Modules for Beaver Builder
 * Description: A plugin that adds extra modules to Beaver Builder.
 * Version: 1.0
 * Author: Modified by MD Arif Islam
 */

// Define the plugin path and URL.
define( 'botterfly_custom_bb_modules_PATH', plugin_dir_path( __FILE__ ) );
define( 'botterfly_custom_bb_modules_URL', plugin_dir_url( __FILE__ ) );

// Load the hello world module.
function oa_load_modules() {
    if ( class_exists( 'FLBuilder' ) ) {
        require_once botterfly_custom_bb_modules_PATH . 'modules/test-module/test-module.php';
    }
}

add_action( 'init', 'oa_load_modules' );

?>
