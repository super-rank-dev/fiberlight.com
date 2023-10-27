jQuery(function ($) {
	"use strict";
	$(document).ready(function () {
		//console.log(con_obj);
		$(con_obj.button_parent).append(con_obj.button_dom);
		//Custom action search
		$('#con_traker_from,#con_traker_to').datepicker({ dateFormat: 'mm/dd/yy' });
		$('#con_track_custom_container').hide();
	});
	$(document).on('click','#qcld-con-tracker-button',function (e) {
        $('#qcld-conversion-report-modal').modal('show');
    });

    //Custom action search operation
    $(document).on('click','#con_traker_sub',function (e) {
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(handle_chart_ajax);

    });
    function handle_chart_ajax() {
        var dateFrom=$('#con_traker_from').val();
        var dateTo=$('#con_traker_to').val();
        var data = {
            'action': 'qcld_con_tracker_custom_action_data',
            'date_from': dateFrom,
            'date_to': dateTo,
        };
        $.post(con_obj.ajax_url, data, function (response) {
        	console.log(response);
            $('#con_track_custom_container').show();
            $('.custom_cart_per').html(response.reports.cart_per);
            $('.custom_checkouts_per').html(response.reports.checkouts_per);
            $('.custom_orders_per').html(response.reports.orders_per);
            $('.custom_cart_total').html(response.reports.cart_total);
            $('.custom_checkouts_total').html(response.reports.checkouts_total);
            $('.custom_orders_total').html(response.reports.orders_total);
            if(response.chart_data.length>1){
                drawVisualizationCustom(response.chart_data);
			}

        });
    }
    function drawVisualizationCustom(chart_data) {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable(chart_data);

        var options = {
            title : 'Last 7days Customer Conversion Report',
            vAxis: {title: 'Action'},
            hAxis: {title: 'Day'},
            seriesType: 'bars',
            'width':'800',
            'height':'500',
            //colors: ['purple','orange','green'],
        };

        var chart = new google.visualization.ComboChart(document.getElementById('custom_chart_div'));
        chart.draw(data, options);
    }

});