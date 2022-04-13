<?php

if ( ! defined('ABSPATH') ) {
    die('Direct access not permitted.');
}

//METABOX ADD
function wr_function_add_metabox(){
    add_meta_box('wr-wysiwyg-editor','Citacion','wr_duno_html_code_editor','post');
}
function wr_duno_html_code_editor(){
    global $post;
	$wr_desafiouno_editor = get_post_meta($post->ID, 'wr_desafiouno_editor', true); 
	wp_editor( $wr_desafiouno_editor,  'wr_desafiouno_editor', array() );
}
function wr_save_custom_wp_editor_content(){
    global $post;
    if(isset($_POST['wr_desafiouno_editor'])){
        update_post_meta($post->ID, 'wr_desafiouno_editor', $_POST['wr_desafiouno_editor']);
    }
}


//METABOX MENU CHECK PAGE BACKEND
function check_links_add_admin() {
    add_menu_page('Check links pages','Check links','read','check-links-errors-wr','check_link_func_template','dashicons-admin-links');
}
function check_link_func_template(){
    require_once WR_DESAFIO_UD_PATH . '/includes/templates/check-links.php'; //--> make sure you read up on paths and require to find your file.
}

//CUSTOM FUNCTIONS
function get_all_link_of_page($content) {
    $htmlString = $content;
    $htmlDom = new DOMDocument;
    @$htmlDom->loadHTML($htmlString);
    $anchorTags = $htmlDom->getElementsByTagName('a');
    $extractedAnchors = array();

    foreach($anchorTags as $anchorTag){
        $aHref = $anchorTag->getAttribute('href');
        $extractedAnchors[] = array(
            'href' => $aHref,
        );
    }
    return $extractedAnchors;
}

function review404($url) {
    $res = true;
    $handle = curl_init($url);
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($handle);
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    curl_close($handle);
    if($httpCode == 404) {
        $res = false;
    }
    return $res;
}