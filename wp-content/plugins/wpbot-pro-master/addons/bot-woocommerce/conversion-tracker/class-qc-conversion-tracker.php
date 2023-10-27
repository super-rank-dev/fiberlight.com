<?php
/*
* QuantumCloud Woocommerce Conversion Tracker
* Revised On: 06-25-2018
*/

/*******************************
 * Main Class to Handle the Converstion Admin and front.
 * 
 *******************************/
if( !class_exists('QcConversionTracker') ){


	class QcConversionTracker{
		
		/*function __construct()
		{
		  add_action( 'wp_ajax_process_qc_promo_form', array(&$this,'process_qc_promo_form') );
			
		} //End of Constructor*/
		public $relative_folder_url = "";
		public $plugin_text_domain = "wpchatbot";
		public $add_cart_selector = "#wp-chatbot-add-cart-button";
		public $reached_cheackout_selector = ".wp-chatbot-checkout-link";
        public $report_button_parent= '.wp-chatbot-tabs nav ul';
        public $report_button_dom = '<li tab-data="report"><a  id="qcld-con-tracker-button" data-toggle="modal" href="#"><span class="wpwbot-admin-tab-icon"> <i class="fa fa-filter"></i></span>
                                          <span class="wpwbot-admin-tab-name">Conversion Report </span></a></li>';

        function init() {
            $this->relative_folder_url=plugin_dir_url( __FILE__ );
            if(is_admin() && !empty($_GET["page"]) && ($_GET["page"] == "wpwc-settings-page")){
                add_action('admin_enqueue_scripts', array(&$this, 'include_admin_scripts'));
                add_action('admin_footer',array(&$this, 'conversion_report_page'));
           }
            if(!is_admin()){
                add_action('wp_enqueue_scripts', array($this, 'include_front_scripts'));
            }
            //Add to cart action insert
            add_action( 'wp_ajax_qcld_con_tracker_insert', array(&$this,'con_tracker_insert') );
            add_action('wp_ajax_nopriv_qcld_con_tracker_insert', array(&$this,'con_tracker_insert'));

            //After completing order insert
            add_action( 'woocommerce_order_status_completed', array(&$this,'con_tracker_insert_for_order_place') );
            add_action( 'woocommerce_order_status_processing', array(&$this,'con_tracker_insert_for_order_place') );
            //custom
            add_action( 'wp_ajax_qcld_con_tracker_custom_action_data', array(&$this,'con_tracker_custom_action_data') );
        }

        function include_admin_scripts( $hook ){
            wp_register_style('qlcd-con-tracker-bootstrap', $this->relative_folder_url . '/admin/css/bootstrap.min.css');
            wp_enqueue_style('qlcd-con-tracker-bootstrap');
            wp_register_style('qlcd-con-tracker-datepicker', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/smoothness/jquery-ui.css');
            wp_enqueue_style('qlcd-con-tracker-datepicker');
           // wp_enqueue_style('jquery-ui-datepicker');
		    wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui-datepicker');
            wp_register_script('qlcd-con-tracker-bootstrapjs',$this->relative_folder_url . '/admin/js/bootstrap.js', array('jquery'), true);
            wp_enqueue_script('qlcd-con-tracker-bootstrapjs');

            wp_register_script('qlcd-con-tracker-chartjs',$this->relative_folder_url . '/admin/js/chart-loader.js', array(), true);
            wp_enqueue_script('qlcd-con-tracker-chartjs');
            wp_register_script('qlcd-con-tracker-adminjs', $this->relative_folder_url. '/admin/js/script.js', array('jquery','jquery-ui-datepicker','qlcd-con-tracker-bootstrapjs','qlcd-con-tracker-chartjs'), true);
            wp_enqueue_script('qlcd-con-tracker-adminjs');
		    wp_localize_script('qlcd-con-tracker-adminjs', 'con_obj',array('ajax_url' => admin_url('admin-ajax.php'),'button_parent'=>$this->report_button_parent,'button_dom'=>$this->report_button_dom,));
		}
        function conversion_report_page(){
            ?>
            <div id="qcld-conversion-report-modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><?php echo esc_html__('Customer Conversion Tracker', $this->plugin_text_domain); ?></h4>
                        </div>
                        <div class="modal-body">
                            <ul class="nav nav-tabs">
                                <li><a data-toggle="tab" href="#yester"><?php echo esc_html__('Yesterday', $this->plugin_text_domain); ?></a></li>
                                <li class="active"><a data-toggle="tab" href="#today"><?php echo esc_html__('Today', $this->plugin_text_domain); ?></a></li>
                                <li><a data-toggle="tab" href="#7days"><?php echo esc_html__('Last 7days', $this->plugin_text_domain); ?></a></li>
                                <li><a data-toggle="tab" href="#months"><?php echo esc_html__('This Month', $this->plugin_text_domain); ?></a></li>
                                <li><a data-toggle="tab" href="#custom"><?php echo esc_html__('Custom', $this->plugin_text_domain); ?></a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="yester" class="tab-pane fade">
                                    <?php
                                    //Yester day report
                                    global $wpdb;
                                    $sql = "SELECT DISTINCT * FROM ".$wpdb->prefix."qcld_conversion_tracker WHERE DATE(action_time) = DATE(NOW() - INTERVAL 1 DAY)";
                                    //$sql = "SELECT DISTINCT * FROM ".$wpdb->prefix."qcld_conversion_tracker WHERE DATE(action_time) >= DATE(NOW() - INTERVAL 7 DAY)";
                                    $reports=$this->qcld_con_tracker_get($sql);
                                    ?>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th><?php echo esc_html__('Add to Cart', $this->plugin_text_domain); ?></th>
                                            <th><?php echo esc_html__('Reached Checkout', $this->plugin_text_domain); ?></th>
                                            <th><?php echo esc_html__('Orders', $this->plugin_text_domain); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><?php echo esc_html($reports['cart_per']); ?>% (<?php echo esc_html($reports['cart_total']); ?>)</td>
                                            <td><?php echo esc_html($reports['checkouts_per']); ?>% (<?php echo esc_html($reports['checkouts_total']); ?>)</td>
                                            <td><?php echo esc_html($reports['orders_per']); ?>% (<?php echo esc_html($reports['orders_total']); ?>)</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?php
                                    $chart_sql = "SELECT *, DATE(action_time) AS date FROM ".$wpdb->prefix."qcld_conversion_tracker WHERE DATE(action_time) = DATE(NOW() - INTERVAL 1 DAY)";
                                    $charts_reports=json_decode(json_encode($wpdb->get_results($chart_sql)), true);
                                    $chart_data=$this->mapping_actions_for_chart($charts_reports);
                                    if(count($chart_data)>1){
                                        ?>

                                        <script>
                                            google.charts.load('current', {'packages':['corechart']});
                                            google.charts.setOnLoadCallback(drawVisualization);

                                            function drawVisualization() {
                                                // Some raw data (not necessarily accurate)
                                                var data = google.visualization.arrayToDataTable(<?php echo json_encode($chart_data); ?>);

                                                var options = {
                                                    title : 'Today Customer Conversion Report',
                                                    vAxis: {title: 'Action'},
                                                    hAxis: {title: 'Day'},
                                                    seriesType: 'bars',
                                                    'width':'800',
                                                    'height':'500',
                                                    //colors: ['purple','orange','green'],
                                                };

                                                var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
                                                chart.draw(data, options);
                                            }
                                        </script>
                                        <?php
                                    }
                                    ?>
                                    <div id="chart_div" ></div>
                                </div>
                                <div id="today" class="tab-pane fade in active">
                                    <?php
                                    //Yester day report
                                    global $wpdb;
                                    $today_sql = "SELECT DISTINCT * FROM ".$wpdb->prefix."qcld_conversion_tracker WHERE DATE(action_time) = DATE(NOW())";
                                    $today_reports=$this->qcld_con_tracker_get($today_sql);
                                    ?>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th><?php echo esc_html__('Add to Cart', $this->plugin_text_domain); ?></th>
                                            <th><?php echo esc_html__('Reached Checkout', $this->plugin_text_domain); ?></th>
                                            <th><?php echo esc_html__('Orders', $this->plugin_text_domain); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><?php echo esc_html($today_reports['cart_per']); ?>% (<?php echo esc_html($today_reports['cart_total']); ?>)</td>
                                            <td><?php echo esc_html($today_reports['checkouts_per']); ?>% (<?php echo esc_html($today_reports['checkouts_total']); ?>)</td>
                                            <td><?php echo esc_html($today_reports['orders_per']) ?>% (<?php echo esc_html($today_reports['orders_total']); ?>)</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?php
                                    $today_chart_sql = "SELECT *, DATE(action_time) AS date FROM ".$wpdb->prefix."qcld_conversion_tracker WHERE DATE(action_time) = DATE(NOW())";
                                    $today_charts_reports=json_decode(json_encode($wpdb->get_results($today_chart_sql)), true);
                                    $today_chart_data=$this->mapping_actions_for_chart($today_charts_reports);
                                    if(count($today_chart_data)>1){
                                    ?>

                                    <script>
                                        google.charts.load('current', {'packages':['corechart']});
                                        google.charts.setOnLoadCallback(drawVisualizationToday);

                                        function drawVisualizationToday() {
                                            // Some raw data (not necessarily accurate)
                                            var data = google.visualization.arrayToDataTable(<?php echo json_encode($today_chart_data); ?>);

                                            var options = {
                                                title : 'Today Customer Conversion Report',
                                                vAxis: {title: 'Action'},
                                                hAxis: {title: 'Day'},
                                                seriesType: 'bars',
                                                'width':'800',
                                                'height':'500',
                                                //colors: ['purple','orange','green'],
                                            };

                                            var chart = new google.visualization.ComboChart(document.getElementById('today_chart_div'));
                                            chart.draw(data, options);
                                        }
                                    </script>
                                    <?php
                                    }
                                    ?>
                                    <div id="today_chart_div" ></div>
                                </div>
                                <div id="7days" class="tab-pane fade">
                                    <?php
                                    $week_sql = "SELECT DISTINCT * FROM ".$wpdb->prefix."qcld_conversion_tracker WHERE DATE(action_time) >= DATE(NOW() - INTERVAL 7 DAY)";
                                    $week_reports=$this->qcld_con_tracker_get($week_sql);
                                    ?>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th><?php echo esc_html__('Add to Cart', $this->plugin_text_domain); ?></th>
                                            <th><?php echo esc_html__('Reached Checkout', $this->plugin_text_domain); ?></th>
                                            <th><?php echo esc_html__('Orders', $this->plugin_text_domain); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><?php echo esc_html($week_reports['cart_per']) ?>% (<?php echo esc_html($week_reports['cart_total']); ?>)</td>
                                            <td><?php echo esc_html($week_reports['checkouts_per']) ?>% (<?php echo esc_html($week_reports['checkouts_total']); ?>)</td>
                                            <td><?php echo esc_html($week_reports['orders_per']) ?>% (<?php echo esc_html($week_reports['orders_total']); ?>)</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?php
                                    $week_chart_sql = "SELECT *, DATE(action_time) AS date FROM ".$wpdb->prefix."qcld_conversion_tracker WHERE DATE(action_time) >= DATE(NOW() - INTERVAL 7 DAY) ORDER BY action_time ASC";
                                    $week_charts_reports=json_decode(json_encode($wpdb->get_results($week_chart_sql)), true);
                                    $week_chart_data=$this->mapping_actions_for_chart($week_charts_reports);
                                    if(count($week_chart_data)>1){
                                    ?>
                                    <script>
                                        google.charts.load('current', {'packages':['corechart']});
                                        google.charts.setOnLoadCallback(drawVisualizationWeek);

                                        function drawVisualizationWeek() {
                                            // Some raw data (not necessarily accurate)
                                            var data = google.visualization.arrayToDataTable(<?php echo json_encode($week_chart_data); ?>);

                                            var options = {
                                                title : 'Last 7days Customer Conversion Report',
                                                vAxis: {title: 'Action'},
                                                hAxis: {title: 'Day'},
                                                seriesType: 'bars',
                                                'width':'800',
                                                'height':'500',
                                                //colors: ['purple','orange','green'],
                                            };

                                            var chart = new google.visualization.ComboChart(document.getElementById('week_chart_div'));
                                            chart.draw(data, options);
                                        }
                                    </script>
                                        <?php } ?>
                                    <div id="week_chart_div" ></div>
                                </div>
                                <div id="months" class="tab-pane fade">
                                    <?php
                                    $till_date=date("d");
                                    $month_sql = "SELECT DISTINCT * FROM ".$wpdb->prefix."qcld_conversion_tracker WHERE DATE(action_time) >= DATE(NOW() - INTERVAL ".$till_date." DAY)";
                                    $month_reports=$this->qcld_con_tracker_get($month_sql);
                                    ?>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th><?php echo esc_html__('Add to Cart', $this->plugin_text_domain); ?></th>
                                            <th><?php echo esc_html__('Reached Checkout', $this->plugin_text_domain); ?></th>
                                            <th><?php echo esc_html__('Orders', $this->plugin_text_domain); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><?php echo esc_html($month_reports['cart_per']); ?>% (<?php echo esc_html($month_reports['cart_total']); ?>)</td>
                                            <td><?php echo esc_html($month_reports['checkouts_per']); ?>% (<?php echo esc_html($month_reports['checkouts_total']); ?>)</td>
                                            <td><?php echo esc_html($month_reports['orders_per']); ?>% (<?php echo esc_html($month_reports['orders_total']); ?>)</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?php
                                    $month_chart_sql = "SELECT *, DATE(action_time) AS date FROM ".$wpdb->prefix."qcld_conversion_tracker WHERE DATE(action_time) >= DATE(NOW() - INTERVAL ".$till_date." DAY) ORDER BY action_time ASC";
                                    $month_charts_reports=json_decode(json_encode($wpdb->get_results($month_chart_sql)), true);
                                    $month_chart_data=$this->mapping_actions_for_chart($month_charts_reports);
                                    if(count($month_chart_data)>1){
                                    ?>
                                    <script>
                                        google.charts.load('current', {'packages':['corechart']});
                                        google.charts.setOnLoadCallback(drawVisualizationMonth);

                                        function drawVisualizationMonth() {
                                            // Some raw data (not necessarily accurate)
                                            var data = google.visualization.arrayToDataTable(<?php echo json_encode($month_chart_data); ?>);

                                            var options = {
                                                title : 'Last 7days Customer Conversion Report',
                                                vAxis: {title: 'Action'},
                                                hAxis: {title: 'Day'},
                                                seriesType: 'bars',
                                                'width':'800',
                                                'height':'500',
                                                //colors: ['purple','orange','green'],
                                            };

                                            var chart = new google.visualization.ComboChart(document.getElementById('month_chart_div'));
                                            chart.draw(data, options);
                                        }
                                    </script>
                                    <?php } ?>
                                    <div id="month_chart_div" ></div>
                                </div>
                                <div id="custom" class="tab-pane fade">
                                    <h4><?php echo esc_html__('Pick dates for custom search', $this->plugin_text_domain); ?></h4>
                                    <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="con_traker_from" class="form-control" id="con_traker_from" placeholder="<?php echo esc_html__('From', $this->plugin_text_domain); ?>">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="con_traker_from" class="form-control" id="con_traker_to" placeholder="<?php echo esc_html__('To', $this->plugin_text_domain); ?>">
                                    </div>
                                    <div class="col-sm-4">
                                        <button type="button" id="con_traker_sub"> <?php echo esc_html__('Go', $this->plugin_text_domain); ?></button>
                                    </div>
                                    </div>
                                    <div class="row" id="con_track_custom_container">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th><?php echo esc_html__('Add to Cart', $this->plugin_text_domain); ?></th>
                                                <th><?php echo esc_html__('Reached Checkout', $this->plugin_text_domain); ?></th>
                                                <th><?php echo esc_html__('Orders', $this->plugin_text_domain); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><span class="custom_cart_per">0</span>% (<span class="custom_cart_total">0</span>)</td>
                                                <td><span class="custom_checkouts_per">0</span>% (<span class="custom_checkouts_total">0</span>)</td>
                                                <td><span class="custom_orders_per">0</span>% (<span class="custom_orders_total">0</span>)</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div id="custom_chart_div" ></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo esc_html__('Close', $this->plugin_text_domain); ?></button>
                        </div>
                    </div>

                </div>
            </div>
            <?php
        }
        function qlcd_conversion_tracker_table() {

            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();
            $table_name = $wpdb->prefix . 'qcld_conversion_tracker';

            $sql = "CREATE TABLE $table_name (
                    id mediumint(9) NOT NULL AUTO_INCREMENT,
                    action_reference smallint(5) NOT NULL COMMENT '1=WoowBot,5=Others',
                    action_for smallint(5) NOT NULL COMMENT '1=Add to Cart,2=Checkout,3=Order Completed',
                    action_data varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                    action_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                    UNIQUE KEY id (id)
                ) $charset_collate;";

                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql );
        }
        function include_front_scripts(){
            wp_enqueue_script( 'jquery' );
            wp_register_script('qlcd-con-tracker-frontjs', $this->relative_folder_url. '/front/js/script.js', array('jquery'), true);
            wp_enqueue_script('qlcd-con-tracker-frontjs');
            wp_localize_script('qlcd-con-tracker-frontjs', 'con_tracker_obj',array('ajax_url' => admin_url('admin-ajax.php'),'cart_selector'=>$this->add_cart_selector,'checkout_selector'=>$this->reached_cheackout_selector));
        }
        function con_tracker_insert(){
            global $woocommerce;
            $items = $woocommerce->cart->get_cart();
            $action_for = sanitize_text_field($_POST['action_for']);
            $action_reference = sanitize_text_field($_POST['action_reference']);
            global $wpdb;
            $tablename = $wpdb->prefix.'qcld_conversion_tracker';
            $data=array(
                    'action_reference'=>$action_reference,
                    'action_for'=>$action_for,
                    'action_time'=>current_time('mysql')
                    );
           $result=$wpdb->insert( $tablename,$data );
            echo wp_send_json(array('result'=>$result,'cart'=>$items));
        }
        function con_tracker_insert_for_order_place($order_id){
            global $wpdb;
            $order_sql = "SELECT * FROM ".$wpdb->prefix."qcld_conversion_tracker WHERE action_data =".$order_id;
            $order_result=$wpdb->get_results($order_sql);
            if(empty($order_result)){
                $tablename = $wpdb->prefix.'qcld_conversion_tracker';
                $data=array(
                    'action_reference'=>5,
                    'action_for'=>3,
                    'action_data'=>$order_id,
                    'action_time'=>current_time('mysql')
                );
                $wpdb->insert( $tablename,$data );
            }
        }
        function con_tracker_custom_action_data(){
             $date_from=date('Y-m-d',strtotime(sanitize_text_field($_POST['date_from'])));
             $date_to=date('Y-m-d',strtotime(sanitize_text_field($_POST['date_to'])));
            global $wpdb;
            $sql = "SELECT * FROM ".$wpdb->prefix."qcld_conversion_tracker WHERE action_time >= '".$date_from."' AND action_time <= '".$date_to."'";
            $reports=$this->qcld_con_tracker_get($sql);

            //chart
            $chart_sql = "SELECT *, DATE(action_time) AS date FROM ".$wpdb->prefix."qcld_conversion_tracker WHERE action_time >= '".$date_from."' AND action_time <= '".$date_to."' ORDER BY action_time ASC";
            $charts_reports=json_decode(json_encode($wpdb->get_results($chart_sql)), true);
            $chart_data=$this->mapping_actions_for_chart($charts_reports);
            echo wp_send_json(array('reports'=>$reports,'chart_data'=>$chart_data));
        }
        function qcld_con_tracker_get($sql){
            global $wpdb;
            $results =json_decode(json_encode($wpdb->get_results($sql)), true);
            $results_total=count($results);
            $add_carts=array();
            $cart_per=0;
            $checkouts=array();
            $checkout_per=0;
            $orders=array();
            $orders_per=0;
            foreach ($results as $result){
                if($result['action_for']==1){
                    array_push($add_carts,$result);
                }
                if($result['action_for']==2){
                    array_push($checkouts,$result);
                }
                if($result['action_for']==3){
                    array_push($orders,$result);
                }
            }
            //Operation
            $cart_total=count($add_carts);
            if($cart_total>0){
                $cart_per=$this->calculatePercentage($results_total,$cart_total);
            }
            $checkouts_total=count($checkouts);
            if($checkouts_total>0){
                $checkout_per=$this->calculatePercentage($results_total,$checkouts_total);
            }
            $orders_total=count($orders);
            if($orders_total>0){
                $orders_per=$this->calculatePercentage($results_total,$orders_total);
            }
            return array('cart_total'=>$cart_total,'cart_per'=>$cart_per,'checkouts_total'=>$checkouts_total,'checkouts_per'=>$checkout_per,'orders_total'=>$orders_total,'orders_per'=>$orders_per);
        }
        function mapping_actions_for_chart($charts_reports){
            $chart_group=[];
            foreach ($charts_reports as $item)  {
                if (!isset($chart_group[$item['date']])) {
                    $chart_group[$item['date']][] = $item;
                }else{
                    foreach ($chart_group as $key => $value) {
                        if($key==$item['date']){
                            $chart_group[$item['date']][] = $item;
                        }
                    }
                }

            }
            $chart_data=array(array('Day', 'Add To Cart', 'Reached Checkout', 'Purchased'));
            foreach ($chart_group as $key => $value){
                $key=date('d',strtotime($key));
                array_push($chart_data,$this->make_chart_count($key,$value));
            }
            return $chart_data;
        }
        function make_chart_count($day,$results){
            $add_carts=array();
            $checkouts=array();
            $orders=array();
            foreach ($results as $result){
                if($result['action_for']==1){
                    array_push($add_carts,$result);
                }
                if($result['action_for']==2){
                    array_push($checkouts,$result);
                }
                if($result['action_for']==3){
                    array_push($orders,$result);
                }
            }
            return array($day,count($add_carts),count($checkouts),count($orders));
        }
        function calculatePercentage($total, $item){
            $percentChange = (($item/ $total) * 100);
            return number_format((float)$percentChange, 2, '.', '');
        }

	
	} //End of the class QcConversionTracker


} //End of class_exists


/*
* Create Instance, set instance variables and then call appropriate worker.
*/

//Please create an unique instance for your use
add_action( 'init', 'qcld_con_tracker_instance', 10, 3 );

if (!function_exists('qcld_con_tracker_instance')) {
    function qcld_con_tracker_instance()
    {
        $con_tracker_instance=new QcConversionTracker();
        $con_tracker_instance->init();
        if(!get_option('qcld_con_tracker')){
            $con_tracker_instance->qlcd_conversion_tracker_table();
            add_option('qcld_con_tracker',1);

        }
    }
}
