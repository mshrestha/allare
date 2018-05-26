@extends('layouts.app')

@section('content')
	<div class="swiper-container-outer">
		<div class="container">
			<!-- Slider main container -->
			<!-- Swiper -->
		  <div class="swiper-container">
		    <div class="swiper-wrapper">
		    	<div class="swiper-slide container dataview">
		      	<div class="row">
			      	<div class="output-col col-md-7 col-lg-8 pb-3">
			      		<div class="row"  data-swiper-parallax="-300" data-swiper-parallax-opacity="0">
			      			<div class="col-sm-12">
			      				<div class="box-heading float-left">National outcomes</div>
			      				<div class="view-on-map float-right swiper-button-next">VIEW ON MAP</div>
			      			</div>
			      		</div> {{-- row --}}
			      		<div class="row">
			      			<div class="col-sm-6" data-swiper-parallax="0" data-swiper-parallax-opacity="0">
			      				<div id="maternal-health" style="width: 100%;"></div>
			      				<div class="legend row">
			      					<div class="conselling-given col-10 offset-2">Maternal Nutrition Counselling</div>
			      					<div class="ifa-distributed col-10 offset-2">IFA Distributed</div>
			      					<div class="weight-measured col-10 offset-2">Weight Measured</div>
			      					<div class="weight-measured col-10 offset-2">Increase in Exclusive Breastfeeding</div>
			      				</div> {{-- legend --}}
			      			</div>
			      			<div class="col-sm-6" data-swiper-parallax="-200" data-swiper-parallax-opacity="0">
			      				<div id="child-health" style="width: 100%;"></div>
			      				<div class="legend row">
			      					<div class="imci-counselling col-10 offset-2">IYCF Counselling</div>
			      					<div class="supplements-distributed col-10 offset-2">Supplements Distributed</div>
			      					<div class="child-growth col-10 offset-2">Child Growth Monitoring</div>
			      					<div class="child-growth col-10 offset-2">Increase in minimum acceptable diet</div>
			      				</div> {{-- legend --}}
			      			</div>
			      		</div> {{-- row --}}
			      		<div class="row mt-4">
			      			<div class="col-10 col-sm-4 offset-1" data-swiper-parallax="0" data-swiper-parallax-opacity="0">
			      				<label for="">Select the Division</label>
				      			<div class="input-group">
				                {{-- <div class="input-group-prepend">
				                    <label class="input-group-text" for="period-id">Periods</label>
				                </div> --}}
				                <select class="custom-select" name="period_id" id="period_id" required>
				                    <option value="">Divisions</option>
				                    <option value="">Barisal Division</option>
				                    <option value="">Chittagong Division</option>
				                    <option value="">Dhaka Division</option>
				                    <option value="">Khulna Division</option>
				                    <option value="">Mymensingh Division</option>
				                    <option value="">Rajshahi Division</option>
				                    <option value="">Rangpur Division</option>
				                    <option value="">Sylhet Division</option>
				                    <option value="">X organizationunits for delete</option>
				                    {{-- @foreach($periods as $key => $period)
				                    	<option value="{{ $key }}">{{ $period }}</option>
				                    @endforeach --}}
				                </select>
				            </div>
			      			</div>
			      			<div class="col-10 col-sm-4 offset-1 offset-sm-2" data-swiper-parallax="-200" data-swiper-parallax-opacity="0">
			      				<label for="">Select the Timeline</label>
				      			<div class="input-group">
				                {{-- <div class="input-group-prepend">
				                    <label class="input-group-text" for="period-id">Periods</label>
				                </div> --}}
				                <select class="custom-select" name="period_id" id="period_id" required>
				                    <option value="">Periods</option>
				                    <option value="LAST_MONTH">Last month</option>
				                    <option value="LAST_6_MONTHS">Last 6 months</option>
				                    {{-- @foreach($periods as $key => $period)
				                    	<option value="{{ $key }}">{{ $period }}</option>
				                    @endforeach --}}
				                </select>
				            </div>
			      			</div>
			      		</div> {{-- row --}}
			      	</div> {{-- output col-md-8 --}}
			      	<div class="col-md-5 col-lg-4 outcome-col" data-swiper-parallax="-300" data-swiper-parallax-opacity="0">
			      		<div class="row">
			      			<div class="col-12">
			      				<div class="box-heading float-left">IMPACT</div>
			      			</div>
			      		</div>
			      		<div class="row">
			      				@foreach($outcomes as $key => $analysis)
											@include('layouts.partials.dashboard-outcomes-partial')
										@endforeach
										{{-- <div class="col-12 outcome-note">
											Our goal is to reduce malnutrition and improve nutritional status of the children, adolescents, pregnant &amp; lactating women, elderly, poor and underserved population of both rural and urban areas of Bangladesh.
										</div> --}}
			      		</div>
			      	</div> {{-- col-md-4 --}}
		      	</div>
		      </div> {{-- data view --}}
		      <div class="swiper-slide container map-view-container">
		        <div class="row justify-content-between">
		        	<div class="col-6 col-md-4 col-lg-3 col-xl-2 pr-0 pl-0 d-block">
		    				<div class="box-heading float-left d-block ml-0">National Outcomes</div>
		    			</div>
		        	<div class="col-md-2 col-6">
		    				<div class="view-on-map float-right swiper-button-prev">VIEW DATA</div>
		    			</div>
		        </div>
		        <div class="row">
		        	<div class="col-md-4 col-lg-3 col-xl-2 pl-0 pr-0 filter-col">
		    				<ul class="map-filter mb-0">
		    					<li class="list-head">MATERNAL NUTRITION</li>
									<li><a href="#" id="counselling" class="maplinks inactive" onclick="getMapData('CcMrAncNutriCounsel', 'Counselling Given', '#counselling')">Counselling Given</a></li>
									<li><a href="#" id="ifadistribution" class="maplinks inactive" onclick="getMapData('CcMrAncIfaDistribution', 'IFA Distributed', '#ifadistribution')">IFA Distributed</a></li>
									<li><a href="#" id="ancweight" class="maplinks inactive" onclick="getMapData('CcMrWeightInKgAnc', 'Weight Measured', '#ancweight')">Weight Measured</a></li>
									<li class="list-head">CHILD NUTRITION</li>
									<li><a href="#" id="imcicounselling" class="maplinks inactive" onclick="getMapData('ImciCounselling', 'IMCI Counselling Given', '#imcicounselling')">IMCI Counselling Given</a></li>
									<li><a href="#" id="supplements" class="maplinks inactive" onclick="getMapData('CcCrAdditionalFoodSupplimentation', 'Supplements Distributed', '#supplements')">Supplements Distributed</a></li>

		    				</ul>
		    				<ul class="map-filter outcome mb-0">
									<li class="list-head green">IMPACTS</li>
									<li><a href="#" id="stunting" class="maplinks inactive" onclick="getMapData('ImciStunting', 'STUNING', '#stunting')">STUNTING</a></li>
									{{-- <li class="list-head" id="stunting" class="maplinks inactive" onclick="getMapData('ImciStunting', 'STUNING', '#stunting')">STUNTING</li> --}}
									<li><a href="#" id="wasting" class="maplinks inactive" onclick="getMapData('ImciWasting', 'WASTING', '#wasting')">WASTING</a></li>
									<li><a href="#" id="anemia" class="maplinks inactive" onclick="getMapData('ImciAnemia', 'Anemia', '#anemia')">ANEMIA</a></li>
		    				</ul>
		    				<ul class="map-filter mb-0">
									<li class="list-head">INTERMEDIATE</li>
									<li><a href="#" id="exclusive_breastfeeding" class="maplinks inactive" onclick="getMapData('CcCrExclusiveBreastFeeding', 'Exclusive Breastfeeding', '#exclusive_breastfeeding'
									)">Exclusive Breastfeeding</a></li>
									<li><a href="#" id="min_acceptable_diet" class="maplinks inactive">Min. Acceptable diet</a></li>
		    				</ul>
		    			</div>
		    			<div class="col-md-8 col-lg-9 col-xl-10 pl-0 pr-0 ">
		    				<div id="mapdiv" class="swiper-no-swiping map-wrapper" style="width: 100%;">
		    					<div id="zoomctrl">
							    </div>
		    				</div>
		    				<div id="overdiv">
		    					<span class="legend-text" id="low-text"></span>
		    					<span class="legend-text" id="avg-text"></span>
		    					<span class="legend-text" id="high-text"></span>
		    				</div>
		    			</div>
		        </div>
		      </div> {{-- swiper-slide --}}
		    </div> {{-- swiper-wrrapper --}}
		    <!-- Add Pagination -->
		    <div class="swiper-pagination swiper-pagination-white"></div>
		    <!-- Add Navigation -->
		    <div class="swiper-button-prev swiper-button-white"></div>
		    <div class="swiper-button-next swiper-button-white"></div>
		  </div> {{-- swiper-container --}}
		</div> {{-- container --}}
	</div>

	<div class="input-wrapper">
		<div class="container">
			<div class="input-wrapper-inner">
			  <div class="row">
			  	<div class="col-12"><div class="box-heading float-left">INPUTS</div></div>
			  </div>
			  <div class="row">
			  	<div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 input-box input-reporting">
			  		<h6>REPORTING</h6>
			  		{{-- <div><span class="report-lable">FWC</span> <span class="yes">Yes</span> <span class="no">No</span></div>
			  		<div><span class="report-lable">MCHN</span> <span class="yes">Yes</span> <span class="no">No</span></div>
			  		<div><span class="report-lable">SAM</span> <span class="yes">Yes</span> <span class="no">No</span></div> --}}

			  		<div>
			  			<span class="report-lable">FWC</span> 
			  			<div class="progress-bar-h">
								<div class="goal" style="width: 10%;">
								</div>
								<div class="current grow-h-animation" style="width: 30%;">
									30%
								</div>
							</div> {{-- progress-bar-h --}}
			  		</div>
			  		<div>
			  			<span class="report-lable">MCHN</span> 
			  			<div class="progress-bar-h">
								<div class="goal" style="width: 10%;">
								</div>
								<div class="current grow-h-animation" style="width: 65%;">
									65%
								</div>
							</div> {{-- progress-bar-h --}}
			  		</div>
			  		<div>
			  			<span class="report-lable">SAM</span> 
			  			<div class="progress-bar-h">
								<div class="goal" style="width: 10%;">
								</div>
								<div class="current grow-h-animation" style="width: 65%;">
									65%
								</div>
							</div> {{-- progress-bar-h --}}
			  		</div>
			  	</div>{{-- input-box input-reporting --}}
			  	<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 input-box input-training">
			  		<div class="input-trainning-inner">
				  		<h6 class="mb-0">TRAINING</h6>
				  		<div><span class="number">65%</span><span class="number-txt">Health workers trained </span></div>
				  		<div><span class="number">65%</span><span class="number-txt">Health workers who succeeded </span></div>
			  		</div>
			  	</div>{{-- input-box input-training --}}
			  	<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 input-box input-qa">
			  		<h6 class="mb-0">QUALITY ASSESSMENT</h6>
			  		<div><span class="number">65%</span><span class="number-txt">Facilities receiving SS&amp;M</span></div>
			  		<div><span class="number">65%</span><span class="number-txt">Facilities providing IYCF/ Maternal counselling</span></div>
			  		<div><span class="number">65%</span><span class="number-txt">Facilities providing quality Nut reporting</span></div>
			  	</div>{{-- input-box input-qa --}}
			  	<div class="col-sm-6 col-md-12 col-lg-3 col-xl-4 input-box input-supply-management">
			  		<h6 class="mb-0">SUPPLY MANAGEMENT</h6>
			  		<div class="row">
			  			<div class="col-xl-6 col-md-6 col-sm-12 col-lg-12"><span class="number">65%</span><span class="number-txt">Facilities with no stockout in IFA Tablets</span></div>
			  			<div class="col-xl-6 col-md-6 col-sm-12 col-lg-12"><span class="number">65%</span><span class="number-txt">Facilities with no stockout in Scales / Height board </span></div>
			  		</div>
			  		<div class="row">
			  			<div class="col-xl-6 col-md-6 col-sm-12 col-lg-12"><span class="number">65%</span><span class="number-txt">Facilities awaiting counselling material</span></div>
			  			<div class="col-xl-6 col-md-6 col-sm-12 col-lg-12"><span class="number">65%</span><span class="number-txt">Facilities with no stockout in F-75 and F-100 therapeutic </span></div>
			  		</div>
			  		<div class="row">
			  			<div class="col-xl-6 col-md-6 col-sm-12 col-lg-12"><span class="number">65%</span><span class="number-txt">Facilities with no stockout in MUAC tapes</span></div>
			  		</div>
			  	</div>{{-- input-box input-qa --}}
			  </div>
			</div>
		</div>
	</div>
