<?php
add_action('wp_ajax_nopriv_wpbannermanhits', 'ajax_wpbannermanhits_handler');
add_action( 'wp_ajax_wpbannermanhits', 'ajax_wpbannermanhits_handler' );
function ajax_wpbannermanhits_handler() {    
    
    $idpost = isset($_POST['idpost'])?$_POST['idpost']:'';
    $url    = isset($_POST['url'])?$_POST['url']:'';

    //counter view
    $hits = New Wpbannerman_hits;
    $hits->addHits($idpost,$url);

    // Stop execution afterward.
    wp_die();
}