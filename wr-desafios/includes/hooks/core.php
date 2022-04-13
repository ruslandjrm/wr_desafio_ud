<?php

if ( ! defined('ABSPATH') ) {
    die('Direct access not permitted.');
}

//Metabox Citacion
add_action('add_meta_boxes', 'wr_function_add_metabox');
add_action( 'save_post', 'wr_save_custom_wp_editor_content' );


//Menu a
add_action('admin_menu', 'check_links_add_admin');