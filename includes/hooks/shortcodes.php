<?php 
if ( ! defined('ABSPATH') ) {
    die('Direct access not permitted.');
}

/*Show Qoutes.*/
function mc_citacion_func( $atts )  {
    $output = '';

    if(!isset($atts['post_id'])) 
        return $output;
    if ( get_post_status ( $atts['post_id'] ) ) {
        $output = get_post_meta( $atts['post_id'], 'wr_desafiouno_editor', true );
    }
    return $output;
}
add_shortcode( 'mc-citacion', 'mc_citacion_func' );