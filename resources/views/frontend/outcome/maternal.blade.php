@extends('layouts.app')
@section('content')
<div class="container">
	<div>
		<span class="box-heading box-heading-main mt-3">Maternal Health</span>
	</div>
	@include('layouts.partials.main-chart-partial')

	{{-- tabcontent start  --}}
	<div class="tab-content mt-3">
		<div class="row">
			<div class="col-12">
				<div class="box-heading float-left ml-0 mr-1">MATERNAL</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="trend-div">
					@foreach($trend_analysis as $key => $analysis)
						@include('layouts.partials.trend-analysis-chart-partial')
					@endforeach
				</div>
			</div>
		</div>


	</div>

	{{-- tabcontent end --}}
</div>
@endsection

@section('outjavascript')
<script src="{{ asset('js/Chart.PieceLabel.min.js') }}"></script>

<script>
	$('.area-date').html('Last 6 months');
	$('.specific-date').html('Last 6 months');

	function loadPeriodWiseData($this, model, id) {
		$.ajax({
			type: 'GET',
			url: '/outputs/maternal/load-period-wise-data', 
			data: { model : model, period: $this.val() },
			success: function (res) {
				$('#chart-area-'+ res.key).html('');
				$('#line-chart-'+ res.key).html('');

				// console.log(res)
				pieChart(res.key, res.percent)
				var arr = res;
				myLine.destroy();
				trendAnalysisChart(res.key, arr);
				$('#area-date-'+id).html($this.find(':selected').text());
				$('#specific-date-'+id).html($this.find(':selected').text());
			}
		})
	}
</script>

<script>
	var affectedExists = 0;
	var Divisions = '';
	var Programme = '';
	var AffectedArrs = '';
	var mainChartCtx = document.getElementById("mainChart").getContext('2d');
	mainChartCtx.height = 500;
	var mainChart;

	function charts(datasets, labels) {
	    window.mainChart = new Chart(mainChartCtx, {
	    	type: 'bar',
	    	data: datasets,
	    	options: {
	    		title: {
	    			display: true,
	    			text: labels
	    		},
	    		maintainAspectRatio: false,
	    		scales: {
	    			xAxes: [{
	    				stacked: true,
	    				gridLines : {
	    					display : false
	    				},
	    				barPercentage: 1.0
	    			}],
					// yAxes: [{
					// 	stacked: true
					// }]
					yAxes: [{
						stacked: true,
	                    ticks: {
	                        beginAtZero:true,
	                        callback: function(value, index, values) {
	                            if(parseInt(value) >= 1000){
	                               return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	                            } else {
	                               return value;
	                            }
	                       }                            
	                    }
	                }]
	    		},
	            // Container for pan options
	            pan: {
	                // Boolean to enable panning
	                enabled: true,

	                // Panning directions. Remove the appropriate direction to disable
	                // Eg. 'y' would only allow panning in the y direction
	                mode: 'xy'
	            },

	            // Container for zoom options
	            zoom: {
	                // Boolean to enable zooming
	                enabled: false,

	                // Zooming directions. Remove the appropriate direction to disable
	                // Eg. 'y' would only allow zooming in the y direction
	                mode: 'xy',
	            }
	        }
	    });
	}

	$(document).ready(function() {
		$("#organisation_unit_id").val("dNLjKwsVjod.dNLjKwsVjod");
		var organisation_unit_id = $("#organisation_unit_id").val();

		$("#period_id").val("LAST_6_MONTHS");
		var period_id = $("#period_id").val();

		$("#indicator_id").val("plw_who_receive_ifas");
		var indicator_id = $("#indicator_id").val();

		$("#department_id").val("both");
		var department_id = $("#department_id").val();

		var output = 'maternal';

		var data = 'organisation_unit_id='+organisation_unit_id+'&period_id='+period_id+'&indicator_id='+indicator_id+'&department_id='+department_id+'&output='+output;
		data += "&_token={{ Session::token() }}";

		main_chart_data(data);

	});

	var tab_indices = {'maternal_counselling': 0, 'plw_who_receive_ifas': 1, 'pregnant_women_weighed': 2, 'exclusive_breastfeeding': 3};
	function main_chart_data(data) {
		$.ajax({
			type: 'POST',
			url: '/outputs/maternal-main-chart',
			data: data,
			success: function (res) {
				title = res.title;
				dataSets = res.dataSets
				if (window.mainChart != undefined) {
					window.mainChart.destroy();
				}

				charts(dataSets, title);
				$('.swiper-slide').hide();
				$('#swiper-slide-'+tab_indices[$('#indicator_id').val()]).show();

			}, error : function () {
				console.log('error');
			}
		})
	}

	$('#indicator_id').click(function() {
		$('.swiper-slide').hide();
		$('#swiper-slide-'+tab_indices[$('#indicator_id').val()]).show();
	});

	$('#main-chart-form').on('submit', function() {
		var data = $(this).serialize();
		data += '&output=maternal';

		main_chart_data(data);

		return false;
	});

	@foreach($trend_analysis as $key => $analysis)
	pieChart({{ $key }}, {{ $analysis['percent'] }})
	var arr = {!! json_encode($analysis) !!};
	trendAnalysisChart('{{ $key }}', arr)
	@endforeach


	function trendAnalysisChart(id, data_value) {
		var ctx = document.getElementById('line-area-' + id).getContext('2d');
		var config = {
			type: 'line',
			data: {
				labels: data_value.periods,
				datasets: [{
					label: data_value.name,
					borderColor: '#81ddc6',
					backgroundColor: '#81ddc6',
					data: data_value.values,
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				title: {
					display: false,
					text: 'Chart.js Line Chart - Stacked Area'
				},
				tooltips: {
					mode: 'index',
				},
				hover: {
					mode: 'index'
				},
				scales: {
					xAxes: [{
						scaleLabel: {
							display: true,
							// labelString: 'Month'
						}
					}],
					yAxes: [{
						stacked: true,
						scaleLabel: {
							display: true,
							// labelString: 'Value'
						}
					}]
				}
			}
		};
		window.myLine = new Chart(ctx, config);
		
	}

	function pieChart(id, data_value) {
		var parentDiv = document.getElementById('pie-chart-'+id);
		var w = 300,                        
		h = 156,                            
		r = Math.min(w, h) / 2,                             
		color = ['#fba69c', '#d2d2d2'];     
		dataCSV = [{"label": data_value+"%", "value": data_value}, 
		{"label":  100 - data_value+"%", "value": 100 - data_value}]
		var vis = d3.select('#chart-area-'+ id)
		.data([dataCSV])
		.attr("width", w)
		.attr("height", h)
		.append("svg:g")                
		.attr("transform", "translate(" + r + "," + r + ")")

		var arc = d3.svg.arc()
		.innerRadius(0)
		.outerRadius(r);

		var pie = d3.layout.pie().sort(null);
		pie.value(function(d) { return d.value; });    

		var arcs = vis.selectAll("g.slice")     
		.data(pie)
		.enter()
		.append("svg:g")
		.attr("class", "slice");

		arcs.append("svg:path")
		.attr("fill", function(d, i) { return color[i]; } ) 
		.attr("d", arc);
		arcs.append("svg:text")
		.attr("transform", function(d) {
			d.innerRadius = 0;
			d.outerRadius = r;
			return "translate(" + arc.centroid(d) + ")";
		})
		.attr("text-anchor", "middle")
		.text(function(d, i) { return dataCSV[i].label; })
		.style("fill", function(d, i) { if(i==0) return '#ffffff'; else return '#000000'; } )
		.style("font-size", "13px")
	}
</script>
@endsection
