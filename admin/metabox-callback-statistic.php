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
    
    ?>
    <div class="wpbannerman-admin">
        <div class="wpbannerman-filter text-center" data-id="<?php echo $getId; ?>">
            <div class="button-group">
                <button type="button" class="button" data-time="7">Week</button>
                <button type="button" class="button button-primary" data-time="30">Month</button>
                <button type="button" class="button" data-time="365">Year</button>
                <button type="button" class="button" data-time="toggle-custom-datepicker">Custom</button>
            </div>
            <div class="custom-datepicker">
                <input type="date" name="date-from" value="" class="date-from regular-text">
                <span>to</span>
                <input type="date" name="date-to" value="" class="date-to regular-text">
                <button type="button" class="button" data-time="custom-date">Load data</button>
            </div>
        </div>
        <div class="wpbannermanchart"></div>
        <hr>
        <div class="text-right">
            <span class="button button-large wpbannerman-reset-statistic" data-id="<?php echo $getId; ?>">
                Reset All Data
            </span>
        </div>

    </div>

    <script>
        jQuery(function($){

            function loadChartWPBannerman(time){
                let idpost  = $('.wpbannerman-filter').data('id');
                let from    = $('.wpbannerman-filter .date-from').val();
                let to      = $('.wpbannerman-filter .date-to').val();

                $.ajax({
                    method: "POST",
                    url: wpbannermanager_ajax.ajaxurl,
                    data: { action: "wpbannermanchart", idpost: idpost, time: time, datefrom:from, dateto:to  }
                }).done(function( respons ) {

                    if(respons.status==200) {

                        $('.wpbannermanchart').html('<canvas id="myBannerChart"></canvas>');

                        const labels    = respons.respon.label.split(',');
                        const datahits  = respons.respon.hits.split(',');
                        const dataclick = respons.respon.click.split(',');
                        const datachart = {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Hits',
                                    backgroundColor: 'rgb(255, 99, 132, 0.2)',
                                    borderColor: 'rgb(255, 99, 132)',
                                    data: datahits,
                                    fill: true,
                                    borderWidth: 1,
                                },
                                {
                                    label: 'Clicks',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    data: dataclick,
                                    fill: true,
                                    borderWidth: 1,
                                },
                            ]
                        };

                        const config = {
                            type: 'line',
                            fill: true,
                            data: datachart,
                            options: {}
                        };

                        const myBannerChart = new Chart(
                            document.getElementById('myBannerChart'),
                            config
                        );

                    } else {
                        $('.wpbannermanchart').html(respons.message);
                    }

                });
            }

            loadChartWPBannerman(30);
            $('.wpbannerman-filter .button').click(function(){
                $('.wpbannerman-filter .button').removeClass('button-primary');
                $(this).addClass('button-primary');
                let datatime = $(this).data('time');
                if(datatime === 'toggle-custom-datepicker'){
                    $('.wpbannerman-filter .custom-datepicker').toggle(500);
                } else if(datatime === 'custom-date') {
                    loadChartWPBannerman(datatime);
                } else {
                    loadChartWPBannerman(datatime);
                    $('.wpbannerman-filter .custom-datepicker').hide(500);
                }
            });
        });

    </script>
    <?php
}