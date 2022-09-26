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

add_action('wp_ajax_nopriv_wpbannermanclick', 'ajax_wpbannermanclick_handler');
add_action( 'wp_ajax_wpbannermanclick', 'ajax_wpbannermanclick_handler' );
function ajax_wpbannermanclick_handler() {    
    
    $idpost = isset($_POST['idpost'])?$_POST['idpost']:'';
    $url    = isset($_POST['url'])?$_POST['url']:'';

    //counter
    $click = New Wpbannerman_click;
    $click->addClick($idpost,$url);

    echo $click->view($idpost);

    // Stop execution afterward.
    wp_die();
}