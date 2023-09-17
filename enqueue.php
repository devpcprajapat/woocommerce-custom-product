<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Enqueue JavaScript for the custom image upload button
function custom_enqueue_upload_script() {
    wp_enqueue_script('custom-upload', plugin_dir_url(__FILE__) . 'js/custom-upload.js', array('jquery'), '', true);
    wp_enqueue_style( 'custom-style', plugin_dir_url(__FILE__) . 'css/custom-style.css', array(), '1.0.0', 'all' );
}
add_action('wp_enqueue_scripts', 'custom_enqueue_upload_script');
