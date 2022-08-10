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

    //create array date
    $datenow    = date( 'Y-m-d', current_time( 'timestamp', 0 ) );
    $startdate  = date("Y-m-d", strtotime("-1 month", strtotime($datenow)));
    $period     = new DatePeriod(
        new DateTime($startdate),
        new DateInterval('P1D'),
        new DateTime($datenow)
    );
    $datearray = [];
    $datalabel = [];
    foreach ($period as $key => $value) {
        $datearray[$value->format('Y-m-d')] = 0;
        $datalabel[] = $value->format('Y-m-d');       
    }
    $datearray[$datenow ] = 0;
    $datalabel[] = $datenow;

    //get data from table database    
    $hits       = new Wpbannerman_hits;
    $datatable = $hits->get('');
    foreach ($datatable as $key => $value) {
        $datearray[$value['date']] = $datearray[$value['date']]+$value['hit'];      
    }
    
    ?>
    <div>
        <canvas id="myChart"></canvas>
    </div>
    <script>
        const labels = [<?php echo "'".implode("','", $datalabel)."'"; ?>];

        const data = {
            labels: labels,
            datasets: [{
            label: 'Hits',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [<?php echo implode(',',$datearray); ?>],
            }]
        };

        const config = {
            type: 'line',
            fill: true,
            data: data,
            options: {}
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

    </script>
    <?php
}