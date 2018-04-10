	@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row">
			<!-- content -->
			<div class="col-sm-9">
				<div class="intro-text h3">
					Our goal is to reduce malnutrition and improve nutritional status of  the peoples of Bangladesh with special emphasis to the children, adolescents, pregnant &amp; lactating women, elderly, poor and underserved population of both rural and urban area in line with National Nutrition Policy 2015.
				</div>
				<div class="output-dashboard">
					<h1><b>National Outputs</b></h1>
					<div id="maternal-health" class="mt-5">
						<h3>Maternal Health</h3>
						<div class="row">
							@foreach($maternal_trend_analysis as $key => $maternal_trend)
							<div class="col-md-6 col-lg-4">
								<h4>{{ $maternal_trend['name'] }}</h4>
								<div id="canvas-holder" class="canvas-holder">
									<canvas id="chart-area-maternal-{{ $key }}"></canvas>
								</div>
							</div>
							@endforeach
						</div>
					</div>

					<div id="child-health" class="mt-5">
						<h3>Child Health</h3>
						<div class="row">
							@foreach($child_trend_analysis as $key => $child_trend)
							<div class="col-md-6 col-lg-4">
								<h4>{{ $child_trend['name'] }}</h4>
								<div id="canvas-holder" class="canvas-holder">
									<canvas id="chart-area-child-{{ $key }}"></canvas>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>

				<div class="output-division-dashboard">
					<h1><b>Outputs by Division</b></h1>
					<div class="row">
						<div class="col-lg-12">
							<div id="mapdiv" class="map-wrapper"></div>
						</div>
						<div class="col-lg-4">
							<h3 id="division-name" class="mb-2"></h3>
							<div class="outer-legend mb-1" id="legend-for-data">
								<div class="legend legend-1">This month</div> 
								<div class="legend legend-2">Rest of the month</div> 
							</div>
							<div class="piecharts" id="division-piecharts"></div>
						</div>
					</div>
				</div>

				<div class="outcome-dashboard mt-5">
					<h1><b>Outcome</b></h1>
					<div class="row">
						@foreach($outcomes as $key => $analysis)
							@include('layouts.partials.dashboard-outcomes-partial')
						@endforeach
					</div>
				</div>


			</div>
			<!-- sidebar -->
			<div class="col-sm-3">
				<h1><b>Inputs</b></h1>
				<div class="sideblock mt-2">
					<h3>Reporting</h3>
					<p>Departments that have submitted the reports for the month of April.</p>
					<h4 class="bg-green">FWC</h4>
					<h4 class="bg-green">IMCI-N</h4>
					<h4 class="bg-red">SAM</h4>
					<p>View results from past months</p>
				</div>
				@foreach($sidebarContents as $key => $sidebarContent)
					@include('layouts.partials.dashboard-sidebar-partial')
				@endforeach
			</div>

		</div>
	</div>
@endsection


