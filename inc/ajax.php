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

add_action( 'wp_ajax_wpbannermanreset', 'ajax_wpbannermanreset_handler' );
function ajax_wpbannermanreset_handler() {    
    
    $idpost = isset($_POST['idpost'])?$_POST['idpost']:'';

    if(empty($idpost))
    return false;

    //delete
    $hits = New Wpbannerman_hits;
    $hits->deleteDataByPostId($idpost);
    $click = New Wpbannerman_click;
    $click->deleteDataByPostId($idpost);

    // Stop execution afterward.
    wp_die();
}

add_action( 'wp_ajax_wpbannermanchart', 'ajax_wpbannermanchart_handler' );
function ajax_wpbannermanchart_handler() {    
    
    $idpost     = isset($_POST['idpost'])?$_POST['idpost']:'';
    $time       = isset($_POST['time'])?$_POST['time']:'';
    $datefrom   = isset($_POST['datefrom'])?$_POST['datefrom']:'';
    $dateto     = isset($_POST['dateto'])?$_POST['dateto']:'';
    $result     = [];

    // $result['request']   = $_POST;     
    
    //if custom date
    if($time!='custom-date'){
        $dateto     = date( 'Y-m-d', current_time( 'timestamp', 0 ) );
        $datefrom   = date("Y-m-d", strtotime("-".$time." day", strtotime($dateto)));
    }

    //create arrar date
    $period = new DatePeriod(
        new DateTime($datefrom),
        new DateInterval('P1D'),
        new DateTime($dateto)
    );
    $hitsarray  = [];
    $clickarray = [];
    $datalabel  = [];
    foreach ($period as $key => $value) {
        $hitsarray[$value->format('Y-m-d')] = 0;
        $clickarray[$value->format('Y-m-d')] = 0;
        $datalabel[] = $value->format('Y-m-d');       
    }
    $hitsarray[$dateto]   = 0;
    $clickarray[$dateto]  = 0;
    $datalabel[]          = $dateto;

    //get data from table database
    $hits       = new Wpbannerman_hits;
    $datahits   = $hits->get("(date BETWEEN '".$datefrom."' AND '".$dateto."') AND (banner_id = ".$idpost.")");
    $click      = new Wpbannerman_click;
    $dataclick  = $click->get("(date BETWEEN '".$datefrom."' AND '".$dateto."') AND (banner_id = ".$idpost.")");
    
    if($datahits){
        foreach ($datahits as $key => $value) {
            $hitsarray[$value['date']] = $hitsarray[$value['date']]+$value['hit'];      
        }
    }

    if($dataclick){
        foreach ($dataclick as $key => $value) {
            $clickarray[$value['date']] = $clickarray[$value['date']]+$value['count'];      
        }
    }

    if($datahits || $dataclick){
        $result['status'] = 200;
    } else {
        $result['status'] = 204;
        $result['message'] = 'No data to display';
    }
    
    $result['respon'] = [
        'label' => implode(",", $datalabel),
        'hits'  => implode(",", $hitsarray),
        'click' => implode(",", $clickarray),
    ]; 

    wp_send_json($result);
}