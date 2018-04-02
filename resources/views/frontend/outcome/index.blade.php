@extends('layouts.app')
@section('content')
	<div class="container">
		@include('layouts.partials.main-chart-partial')

		@foreach($trend_analysis as $analysis)
			@include('layouts.partials.trend-analysis-chart-partial')
		@endforeach
	</div>
@endsection

@section('injavascript')
// <script>
$(document).ready(function() {
    // $('#affected-id').parent().hide();

    // getDivisions();
    // getPeriods();
    // getElements();
});

var affectedExists = 0;
var Divisions = '';
var Programme = '';
var AffectedArrs = '';
var ctxMain = document.getElementById("mainChart").getContext('2d');
ctxMain.height = 500;
var mainChart;
var colors = [
    'rgba(255, 99, 132, 0.8)',
    'rgba(54, 162, 235, 0.8)',
    'rgba(255, 206, 86, 0.8)',
    'rgba(75, 192, 192, 0.8)',
    'rgba(153, 102, 255, 0.8)',
    'rgba(255, 519, 64, 0.8)',
    'rgba(25, 59, 64, 0.8)',
    'rgba(55, 159, 64, 0.8)',
    'rgba(255, 15, 64, 0.8)',
    'rgba(255, 59, 64, 0.8)',
    'rgba(255, 59, 4, 0.8)',
    'rgba(255, 239, 64, 0.8)',
    'rgba(255, 19, 124, 0.8)',
    'rgba(55, 219, 64, 0.8)',
    'rgba(25, 39, 114, 0.8)',
    'rgba(215, 19, 164, 0.8)',
    'rgba(252, 129, 64, 0.8)',
];

function charts(datasets, labels) {
    // console.log(datasets);
    window.mainChart = new Chart(ctxMain, {
        type: 'bar',
        data: datasets,
        options: {
            title: {
                display: true,
                text: labels
            },
            tooltips: {
             mode: 'index',
             intersect: false
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            },
            // Container for pan options
            // pan: {
            //     // Boolean to enable panning
            //     enabled: true,

            //     // Panning directions. Remove the appropriate direction to disable
            //     // Eg. 'y' would only allow panning in the y direction
            //     mode: 'xy'
            // },

            // // Container for zoom options
            // zoom: {
            //     // Boolean to enable zooming
            //     enabled: true,

            //     // Zooming directions. Remove the appropriate direction to disable
            //     // Eg. 'y' would only allow zooming in the y direction
            //     mode: 'xy',
            // }
        }
    });
}

$('#main-chart-form').on('submit', function() {
    formData = $(this).serialize();
    indicator = $('#indicator_id').val();
    department = $('#department_id').val();
    title = $("#indicator_id option[value="+indicator+"]").text()
    dataSets = [];
    $.ajax({
        type: 'post',
        url: '/outcomes/get-outcome-data',
        data: $(this).serialize(),
        success: function (res) {
            labels = res['labels'];
            data = res['data'];
            titles = res['titles'];
            console.log(titles);
            if(res['mixed'] == 1) {
                for(var i = 0; i < data.length; i++) {
                   dataSets.push({
                        'label': titles[i],
                        'data': data[i],
                        'stack': 'Stack 0',
                        'backgroundColor': colors[i]
                    // 'borderColor': bgColor,
                    // 'borderWidth': 1
                    }); 
                } 
            } else {
                dataSets.push({
                    'label': titles[0],
                    'data': data,
                    'backgroundColor': colors[0]
                // 'borderColor': bgColor,
                // 'borderWidth': 1
                }); 
            }
            
            if(window.mainChart != undefined){
                window.mainChart.destroy();
            }
            dataSets = {labels: labels, datasets: dataSets};
            console.log(dataSets);

            charts(dataSets, title);
        },
        error: function(res) {
            console.log('failed')
        }
    })

    return false;
});

</script>
@endsection

@section('outjavascript')
	<script>
		var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};

		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						// randomScalingFactor(),
						// randomScalingFactor(),
						// randomScalingFactor(),
					],
					backgroundColor: [
						'rgba(255, 99, 132, 0.8)',
					    'rgba(54, 162, 235, 0.8)',
					],
					label: 'Dataset 1'
				}],
				labels: [
					'Pink',
					'Blue',
				]
			},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};
	</script>
	<script>
		var canvas = document.getElementById("line-chart");
    	var ctx = canvas.getContext("2d");

		var trendChart = new Chart(ctx, {
		  type: 'line',
		  data: {
		    labels: [0.05, 0.1, 0.15, 0.2, 0.25, 0.3, 0.35, 0.4, 0.45, 0.5, 0.55, 0.6, 0.65, 0.7, 0.75, 0.8, 0.85, 0.9, 0.95, 1],
		    datasets: [{
		      label: 'Dataset 1',
		      borderColor: 'rgba(54, 162, 235, 0.8)',
		      borderWidth: 2,
		      fill: false,
		      data: [19304,13433,9341,6931,5169, 3885,2927,2159,1853,1502, 1176,911,724,590,491, 400,335,280,239,200]
		    }]
		  },
		  options: {
		    responsive: true,
		    title: {
		      display: true,
		      text: 'Chart.js Drsw Line on Chart'
		    },
		    tooltips: {
		      mode: 'index',
		      intersect: true
		    },
		  }
		});
	</script>
@endsection
