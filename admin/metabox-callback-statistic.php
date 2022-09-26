<?php
/**
 * A file that defines a function for wpbannerman_display_main_metabox
 * 
 * @link       https://github.com/adityathok
 * @since      1.0.0
 *
 * @package    wp_banner_manager
 * @subpackage wp_banner_manager/admin
 */
function wpbannerman_display_statistic() {

    $getId  = isset($_GET['post'])?$_GET['post']:'';
    if(empty($getId)){
        echo 'Nothing to show';
        return false;
    }

    //create array date
    $datenow    = date( 'Y-m-d', current_time( 'timestamp', 0 ) );
    $startdate  = date("Y-m-d", strtotime("-1 month", strtotime($datenow)));
    $period     = new DatePeriod(
        new DateTime($startdate),
        new DateInterval('P1D'),
        new DateTime($datenow)
    );
    $hitsarray  = [];
    $clickarray = [];
    $datalabel  = [];
    foreach ($period as $key => $value) {
        $hitsarray[$value->format('Y-m-d')] = 0;
        $clickarray[$value->format('Y-m-d')] = 0;
        $datalabel[] = $value->format('Y-m-d');       
    }
    $hitsarray[$datenow ]   = 0;
    $clickarray[$datenow ]  = 0;
    $datalabel[]            = $datenow;

    //get data from table database    
    $hits       = new Wpbannerman_hits;
    $datahits   = $hits->get("(date BETWEEN '".$datalabel[0]."' AND '".$datenow."') AND (banner_id = ".$getId.")");
    $click      = new Wpbannerman_click;
    $dataclick  = $click->get("(date BETWEEN '".$datalabel[0]."' AND '".$datenow."') AND (banner_id = ".$getId.")");
    
    if(empty($datahits) && empty($dataclick)){
        echo 'No data to display';
        return false;
    }

    foreach ($datahits as $key => $value) {
        $hitsarray[$value['date']] = $hitsarray[$value['date']]+$value['hit'];      
    }
    foreach ($dataclick as $key => $value) {
        $clickarray[$value['date']] = $clickarray[$value['date']]+$value['count'];      
    }
    
    ?>
    <div>
        <canvas id="myBannerChart"></canvas>
        <hr>
        <div class="btn-right">
            <span class="button button-primary button-large wpbannerman-reset-statistic" data-id="<?php echo $getId; ?>">Reset</span>
        </div>
    </div>
    <script>
        const labels = [<?php echo "'".implode("','", $datalabel)."'"; ?>];

        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Hits',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [<?php echo implode(',',$hitsarray); ?>],
                },
                {
                    label: 'Clicks',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    data: [<?php echo implode(',',$clickarray); ?>],
                },
            ]
        };

        const config = {
            type: 'line',
            fill: true,
            data: data,
            options: {}
        };

        const myBannerChart = new Chart(
            document.getElementById('myBannerChart'),
            config
        );

    </script>
    <?php
}