@section('outjavascript')
	<script src="{{ asset('js/Chart.PieceLabel.min.js') }}"></script>

	<script>
	$(document).ready(function(){
		$('#legend-for-data').hide();
	});

	@foreach($maternal_trend_analysis as $key => $maternal_trend) 
		pieChart(
			'maternal-' + '{{$key }}', 
			{{ $maternal_trend['percent'] }}, 
			{!! $maternal_trend['labels'] !!}
		)
	@endforeach

	@foreach($child_trend_analysis as $key => $child_trend)
		pieChart(
			'child-' + '{{$key }}', 
			{{ $child_trend['percent'] }},
			{!! $child_trend['labels'] !!}
		)
	@endforeach

	function pieChart(id, data_value, labels) {
    var randomScalingFactor = function() {
      return Math.round(Math.random() * 100);
    };
    
    var config = {
      type: 'pie',
      data: {
        datasets: [{
          data: [
            data_value,
            100 - data_value,
          ],
          backgroundColor: [
            'rgb(29, 192, 255)',
          ],
          label: 'Dataset 1'
        }],
        labels: [
          labels[0],
          labels[1],
        ]
      },
      options: {
        responsive: true,
        pieceLabel: {
          render: 'percentage',
          fontColor: ['white', 'rgb(29, 192, 255)'],
          precision: 2
        }
      }
    };

    var ctx = document.getElementById('chart-area-'+ id).getContext('2d');
    window.myPie = new Chart(ctx, config);
  }

  function doughChart(id, data_value, labels, title) {    
		Chart.pluginService.register({
			beforeDraw: function (chart) {
				if (chart.config.options.elements.center) {
			        //Get ctx from string
			        var ctx = chart.chart.ctx;
			        
					//Get options from the center object in options
			        var centerConfig = chart.config.options.elements.center;
			      	var fontStyle = centerConfig.fontStyle || 'Arial';
							var txt = centerConfig.text;
			        var color = centerConfig.color || '#000';
			        var sidePadding = centerConfig.sidePadding || 20;
			        var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
			        //Start with a base font of 30px
			        ctx.font = "30px " + fontStyle;
			        
					//Get the width of the string and also the width of the element minus 10 to give it 5px side padding
			        var stringWidth = ctx.measureText(txt).width;
			        var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

			        // Find out how much the font can grow in width.
			        var widthRatio = elementWidth / stringWidth;
			        var newFontSize = Math.floor(30 * widthRatio);
			        var elementHeight = (chart.innerRadius * 2);

			        // Pick a new font size so it will not be larger than the height of label.
			        var fontSizeToUse = Math.min(newFontSize, elementHeight);

					//Set font settings to draw it correctly.
			        ctx.textAlign = 'center';
			        ctx.textBaseline = 'middle';
			        var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
			        var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
			        ctx.font = fontSizeToUse+"px " + fontStyle;
			        ctx.fillStyle = color;
			        
			        //Draw text in center
			        ctx.fillText(txt, centerX, centerY);
				}
			}
		});

    var config = {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [
            data_value,
            100 - data_value,
          ],
          backgroundColor: [
            'rgb(29, 192, 255)',
          ],
          label: 'Dataset 1'
        }],
        labels: [
          labels[0],
          labels[1],
        ]
      },
      options: {
				elements: {
					center: {
						text: data_value+"%",
	          color: '#36AFFF', // Default is #000000
	          fontStyle: 'Arial', // Default is Arial
	          sidePadding: 50 // Defualt is 20 (as a percentage)
					}
				},
				title: {
					display: true,
					text: title,
					// fontSize: 15,
					wrap: true, 
				},
				legend: {
	        display: false
		    },
		    tooltips: {
		    	bodyFontSize: 12,
		    	xPadding: 10,
		    	// Template: "<%if (label){%><%=label%>: <%}%><%= value %>hrs",
		    	display: false
		    },
			  percentageInnerCutout : 100,

		    responsive:true,
				maintainAspectRatio: true,
				tooltipCaretSize: 0,
				cutoutPercentage: 90
			}
    };

    var ctx = document.getElementById('chart-area-'+ id).getContext('2d');
    window.myPie = new Chart(ctx, config);
    // window.myPie.canvas.parentNode.style.height = '128px';
  }


    function initMap() {
        map = new google.maps.Map(document.getElementById('mapdiv'), {
          center: {lat: 23.684994, lng: 90.356331},
          zoom: 7,
          scrollwheel: true
        });

        // Set a blank infoWindow to be used for each to state on click
		var infoWindow = new google.maps.InfoWindow({
			content: ""
		});

		// Create the state data layer and load the GeoJson Data
		var stateLayer = new google.maps.Data();
		
		{{-- stateLayer.loadGeoJson("{{asset('bangladesh-division.geojson')}}"); --}}
		stateLayer.loadGeoJson("{{asset('js/test.geojson')}}");

		// Set and apply styling to the stateLayer
		stateLayer.setStyle(function(feature) {
			return {
				fillColor: '#666',
				fillOpacity: 0.6,
				strokeColor: '#777',
				strokeWeight: 1.5,
				zIndex: 1
			};
		});

		// Add mouseover and mouse out styling for the GeoJSON State data
		stateLayer.addListener('mouseover', function(e) {
			stateLayer.overrideStyle(e.feature, {
				strokeColor: '#333',
				strokeWeight: 2,
				zIndex: 2
			});
		});

		stateLayer.addListener('mouseout', function(e) {
			
			stateLayer.overrideStyle(e.feature, {
				strokeColor: '#777',
				strokeWeight: 1.5,
				zIndex: 1
			});
		});
		
		stateLayer.addListener('click', function(e) {
			var elem = $('#mapdiv').parent();
			elem.addClass('col-lg-8');
			elem.removeClass('col-lg-12');
	    infoWindow.setContent('<div style="line-height:1.00;overflow:hidden;white-space:nowrap;">' +
	      e.feature.getProperty('name') + '</div>');

	    var anchor = new google.maps.MVCObject();
	    anchor.set("position", e.latLng);
	    infoWindow.open(map, anchor);
		});

    stateLayer.addListener('click', function(event) {
     	getDivisionData(event);
     	stateLayer.revertStyle();
     	stateLayer.overrideStyle(event.feature, {fillColor: '#1ebffa', fillOpacity: 0.8,});
    });


        // Final step here sets the stateLayer GeoJSON data onto the map
		stateLayer.setMap(map);
	}

	function getDivisionData(event) {
    	$.ajax({
	      type: 'get',
	      url: '/dashboard_percents',
	      data: {"ids": event.feature.getProperty('ids')},
	      success: function (res) {
	      	$('#legend-for-data').show();
	      	$('#division-name').html(event.feature.getProperty('name'))
	      	child = res['child'];
	      	maternal = res['maternal'];
	      	output = '';
	      	for (var i = 0; i < child.length; i++) {
	      		output += '<div id="canvas-holder" class="canvas-holder canvas-holder-division"><canvas id="chart-area-division-child-'+[i]+'"></canvas></div>';
	      	};
	      	for (var i = 0; i < maternal.length; i++) {
	      		output += '<div id="canvas-holder" class="canvas-holder canvas-holder-division"><canvas id="chart-area-division-maternal-'+[i]+'"></canvas></div>';
	      	};
	      	$('#division-piecharts').html(output);

	      	for (var i = 0; i < child.length; i++) {
	      		doughChart('division-child-' + i, child[i].percent, child[i].labels, child[i].name);
	      	};
	      	for (var i = 0; i < maternal.length; i++) {
	      		doughChart('division-maternal-' + i, maternal[i].percent, maternal[i].labels, maternal[i].name);
	      	};
	      	
	      },
	      error: function(res) {
	        console.log('failed')
	      }
	  	});
	}

	</script>

	<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkyw2RR6Cy0hsAOE4-um5lZg5TV6c8bbQ&callback=initMap">
  </script>
@endsection