</div>

<div class="container d-none">
	<div class="row">
		<!-- content -->
		<div class="col-sm-9">
			<div class="nationalOutputWrap">
				<div class="slideTrigger">Show map</div>
				<div class="slideInContainer">
					map
					<div>test</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<h3>Maternal Nutrition</h3>
						{{-- <div id="maternal-health" style="width: 100%; max-width: 300px; margin: 20px auto;"></div> --}}
					</div>
					<div class="col-sm-6">
						<h3>Child Nutrition</h3>
						{{-- <div id="child-health" style="width: 100%; max-width: 300px; margin: 20px auto;"></div> --}}
					</div>
				</div> {{-- /.row --}}
			</div> {{-- /.national-output-wrap --}}

			<div class="intro-text h3">
				Our goal is to reduce malnutrition and improve nutritional status of  the peoples of Bangladesh with special emphasis to the children, adolescents, pregnant &amp; lactating women, elderly, poor and underserved population of both rural and urban area in line with National Nutrition Policy 2015.
			</div>


			<div class="output-division-dashboard mt-5">
				<h1 class="mb-5"><b>Outputs by Division</b></h1>
				<div class="row">
					<div class="col-lg-12 slidemap">
						{{-- <div id="mapdiv" class="map-wrapper"></div> --}}
					</div>
					<div class="col-lg-4">
						<h3 id="division-name" class="mb-2"></h3>
						<div class="outer-legend mb-1" id="legend-for-data">
							<div class="legend legend-1">This month</div>
							<div class="legend legend-2">Rest of the year</div>
						</div>
						<div class="piecharts" id="division-piecharts"></div>
					</div>
				</div>
			</div>

			<div class="output-dashboard">
				<h1><b>National Outputs</b></h1>
				<div id="maternal-health" class="mt-5">
					<h3>Maternal Health</h3>
					<div class="row">
						@foreach($maternal_trend_analysis as $key => $maternal_trend)
						<div class="col-md-6 col-lg-4">
							<h4>{{ $maternal_trend['name'] }}</h4>
							<div class="canvas-holder">
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
							<div class="canvas-holder">
								<canvas id="chart-area-child-{{ $key }}"></canvas>
							</div>
						</div>
						@endforeach
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
		scoreColors = {"high": "#0b495e", "average": "#137f91", "low": "#81ddc5"};
	</script>

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

	// for aligning label of pie chart
	isArray = Array.isArray ?
	function (obj) {
	return Array.isArray(obj);
	} :
	function (obj) {
	return Object.prototype.toString.call(obj) === '[object Array]';
	};

	getValueAtIndexOrDefault = (value, index, defaultValue) => {
	if (value === undefined || value === null) {
		return defaultValue;
	}

	if (this.isArray(value)) {
		return index < value.length ? value[index] : defaultValue;
	}

	return value;
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
	responsive: true,
	pieceLabel: {
		render: 'percentage',
		fontColor: ['white', 'rgb(29, 192, 255)'],
		precision: 2
	},
	options: {
		legend: {
			display: true,
			labels: {
				generateLabels: (chart) => {

					chart.legend.afterFit = function () {
						var width = this.width;
						console.log(this);

						this.lineWidths = this.lineWidths.map( () => this.width-0 );

						this.options.labels.padding = 10;
						this.options.labels.boxWidth = 15;
					};

					var data = chart.data;
				          //https://github.com/chartjs/Chart.js/blob/1ef9fbf7a65763c13fa4bdf42bf4c68da852b1db/src/controllers/controller.doughnut.js
				          if (data.labels.length && data.datasets.length) {
				          	return data.labels.map((label, i) => {
				          		var meta = chart.getDatasetMeta(0);
				          		var ds = data.datasets[0];
				          		var arc = meta.data[i];
				          		var custom = arc && arc.custom || {};
				          		var getValueAtIndexOrDefault = this.getValueAtIndexOrDefault;
				          		var arcOpts = chart.options.elements.arc;
				          		var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
				          		var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
				          		var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

				          		return {
				          			text: label,
				          			fillStyle: fill,
				          			strokeStyle: stroke,
				          			lineWidth: bw,
				          			hidden: isNaN(ds.data[i]) || meta.data[i].hidden,

				                // Extra data used for toggling the correct item
				                index: i
				            };
				        });
				          }
				          return [];
				      }
				  }
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
					enabled: false
				},
				percentageInnerCutout : 100,

				responsive:true,
				maintainAspectRatio: true,
				tooltipCaretSize: 0,
				cutoutPercentage: 80
			}
		};

		var ctx = document.getElementById('chart-area-'+ id).getContext('2d');
		window.myPie = new Chart(ctx, config);
	// window.myPie.canvas.parentNode.style.height = '128px';
	}
	function ZoomControl(controlDiv, map) {

	  // Creating divs & styles for custom zoom control
	  controlDiv.style.padding = '5px';

	  // Set CSS for the control wrapper
	  var controlWrapper = document.createElement('div');
	  controlWrapper.style.backgroundColor = 'transparent';
	  controlWrapper.style.cursor = 'pointer';
	  controlWrapper.style.textAlign = 'center';
	  controlWrapper.style.width = '32px';
	  controlWrapper.style.height = '64px';
	  controlDiv.appendChild(controlWrapper);

	  // Set CSS for the zoomIn
	  var zoomInButton = document.createElement('div');
	  zoomInButton.style.width = '32px';
	  zoomInButton.style.height = '32px';
	  /* Change this to be the .png image you want to use */
	  zoomInButton.style.background = 'url("images/plus.png") no-repeat';
	  zoomInButton.style.backgroundSize = '90%';
	  // zoomInButton.style.backgroundRepeat = 'none';
	  controlWrapper.appendChild(zoomInButton);

	  // Set CSS for the zoomOut
	  var zoomOutButton = document.createElement('div');
	  zoomOutButton.style.width = '32px';
	  zoomOutButton.style.height = '32px';
	  /* Change this to be the .png image you want to use */
	  zoomOutButton.style.background = 'url("images/minus.png") no-repeat';
	  zoomOutButton.style.backgroundSize = '90%';

	  controlWrapper.appendChild(zoomOutButton);

	  // Setup the click event listener - zoomIn
	  google.maps.event.addDomListener(zoomInButton, 'click', function() {
	    map.setZoom(map.getZoom() + 1);
	  });

	  // Setup the click event listener - zoomOut
	  google.maps.event.addDomListener(zoomOutButton, 'click', function() {
	    map.setZoom(map.getZoom() - 1);
	  });

	}

    function initMap() {
      $.ajax({
	      type: 'get',
	      url: '/dashboard_specific_map',
	      data: {"model": "CcMrAncNutriCounsel"},
	      success: function (res) {
	      	if(res['dataExists']) {
				if(res['reverse']) {
					$('#low-text').html('Major Problem');
					$('#avg-text').html('Severe Problem');
					$('#high-text').html('Critical Problem');
				} else {
					$('#low-text').html('Critical Problem');
					$('#avg-text').html('Severe Problem');
					$('#high-text').html('Major Problem');
				}

	      		map = new google.maps.Map(document.getElementById('mapdiv'), {
			        center: {lat: 23.684994, lng: 90.356331},
			        zoom: 6.5,
			        scrollwheel: true,
			        styles: [{
							"featureType": "administrative",
							"elementType": "all",
							"stylers": [{
								"color": "#ededed"
							}]
						}, {
							"featureType": "administrative.province",
							"elementType": "all",
							"stylers": [{
								"color": "#ededed"
							}]
						}, {
							"featureType": "landscape",
							"elementType": "all",
							"stylers": [{
								"color": "#ededed"
							}]
						}, {
							"featureType": "poi",
							"elementType": "all",
							"stylers": [{
								"color": "#ededed"
							}]
						}, {
							"featureType": "road",
							"elementType": "all",
							"stylers": [{
								"color": "#ededed"
							}]
						}, {
							"featureType": "road.highway",
							"elementType": "all",
							"stylers": [{
								"color": "#ededed"
							}]
						}, {
							"featureType": "road.arterial",
							"elementType": "all",
							"stylers": [{
								"color": "#ededed"
							}]
						}, {
							"featureType": "road.local",
							"elementType": "all",
							"stylers": [{
								"color": "#ededed"
							}]
						}, {
							"featureType": "transit",
							"elementType": "all",
							"stylers": [{
								"color": "#ededed"
							}]
						}, {
							"featureType": "water",
							"elementType": "geometry",
							"stylers": [{
								"color": "#ededed"
							}]
						}, {
							"featureType": "water",
							"elementType": "labels",
							"stylers": [{
								"color": "#ededed"
							}]
						}],
			        	zoomControl: false,
			          zoomControlOptions: {
			              position: google.maps.ControlPosition.LEFT_BOTTOM
			          },
		          scaleControl: true,
		          streetViewControl: false,
		          noClear: true,
    			  disableDefaultUI:true

		      	});

		      	// var zoomControlDiv = document.createElement('div');
		      	var zoomControlDiv = document.getElementById('zoomctrl');
				var zoomControl = new ZoomControl(zoomControlDiv, map);

				zoomControlDiv.index = 1;
				map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(zoomControlDiv);

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
					var ids = feature.getProperty('ids').split('-');
					var id = ids[0];
					if(res['server'] == 'community')
						id = ids[1];
					var value = parseInt(res['minimalData'][id]);
					var localColor = '';
					if(value >= parseInt(res['min']) && value < parseInt(res['q1'])) {
						localColor = scoreColors['low'];
					} else if(value >= parseInt(res['q1']) && value < parseInt(res['q2'])) {
						localColor = scoreColors['average'];
					} else if(value >= parseInt(res['q2']) && value <= parseInt(res['max'])) {
						localColor = scoreColors['high'];
					}
					color = feature.getProperty('color');
					return {
						fillColor: localColor,
						fillOpacity: 1,
						strokeColor: '#fff',
						strokeWeight: 1.5,
						zIndex: 1
					};
				});

				// Add mouseover and mouse out styling for the GeoJSON State data
				stateLayer.addListener('mouseover', function(e) {
					ids = e.feature.getProperty('ids').split('-');
					id = ids[0];
					if(res['server'] == 'community')
						id = ids[1];
					value = res['minimalData'][id];
					infoWindow.setContent('<div style="line-height:1.00;overflow:hidden;white-space:nowrap;">' + e.feature.getProperty('name') + '<br />' + res['text'] + '<span class="map-text">' + parseInt(value) + '</span>' + '</div>');
					var anchor = new google.maps.MVCObject();
		    	anchor.set("position", e.latLng);
		    	infoWindow.open(map, anchor);
					stateLayer.overrideStyle(e.feature, {
						// fillColor: e.feature.getProperty('color'),
						strokeColor: '#CCC',
						// strokeColor: e.feature.getProperty('color'),
						strokeWeight: 1,
						zIndex: 2
					});
				});

				stateLayer.addListener('mouseout', function(e) {
					stateLayer.overrideStyle(e.feature, {
						strokeColor: '#fff',
						strokeWeight: 1.5,
						zIndex: 1
					});
				});

		        // Final step here sets the stateLayer GeoJSON data onto the map
				stateLayer.setMap(map);
	      	}else{

	      	}

	      },
	      error: function(res) {
	        console.log('failed')
	      }
	  	});
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
					output += '<div class="canvas-holder canvas-holder-division"><canvas id="chart-area-division-child-'+[i]+'"></canvas></div>';
				};
				for (var i = 0; i < maternal.length; i++) {
					output += '<div class="canvas-holder canvas-holder-division"><canvas id="chart-area-division-maternal-'+[i]+'"></canvas></div>';
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
	{{-- radial progress --}}
	<script>
	// 	new RadialProgressChart('#maternal-health', {series: [24, 85]});
	// new RadialProgressChart('#child-health', {series: [24, 85]});

    // Firefox 1.0+
    var isFirefox = typeof InstallTrigger !== 'undefined';

    // Safari 3.0+ "[object HTMLElementConstructor]"
    var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);

    var shadowWidth = 0;
    if (isFirefox || isSafari) {
			var shadowWidth = 0.0001;
    }


	var mainChart = new RadialProgressChart('#maternal-health', {
		diameter: 100,
		shadow: {
			width: shadowWidth
		},
		stroke:{
			width: 10,
			gap: 3
		},
		animation: {
			// duration: int (default: 1750),
			// delay: int (between each ring, default: 200)
			duration: 2000,
			delay: 300
		},
		min: 0,
		max: 100,
		series: [
			{
				labelStart: {{ $maternal_trend_analysis[0]['percent'] }} + '%', //Counselling Given
				value: {{ $maternal_trend_analysis[0]['percent'] }},
				color: '#81ddc6',
			},
			{
				labelStart: {{ $maternal_trend_analysis[1]['percent'] }} + '%', // IFA Distributed
				value: {{ $maternal_trend_analysis[1]['percent'] }},
				// color: '#008091',
				color: '#137f91',
			},
			{
				labelStart: {{ $maternal_trend_analysis[2]['percent'] }} + '%', // Weight Measured
				value: {{ $maternal_trend_analysis[2]['percent'] }},
				// color: "#0c4a60"
				color: "#005e6f"
			},
			{
				labelStart: {{ $maternal_trend_analysis[0]['percent'] }} + '%', //Exclusive Breastfeeding
				value: {{ $maternal_trend_analysis[0]['percent'] }},
				// color: '#004962',
				color: "#003d48"
			},
		],
		center: {
			content: [
			'', 'MATERNAL','NUTRITION'
			],
		}
	});
	  // for child health
<?php /* <<<<<<< HEAD
	   var mainChart = new RadialProgressChart('#child-health', {
	        diameter: 100,
	        shadow: {
	        	width: 0
	        },
	        stroke:{
	        	width: 13,
	        	gap: 3
	        },
	         animation: {
			        // duration: int (default: 1750),
			        // delay: int (between each ring, default: 200)
			        duration: 2000,
			        delay: 300

			    },
			    min: 0,
			    max: 100,
	        series: [
	          {
	          	labelStart: '', //IMCI Counselling Given
	          	value: 55,
	          	color: '#008091',
	        //   	color: {
					    //   linearGradient: {
					    //     x1: '0%',
					    //     y1: '0%',
					    //     x2: '100%',
					    //     y2: '100%',
					    //     spreadMethod: 'pad' // reflect, repeat, pad
					    //   },
					    //   stops: [{
					    //     offset: '0%',
					    //     'stop-color': '#fe08b5',
					    //     'stop-opacity': 1
					    //   }, {
					    //     offset: '100%',
					    //     'stop-color': '#000000',
					    //     'stop-opacity': 1
					    //   }]
					    // }
	          },
	          {
	          	labelStart: '', //Child Health
	          	value: 70,
	          	color: '#0c4a60',
	          },
	        ],
	        center: {
				    content: [
				    	'CHILD', 'HEALTH'],
				  }
	      }
	  );
  </script>
  {{-- radial progress end --}}
======= */ ?>
	  var mainChart = new RadialProgressChart('#child-health', {
	  	diameter: 100,
	  	shadow: {
	  		width: shadowWidth
	  	},
	  	stroke:{
	  		width: 10,
	  		gap: 3
	  	},
	  	animation: {
	        // duration: int (default: 1750),
	        // delay: int (between each ring, default: 200)
	        duration: 2000,
	        delay: 300

	    },
	    min: 0,
	    max: 100,
	    series: [
	    {
				labelStart: {{ $child_trend_analysis[0]['percent'] }} + '%', //IMCI Counselling Given
				value: {{ $child_trend_analysis[0]['percent'] }},
				color: '#81ddc6',
			},
			{
	  		labelStart: {{ $child_trend_analysis[1]['percent'] }} + '%', //Child Health
	  		value: {{ $child_trend_analysis[1]['percent'] }},
	  		color: '#137f91',
	  	},
	  	{
	  		labelStart: {{ $child_trend_analysis[0]['percent'] }} + '%', //Child Growth Monitoring
	  		value: {{ $child_trend_analysis[0]['percent'] }},
	  		color: '#005e6f'
	  	},
	  	{
	  		labelStart: {{ $child_trend_analysis[1]['percent'] }} + '%', //Minimum acceptable diet
	  		value: {{ $child_trend_analysis[1]['percent'] }},
	  		color: '#003d48'
	  	},
		],
		center: {
			content: [
				'', 'CHILD', 'NUTRITION'
			],
		}
	});

	</script>
	{{-- radial progress end --}}
{{-- >>>>>>> a1835801bf0f5809dc712799bb9b94300fef4d1c --}}
	<script>
		$('.slideTrigger').click(function(){
			TweenMax.staggerTo(".slideInContainer", 1, {left:'0', backgroundColor: "#CCC", ease:Power4.easeInOut});
		});
	</script>
	{{-- swiper js --}}
	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.2.6/js/swiper.min.js"></script> --}}
	<script src="{{asset('js/swiper.min.js')}}"></script>

	<!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper('.swiper-container', {
    	autoHeight: true, //enable auto height
      speed: 600,
      parallax: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  </script>

  <script>
  	const getMapData = (model, item, id) => {
  		$('.maplinks').removeClass('active').addClass('inactive');
      $(id).removeClass('inactive').addClass('active');
      console.log(model, item, id);
  		$.ajax({
	      type: 'get',
	      url: '/dashboard_specific_map',
	      data: {"model": model},
	      success: function (res) {
	      	console.log(res);
	      	if(res['dataExists']) {

						if(res['reverse']) {
							$('#low-text').html('Major Problem');
							$('#avg-text').html('Severe Problem');
							$('#high-text').html('Critical Problem');
						} else {
							$('#low-text').html('Critical Problem');
							$('#avg-text').html('Severe Problem');
							$('#high-text').html('Major Problem');
						}
	      		map = new google.maps.Map(document.getElementById('mapdiv'), {
			        center: {lat: 23.684994, lng: 90.356331},
			        zoom: 6.5,
			        scrollwheel: true,
			        styles: [{
												"featureType": "administrative",
												"elementType": "all",
												"stylers": [{
													"color": "#ededed"
												}]
											}, {
												"featureType": "administrative.province",
												"elementType": "all",
												"stylers": [{
													"color": "#ededed"
												}]
											}, {
												"featureType": "landscape",
												"elementType": "all",
												"stylers": [{
													"color": "#ededed"
												}]
											}, {
												"featureType": "poi",
												"elementType": "all",
												"stylers": [{
													"color": "#ededed"
												}]
											}, {
												"featureType": "road",
												"elementType": "all",
												"stylers": [{
													"color": "#ededed"
												}]
											}, {
												"featureType": "road.highway",
												"elementType": "all",
												"stylers": [{
													"color": "#ededed"
												}]
											}, {
												"featureType": "road.arterial",
												"elementType": "all",
												"stylers": [{
													"color": "#ededed"
												}]
											}, {
												"featureType": "road.local",
												"elementType": "all",
												"stylers": [{
													"color": "#ededed"
												}]
											}, {
												"featureType": "transit",
												"elementType": "all",
												"stylers": [{
													"color": "#ededed"
												}]
											}, {
												"featureType": "water",
												"elementType": "geometry",
												"stylers": [{
													"color": "#ededed"
												}]
											}, {
												"featureType": "water",
												"elementType": "labels",
												"stylers": [{
													"color": "#ededed"
												}]
											}],
			        zoomControl: true,
		          zoomControlOptions: {
		              position: google.maps.ControlPosition.LEFT_BOTTOM
		          },
		          scaleControl: true,
		          streetViewControl: true,
		          streetViewControlOptions: {
		              position: google.maps.ControlPosition.LEFT_BOTTOM
		          },
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
							var ids = feature.getProperty('ids').split('-');
							var id = ids[0];
							if(res['server'] == 'community')
								id = ids[1];
							value = res['minimalData'][id];
							var localColor = '';
							if(value >= parseInt(res['min']) && value < parseInt(res['q1'])) {
								localColor = scoreColors['low'];
							} else if(value >= parseInt(res['q1']) && value < parseInt(res['q2'])) {
								localColor = scoreColors['average'];
							} else if(value >= parseInt(res['q2']) && value <= parseInt(res['max'])) {
								localColor = scoreColors['high'];
							}
							color = feature.getProperty('color');
							return {
								fillColor: localColor,
								fillOpacity: 1,
								strokeColor: '#fff',
								strokeWeight: 1.5,
								zIndex: 1
							};
						});

						// Add mouseover and mouse out styling for the GeoJSON State data
						stateLayer.addListener('mouseover', function(e) {
							ids = e.feature.getProperty('ids').split('-');
							id = ids[0];
							if(res['server'] == 'community')
								id = ids[1];
							value = res['minimalData'][id];
							console.log(value);
							infoWindow.setContent('<div style="line-height::;.00;overflow:hidden;white-space:nowrap;">' + e.feature.getProperty('name') + '<br />' + res['text'] + '<span class="map-text">' + parseInt(value) + '</span>' + '</div>');
							var anchor = new google.maps.MVCObject();
				    	anchor.set("position", e.latLng);
				    	infoWindow.open(map, anchor);
							stateLayer.overrideStyle(e.feature, {
								// fillColor: e.feature.getProperty('color'),
								strokeColor: '#000',
								// strokeColor: e.feature.getProperty('color'),
								strokeWeight: 2,
								zIndex: 2
							});
						});

						stateLayer.addListener('mouseout', function(e) {
							stateLayer.overrideStyle(e.feature, {
								strokeColor: '#fff',
								strokeWeight: 1.5,
								zIndex: 1
							});
						});

		        // Final step here sets the stateLayer GeoJSON data onto the map
						stateLayer.setMap(map);
	      	}else{

	      	}

	      },
	      error: function(res) {
	        console.log('failed')
	      }
	  	});
  	}
  </script>
@endsection
