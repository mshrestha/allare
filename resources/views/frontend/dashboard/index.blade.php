@extends('layouts.app')

@section('content')
	<div class="container">
		<!-- Slider main container -->
		<div class="swiper-container">
			<div class="swiper-wrapper">
				<div class="swiper-slide container dataview">
			  	<div class="row">
			      	<div class="output-col col-md-7 col-lg-8 pb-3">
			      		<div class="row"  data-swiper-parallax="-300" data-swiper-parallax-opacity="0">
			      			<div class="col-sm-12">
			      				<div class="box-heading float-left outputs-heading">NATIONAL OUTPUTS</div>
			      				<div class="view-on-map float-right swiper-button-next">VIEW ON MAP</div>
			      			</div>
			      		</div> {{-- row --}}
			      		<div class="row">
			      			<div class="col-sm-6" data-swiper-parallax="0" data-swiper-parallax-opacity="0">
			      				<div id="maternal-health" style="width: 100%;"></div>
			      				<div class="legend row">
			      					<div class="dashboard-legend conselling-given col-12 col-md-10 offset-lg-2 offset-md-2 offset-xs-2">Percent of pregnant women counselled on maternal nutrition</div>
			      					<div class="ifa-distributed dashboard-legend col-12 col-md-10 offset-lg-2 offset-md-2 offset-xs-2">Percent of pregnant women who received IFA</div>
			      					<div class="weight-measured dashboard-legend col-12 col-md-10 offset-lg-2 offset-md-2 offset-xs-2">Percent of pregnant women weighed at facility visits</div>
			      					{{-- <div class="weight-measured col-12 col-md-10 offset-lg-2 offset-md-2 offset-xs-2">Increase in Exclusive Breastfeeding</div> --}}
			      				</div> {{-- legend --}}
			      			</div>
			      			<div class="col-sm-6"  data-swiper-parallax="-200" data-swiper-parallax-opacity="0">
			      				<div id="child-health" style="width: 100%;"></div>
			      				<div class="legend row">
			      					<div class="imci-counselling dashboard-legend col-12 col-md-10 offset-lg-2 offset-md-2 offset-xs-2">Percent of caretakers of 6-23 month olds counselled on IYCF</div>
			      					{{-- <div class="supplements-distributed col-12 col-md-10 offset-lg-2 offset-md-2 offset-xs-2">Supplements Distributed</div> --}}
			      					<div class="child-growth dashboard-legend col-12 col-md-10 offset-lg-2 offset-md-2 offset-xs-2">Percent of children 6-23 months old weighed at facilities</div>
			      					{{-- <div class="child-growth col-12 col-md-10 offset-lg-2 offset-md-2 offset-xs-2">Increase in minimum acceptable diet</div> --}}
			      				</div> {{-- legend --}}
			      			</div>
			      		</div> {{-- row --}}

			      		<form action="{{ route('frontend.dashboard.circular-chart') }}" id="national_outcomes_filter_form">
				      		<div class="row mt-2">
				      			<div class="col-12 col-sm-6 col-md-6 col-lg-4 offset-lg-1 pl-lg-0 geo-filter-wrap" data-swiper-parallax="0" data-swiper-parallax-opacity="0">
				      				<label for="">Select by Geography</label>
					      			<div class="input-group">
						                <select class="custom-select national_outcomes_filter_form_fields country_division_field" id="division_id" name="organisation_unit" required>
						                	<option value="dNLjKwsVjod.dNLjKwsVjod">Bangladesh</option>
						                	@foreach($organisation_units as $organisation_unit)
							                	@if($organisation_unit->name !== 'X organizationunits for delete')
							                    	<option value="{{ $organisation_unit->central_api_id .'.'. $organisation_unit->community_api_id}}">{{ $organisation_unit->name }}</option>
							                    	@if($organisation_unit->name == 'Barisal Division')
							                    		<option class="pl-5" value="xNcsJeRMUCM.xNcsJeRMUCM">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Barguna District</option>
							                    		<option class="pl-5" value="uOU0jtyD1PZ.uOU0jtyD1PZ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Barisal District</option>
							                    		<option class="pl-5" value="EdOWA8sKh2p.EdOWA8sKh2p">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bhola District</option>
							                    		<option class="pl-5" value="WNCBZLbFD70.WNCBZLbFD70">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jhalokati District</option>
							                    		<option class="pl-5" value="bEiL5HnmKZO.bEiL5HnmKZO">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Patuakhali District</option>
							                    		<option class="pl-5" value="aLbPgj33QnT.aLbPgj33QnT">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pirojpur District</option>
							                    	@endif
						                    	@endif
						                    @endforeach
						                </select>
						            </div>
				      			</div>
				      			<div class="col-12 col-sm-6 col-md-6 col-lg-4 offset-lg-2 pl-lg-0" data-swiper-parallax="-200" data-swiper-parallax-opacity="0">
				      				<label for="">Select the Timeline</label>
					      			<div class="input-group">
						                <select class="custom-select national_outcomes_filter_form_fields" id="period_id" name="period" required>
						                    @foreach($periods as $key => $period)
						                    	<option value="{{ $period }}">{{ $period }}</option>
						                    @endforeach
						                </select>
						            </div>
				      			</div>
				      		</div> {{-- row --}}
			      		</form>
			      		<div class="impact-div outcome-col">
				      		<div class="row">
				      			<div class="col-12">
				      				<div class="box-heading float-left">IMPACT</div>
				      			</div>
				      		</div>
				      		<div class="row">
				  				@foreach($outcomes as $key => $analysis)
									@include('layouts.partials.dashboard-outcomes-partial')
								@endforeach
				      		</div>
			      		</div>
			      	</div> {{-- output col-md-8 --}}
			      	<div class="col-md-5 col-lg-4 outcome-col" data-swiper-parallax="-300" data-swiper-parallax-opacity="0">
			      		<div class="input-wrapper">
				      		<div class="row">
				      			<div class="col-12">
				      				<div class="box-heading float-left">INPUTS</div>
				      			</div>
				      		</div>
				      		<div class="reporting-div input-box input-reporting">
				      			<h6>FACILITY REPORTING RATES</h6>
				      			<div class="row">
				      				<div class="col-sm-6">
				      					<div>
									  			<span class="report-lable">FWC</span> 
									  			<div class="progress-bar-h">
														<div class="goal" style="width: 10%;">
														</div>
														<div class="input-bars current grow-h-animation-" style="width: 73%;">
															<span>73%</span>
														</div>
													</div> {{-- progress-bar-h --}}
												</div>
				      				</div>
				      				<div class="col-sm-6">
				      					<div>
									  			<span class="report-lable">CC</span> 
									  			<div class="progress-bar-h">
														<div class="goal" style="width: 10%;">
														</div>
														<div class="input-bars current grow-h-animation-" style="width: 70%;">
															<span>70%</span>
														</div>
													</div> {{-- progress-bar-h --}}
												</div>
				      				</div>
				      			</div>
				      			<div class="row">
				      				<div class="col-sm-6">
				      					<div>
									  			<span class="report-lable">IMCI-N Corner</span> 
									  			<div class="progress-bar-h">
														<div class="goal" style="width: 10%;">
														</div>
														<div class="input-bars current grow-h-animation-" style="width: 68%;">
															<span>68%</span>
														</div>
													</div> {{-- progress-bar-h --}}
									  		</div>
				      				</div>
				      				<div class="col-sm-6">
				      					<div>
									  			<span class="report-lable">SAM</span> 
									  			<div class="progress-bar-h">
														<div class="goal" style="width: 10%;">
														</div>
														<div class="input-bars current grow-h-animation-" style="width: 61%;">
															<span>61%</span>
														</div>
													</div> {{-- progress-bar-h --}}
												</div>
				      				</div>
				      			</div>
				      		</div>

				      		{{-- CAPACITY DIV --}}
				      		<div class="capacity-div input-box input-training">
				      			<h6 class="mb-0">ENHANCED CAPACITY OF PLANNERS AND SERVICE PROVIDERS</h6>
							  		<div><span class="number">65%</span><span class="number-txt"># of health workers trained on CCTN with Pay for performance </span></div>
							  		<div><span class="number">60%</span><span class="number-txt"># of health workers who passed the training uptake assessment</span></div>
				      		</div>
				      		{{-- QA DIV --}}
				      		<div class="qa-div input-box input-training">
				      			<h6 class="mb-0">QUALITY CONTROL AND SUPPORTIVE SUPERVISION</h6>
				      			<div><span class="number">63%</span><span class="number-txt"># of facilities receiving supporting supervision and monitoring in the last quarter</span></div>
							  		{{-- <div><span class="number">70%</span><span class="number-txt">% of facilties reporting high quality data </span></div> --}}
							  		<div><span class="number">67%</span><span class="number-txt">% of facilities passing the Data Quality Assessment</span></div>
				      		</div>
				      		{{-- SUPPLY DIV --}}
				      		<div class="supply-div input-box input-training">
				      			<h6 class="mb-0">ENSURE ADEQUATE NUTRITION SUPPLIES</h6>
				      			<div><span class="number">61%</span><span class="number-txt">% of facilities without stockouts of IFA tablets</span></div>
							  		<div><span class="number">69%</span><span class="number-txt">% of facilities with adequate anthropometric measuring tools</span></div>
							  		<div><span class="number">64%</span><span class="number-txt">% of facilities without stockouts of Zinc and ORS</span></div>
				      		</div>
				      		{{-- <div class="spider-graph-div input-box input-training">
				      			<h6 class="mb-0">SPIDER GRAPH</h6>
				      			<div><img id="spider-graph-img" class="img" src="http://via.placeholder.com/350x250" alt=""></div>
				      		</div> --}}
				      	</div>
			      	</div> {{-- col-md-4 --}}
			  	</div>
			  </div> {{-- data view --}}
			  <div class="swiper-slide container map-view-container">
			    <div class="row justify-content-between">
			    	<div class="col-6 col-md-4 col-lg-3 col-xl-2 pr-0 pl-0 d-block">
						<div class="box-heading float-left d-block ml-0">OUTPUTS</div>
					</div>
			    	<div class="col-md-2 col-6">
						<div class="view-on-map float-right swiper-button-prev">VIEW DASHBOARD</div>
					</div>
			    </div>
			    <div class="row">
			    	<div class="col-md-4 col-lg-3 col-xl-2 pl-0 pr-0 filter-col">
							<ul class="map-filter mb-0">
								<li class="list-head">MATERNAL NUTRITION</li>
									<li><a href="#" id="counselling" class="maplinks active" onclick="getMapData('CcMrAncNutriCounsel', 'Counselling Given', '#counselling', 'Women counselled on Maternal Nutrition')">Women counselled on Maternal Nutrition</a></li>
									<li><a href="#" id="ifadistribution" class="maplinks inactive" onclick="getMapData('CcMrAncIfaDistribution', 'IFA Distributed', '#ifadistribution', 'Pregnant Woman who received IFA')">Pregnant Woman who received IFA</a></li>
									<li><a href="#" id="ancweight" class="maplinks inactive" onclick="getMapData('CcMrWeightInKgAnc', 'Weight Measured', '#ancweight', 'Pregnant women weighed during facility visits')">Pregnant women weighed during facility visits</a></li>
									<li class="list-head">CHILD NUTRITION</li>
									<li><a href="#" id="imcicounselling" class="maplinks inactive" onclick="getMapData('ImciCounselling', 'IMCI Counselling Given', '#imcicounselling', 'Caregivers counselled on IYCF')">Caregivers counselled on IYCF</a></li>
									<li><a href="#" id="supplements" class="maplinks inactive" onclick="getMapData('CcCrAdditionalFoodSupplimentation', 'Supplements Distributed', '#supplements', 'Children 0-23 months weighed during facility visit')">Children 0-23 months weighed during facility visit</a></li>

							</ul>


							<ul class="map-filter outcome mb-0">
								<li class="list-head green">IMPACTS</li>
								<li><a href="#" id="stunting" class="maplinks inactive" onclick="getMapData('BdhsStunting', 'STUNING', '#stunting', 'STUNTING')">STUNTING</a></li>
								{{-- <li class="list-head" id="stunting" class="maplinks inactive" onclick="getMapData('ImciStunting', 'STUNING', '#stunting')">STUNTING</li> --}}
								<li><a href="#" id="wasting" class="maplinks inactive" onclick="getMapData('BdhsWasting', 'WASTING', '#wasting', 'WASTING')">WASTING</a></li>
								<li><a href="#" id="anemia" class="maplinks inactive" onclick="getMapData('BdhsAnemia', 'Anemia', '#anemia', 'ANEMIA')">ANEMIA</a></li>
								<li><a href="#" id="bmi" class="maplinks inactive" onclick="getMapData('BdhsBmi', 'WOMEN UNDERWEIGHT', '#bmi', 'WOMEN UNDERWEIGHED')">WOMEN UNDERWEIGHT</a></li>
	    				</ul>
	    				<ul class="map-filter mb-0">
								<li class="list-head">INTERMEDIATE OUTCOMES</li>
								<li><a href="#" id="exclusive_breastfeeding" class="maplinks inactive" onclick="getMapData('CcCrExclusiveBreastFeeding', 'Exclusive Breastfeeding', '#exclusive_breastfeeding', 'Exclusive Breastfeeding'
								)">Exclusive Breastfeeding</a></li>
								<li><a href="#" id="min_acceptable_diet" class="maplinks inactive">Min. Acceptable diet</a></li>
	    				</ul>
	    			</div>
	    			<div class="col-md-8 col-lg-9 col-xl-10 pl-0 pr-0 col-map">
	    				<div class="map-title d-block ml-0" id="map-title"></div>
	    				<div class="map-hint d-block ml-0 " id="map-hint-id">
	    					<p>Click on Barisal division for detailed district data<p>
	    				</div>
	    				<div id="mapdiv" class="swiper-no-swiping map-wrapper" style="width: 100%;">
	    					<div id="zoomctrl">
						    </div>
							</div>
							<div id="overdiv">
								<span class="legend-text" id="low-text"></span>
								<span class="legend-text" id="avg-text"></span>
								<span class="legend-text" id="high-text"></span>
								<span class="legend-text" id="vhigh-text"></span>
							</div>
						</div>
			    </div>
			  </div> <!-- swiper-slide -->
			</div> <!-- swiper-wrrapper -->
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="col-12 col-md-offset-2 col-md-10">
					<div class="barchart-title d-block ml-0" id="barchart-title-id"></div>
					<div class="canvas-holder score-bar-chart" id="chartID">
					</div>
				</div>
			</div>
			
			<!-- Add Pagination -->
			<div class="swiper-pagination swiper-pagination-white"></div>
			<!-- Add Navigation -->
			<div class="swiper-button-prev swiper-button-white"></div>
			<div class="swiper-button-next swiper-button-white"></div>
		</div> {{-- swiper-container --}}
	</div> {{-- container --}}
</div>
@endsection


@section('outjavascript')
	<script src="{{ asset('js/Chart.PieceLabel.min.js') }}"></script>
	<script src="{{asset('js/swiper.min.js')}}"></script>
	<script src="{{asset('js/TweenMax.min.js')}}"></script>
	<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkyw2RR6Cy0hsAOE4-um5lZg5TV6c8bbQ&callback=initMap">
	</script>

	<script>
	  window.onload = function() {
	  	var aniamteEl = $('.input-bars.current');
  		var aniamteElChild = $('.input-bars.current span');

  		TweenMax.from(aniamteEl, 1, {css: {width: '0%'}, delay:0.8});
  		TweenMax.from(aniamteElChild, 0.5, {css: {opacity: '0', x: '-10px'}, delay:1.3});
	  }
		scoreColors = {"very high": "#0b495e", "high": "#137f91", "average": "#81ddc5", "low": "#b1eed5"};
		districtScoreColor = {"very high": "#ea5c58", "high": "#eea039", "average": "#f7e15a", "low": "#f0c4b6"}
		var barisalClicked = false;
		document.getElementById('barchart-title-id').style.visibility = 'hidden';
	</script>

	<script>

	$('.national_outcomes_filter_form_fields').on('change', function() {
		$('#national_outcomes_filter_form').submit();	
	})

	$('.country_division_field').on('change', function() {
		if($(this).val() == 'dNLjKwsVjod.dNLjKwsVjod') {
			$('.outputs-heading').html('NATIONAL OUTPUTS');
		} else {
			$('.outputs-heading').html($('.country_division_field :selected').text() + ' OUTPUTS');
		}
	})

  	$('#national_outcomes_filter_form').on('submit', function() {

  		var aniamteEl = $('.input-bars.current');
  		var aniamteElChild = $('.input-bars.current span');

  		TweenMax.from(aniamteEl, 1, {css: {width: '0%'}, delay:0.7});
  		TweenMax.from(aniamteElChild, 0.5, {css: {opacity: '0', x: '-10px'}, delay:1.2});

  		// if($('.input-bars').hasClass('grow-h-animation')) {
  		// 	$('.input-bars').removeClass('grow-h-animation');	
  		// }
  		// $('.input-bars').addClass('grow-h-animation');

  		// var imageDiction = {"bangladesh": "", "barisal division": "", "barisal district": "", "barguna": "", "bhola": "", "jhalokati": "","patuakhali": "", "pirojpur": "", "chittagong": "", "dhaka": "", "khulna": "", "mymensingh": "", "rajshahi": "", "rangpur": "", "sylhet": ""};
  		// var divisions_id = $('#division_id option:selected').text();
  		// for(var key in imageDiction) {
  		// 	if(divisions_id.toLowerCase().match(key) != null) {
  		// 		console.log(divisions_id, key);
  		// 	}
  		// }

  		
  		$.ajax({
  			type: $(this).attr('method'),
  			url: $(this).attr('action'),
  			data: $(this).serialize(),
  			success: function (res) {
  				// console.log(res)
  				$('#maternal-health').html('');
  				$('#child-health').html('');

  				curcularCharts(
			    	res[0].maternal_nutrition_counseling,
			    	res[0].ifa_distribution,
			    	res[0].weight_measured,
			    	res[0].exclusive_breastfeeding,
			    	res[1].iycf_counselling,
			    	res[1].supplements_distributed,
			    	res[1].child_growth_monitoring,
			    	res[1].minimum_acceptable_diet,
			    );
			    if($('.input-bars').hasClass('grow-h-animation')) {
		  			$('.input-bars').removeClass('grow-h-animation');	
		  		}

  			}
  		})
  		return false;
  	})

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
	  $('#zoomctrl').html('');
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
    	model = "CcMrAncNutriCounsel";
    	if(model == 'CcMrAncNutriCounsel' || model == 'CcMrAncIfaDistribution') {
    		setTimeout(function(){
			    document.getElementById('map-hint-id').classList.add('slowhide');
				}, 2000);
    	}
			$.ajax({
	      type: 'get',
	      url: '/dashboard_specific_map',
	      data: {"model": model},
	      success: function (res) {
	      	// console.log(res);
	      	if(res['dataExists']) {
		      	if(model == 'BdhsStunting' || model == 'BdhsWasting' || model == 'BdhsBmi') {
		      		$('#low-text').html('Low');
							$('#avg-text').html('Medium');
							$('#high-text').html('High');
							$('#vhigh-text').html('Very High');
		      	} else if(model == 'BdhsAnemia') {
		      		$('#low-text').html('None');
							$('#avg-text').html('Mild');
							$('#high-text').html('Moderate');
							$('#vhigh-text').html('Severe');
		      	} else {
		      		$('#low-text').html('Very High');
							$('#avg-text').html('High');
							$('#high-text').html('Medium');
							$('#vhigh-text').html('Low');
		      	}
						$('#map-title').html("Women counselled on Maternal Nutrition")
						$('#map-title').show();
	      		map = new google.maps.Map(document.getElementById('mapdiv'), {
			        center: {lat: 23.684994, lng: 90.356331},
			        zoom: 7,
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
						var anotherLayer = new google.maps.Data();
						var stateLayer = new google.maps.Data();
						
						anotherLayer.loadGeoJson("{{asset('js/barisal.geojson')}}");
						stateLayer.loadGeoJson("{{asset('js/test_complete.json')}}");
						var clicked = false;
						stateLayer.setStyle(function(feature) {
							var localColor = '#ededed';
							// if(feature.getProperty('name') != 'Barisal Division') {
								var ids = feature.getProperty('ids').split('-');
								var id = ids[0];
								if(res['server'] == 'community')
									id = ids[1];
								var value = parseInt(res['minimalData'][id]).toFixed(1);
								var localColor = '';
								if(model == 'BdhsStunting' || model == 'BdhsWasting' || model == 'BdhsAnemia' || model == 'BdhsBmi') {
									if(value >= parseFloat(res['ranges']['min']).toFixed(1) && value < parseFloat(res['ranges']['q1']).toFixed(1)){
										localColor = scoreColors['low'];
									} else if(value >= parseFloat(res['ranges']['q1']).toFixed(1) && value < parseFloat(res['ranges']['q2']).toFixed(1)) {
										localColor = scoreColors['average'];
									} else if(value >= parseFloat(res['ranges']['q2']).toFixed(1) && value < parseFloat(res['ranges']['q3']).toFixed(1)) {
										localColor = scoreColors['high'];
									} else if(value >= parseFloat(res['ranges']['q3']).toFixed(1)) {
										localColor = scoreColors['very high'];
									}
								}else {
									// console.log(res['ranges'], value);
									if(value >= parseInt(res['ranges']['min']) && value < parseInt(res['ranges']['q1'])){
										localColor = scoreColors['very high'];
									} else if(value >= parseInt(res['ranges']['q1']) && value < parseInt(res['ranges']['q2'])) {
										localColor = scoreColors['high'];
									} else if(value >= parseInt(res['ranges']['q2']) && value < parseInt(res['ranges']['q3'])) {
										localColor = scoreColors['average'];
									} else if(value >= parseInt(res['ranges']['q3'])) {
										localColor = scoreColors['low'];
									}
								}	
							// }
							
							// color = feature.getProperty('color');
							return {
								fillColor: localColor,
								fillOpacity: 1,
								strokeColor: '#fff',
								strokeWeight: 1.5,
								zIndex: 1
							};
						});

						anotherLayer.setStyle(function(feature) {
							var localColor = feature.getProperty('color');
							var ids = feature.getProperty('ids').split('-');
							var id = ids[0];
							if(res['server'] == 'community')
								id = ids[1];
							var value = parseInt(res['minimalData'][id]);
							// console.log(value, res['districtRanges']['min'], res['districtRanges']['q1'], res['districtRanges']['q2']);
							localColor = districtScoreColor['low'];
							if(!res['emptydistricts']) {
								if(value >= parseFloat(res['districtRanges']['min']).toFixed(1) && value < parseFloat(res['districtRanges']['q1']).toFixed(1)) {
									localColor = districtScoreColor['very high'];
								} else if(value >= parseFloat(res['districtRanges']['q1']).toFixed(1) && value < parseFloat(res['districtRanges']['q2']).toFixed(1)) {
									localColor = districtScoreColor['high'];
								} else if(value >= parseFloat(res['districtRanges']['q2']).toFixed(1)) {
									localColor = districtScoreColor['average'];
								} 
							}
															
							return {
								fillColor: localColor,
								fillOpacity: 1,
								strokeColor: '#fff',
								strokeWeight: 1.5,
								zIndex: 3
							};
						});

						// Add mouseover and mouse out styling for the GeoJSON State data
						stateLayer.addListener('mouseover', function(e) {
							if(clicked){
								if(e.feature.getProperty('name') == 'Barisal Division') {
									ids = e.feature.getProperty('ids').split('-');
									id = ids[0];
									if(res['server'] == 'community')
										id = ids[1];
									value = res['minimalData'][id];
									if(isNaN(value))
										value = 'N/A';
									else
										value = parseFloat(res['minimalData'][id]).toFixed(1);
									if(model == 'BdhsStunting' || model == 'BdhsWasting' || model == 'BdhsAnemia' || model == 'BdhsBmi')
										value += '%';
									infoWindow.setContent('<div style="line-height:1.00;overflow:hidden;white-space:nowrap;">' + e.feature.getProperty('name') + '<br />' + res['text'] + '<span class="map-text">' + value + '</span>' + '</div>');
									var anchor = new google.maps.MVCObject();
						    	anchor.set("position", e.latLng);
						    	infoWindow.open(map, anchor);
									stateLayer.overrideStyle(e.feature, {
										strokeColor: '#000',
										strokeWeight: 1,
										zIndex: 2
									});
								}
							} else {
								ids = e.feature.getProperty('ids').split('-');
								id = ids[0];
								if(res['server'] == 'community')
									id = ids[1];
								value = res['minimalData'][id];
								if(isNaN(value))
									value = 'N/A';
								else
									value = parseFloat(res['minimalData'][id]).toFixed(1);

								if(model == 'CcMrAncNutriCounsel' || model == 'CcMrAncIfaDistribution' || model == 'ImciCounselling' || model == 'BdhsStunting' || model == 'BdhsWasting' || model == 'BdhsAnemia' || model == 'BdhsBmi') {
									if(value != 'N/A') {
										value += "%";
									}
								}
								// value = res['minimalData'][id];
								infoWindow.setContent('<div style="line-height:1.00;overflow:hidden;white-space:nowrap;">' + e.feature.getProperty('name') + '<br />' + res['text'] + '<span class="map-text">' + value + '</span>' + '</div>');
								var anchor = new google.maps.MVCObject();
					    	anchor.set("position", e.latLng);
					    	infoWindow.open(map, anchor);
								stateLayer.overrideStyle(e.feature, {
									// fillColor: e.feature.getProperty('color'),
									strokeColor: '#000',
									// strokeColor: e.feature.getProperty('color'),
									strokeWeight: 1,
									zIndex: 2
								});
							}	
						});

						anotherLayer.addListener('mouseover', function(e) {
							ids = e.feature.getProperty('ids').split('-');
							id = ids[0];
							if(res['server'] == 'community')
								id = ids[1];
							value = res['minimalData'][id];
							if(isNaN(value))
								value = 'N/A';
							else {
								value = parseFloat(value).toFixed(1);
								value += "%";
							}

							if(res['emptydistricts'] && value == 0) {
								value = 'N/A';
							}

							infoWindow.setContent('<div style="line-height:1.00;overflow:hidden;white-space:nowrap;">' + e.feature.getProperty('name') + '<br />' + res['text'] + '<span class="map-text">' + value + '</span>' + '</div>');
							var anchor = new google.maps.MVCObject();
				    	anchor.set("position", e.latLng);
				    	infoWindow.open(map, anchor);
							anotherLayer.overrideStyle(e.feature, {
								strokeColor: '#000',
								strokeWeight: 1,
								zIndex: 5
							});
							
						});

						stateLayer.addListener('click', function(e) {
							if(model == 'BdhsStunting' || model == 'BdhsWasting' || model == 'BdhsAnemia' || model == 'BdhsBmi') {
							} else {
								if(e.feature.getProperty('name') == 'Barisal Division') {
									var bounds = new google.maps.LatLngBounds();
							    processPoints(e.feature.getGeometry(), bounds.extend, bounds);
							    map.fitBounds(bounds);
							    stateLayer.overrideStyle(e.feature, {
										fillColor: '#ededed',
										strokeColor: '#ededed',
										// strokeColor: e.feature.getProperty('color'),
										strokeWeight: 1,
										zIndex: 1
									});
									// console.log(res);
									anotherLayer.setMap(map);

									if(model == 'CcMrAncIfaDistribution' || model == 'CcMrAncNutriCounsel' || model == 'ImciCounselling') {
										$('#barchart-title-id').html("Women counselled on Maternal Nutrition in Barisal Division");
										document.getElementById('barchart-title-id').style.visibility = 'visible';
										barisalClicked = true;
										$('#chartID').html('');
										$('#chartID').show();
										$('html,body').animate({
							        scrollTop: $("#chartID").offset().top},
							        'slow');
										var max = 0;
										var dataCSV = [];
										for(var key in res['minimalDistrict']) {
											temp = {};
											temp.id = key;
											temp.value = res['minimalDistrict'][key];
											if(max < temp.value)
												max = temp.value;
											dataCSV.push(temp);
										}
										
										parentDiv = document.getElementById('chartID');
									  var margin = {top:20, right:20, bottom:20, left:20};

										var width = parentDiv.clientWidth - margin.left - margin.right;

										var height = 185;
										var xScale = d3.scale.ordinal().rangeRoundBands([0, width], .03)

										var yScale = d3.scale.linear()
										      .range([height, 0]);


										var xAxis = d3.svg.axis()
												.scale(xScale)
												.orient("bottom");
										      
										      
										var yAxis = d3.svg.axis()
												.scale(yScale)
												.orient("left");

										var svgContainer = d3.select("#chartID").append("svg")
												.attr("width", width+margin.left + margin.right)
												.attr("height",height+margin.top + margin.bottom)
												.append("g").attr("class", "container")
												.attr("transform", "translate("+ margin.left +","+ margin.top +")");

										xScale.domain(dataCSV.map(function(d) { return d.id; }));
										yScale.domain([0, d3.max(dataCSV, function(d) { return parseFloat(d.value).toFixed(1); })]);


										//xAxis. To put on the top, swap "(height)" with "-5" in the translate() statement. Then you'll have to change the margins above and the x,y attributes in the svgContainer.select('.x.axis') statement inside resize() below.
										var xAxis_g = svgContainer.append("g")
												.attr("class", "x axis")
												.attr("transform", "translate(0," + (height) + ")")
												.call(xAxis)
												.selectAll("text");
													
										// Uncomment this block if you want the y axis
										/*var yAxis_g = svgContainer.append("g")
												.attr("class", "y axis")
												.call(yAxis)
												.append("text")
												.attr("transform", "rotate(-90)")
												.attr("y", 6).attr("dy", ".71em")
												//.style("text-anchor", "end").text("Number of Applicatons"); 
										*/
										// console.log(res);

										svgContainer.selectAll(".bar")
									  		.data(dataCSV)
									  		.enter()
									  		.append("rect")
									  		.attr("class", function(d) {
									  			if(parseInt(d.value) >= parseFloat(res['districtRanges']['min']).toFixed(1) && parseInt(d.value) < parseFloat(res['districtRanges']['q1']).toFixed(1)) {
														return 'bar vhigh';
													} else if(parseInt(d.value) >= parseFloat(res['districtRanges']['q1']).toFixed(1) && parseInt(d.value) < parseFloat(res['districtRanges']['q2']).toFixed(1)) {
														return 'bar high';
													} else if(parseInt(d.value) > parseFloat(res['districtRanges']['q2']).toFixed(1)) {
														return 'bar mid';
													}
									  		})
									  		.attr("x", function(d) { return xScale(d.id); })
									  		.attr("width", xScale.rangeBand())
									  		.attr("y", function(d) { return yScale(d.value); })
									  		.attr("height", function(d) { return height - yScale(d.value); });
									  svgContainer.selectAll(".text")  		
											  .data(dataCSV)
											  .enter()
											  .append("text")
											  .attr("class","label")
											  .attr("x", (function(d) { return xScale(d.id) + xScale.rangeBand() / 2 ; }  ))
											  .attr("y", function(d) { return yScale(d.value) - 15; })
											  .attr("dy", ".75em")
											  .text(function(d) { return parseFloat(d.value).toFixed(1)+"%"; });

										document.addEventListener("DOMContentLoaded", resize);
										d3.select(window).on('resize', resize);
										
										function resize() {
										  width = parseInt(d3.select('#chartID').style('width'), 10);
										  width = parseInt(width - margin.left - margin.right);

										  height = parseInt(d3.select("#chartID").style("height"));
										  height = parseInt(height - margin.top - margin.bottom);
										    xScale.range([0, width]);
										    xScale.rangeRoundBands([0, width], .03);
										    yScale.range([height, 0]);

										    yAxis.ticks(Math.max(height/50, 2));
										    xAxis.ticks(Math.max(width/50, 2));

										    d3.select(svgContainer.node().parentNode)
										        .style('width', (width + margin.left + margin.right) + 'px');

										    svgContainer.selectAll('.bar')
										    	.attr("x", function(d) { return xScale(d.id); })
										      .attr("width", xScale.rangeBand());
										      
										   svgContainer.selectAll("text")  		
											 .attr("x", (function(d) { if(isNaN(xScale(d.id	) + xScale.rangeBand() / 2)) return 0; else return xScale(d.id	) + xScale.rangeBand() / 2 ; }  ))
										      .attr("y", function(d) { if(isNaN(yScale(parseFloat(d.value).toFixed(1)) - 15)) return 0; return yScale(parseFloat(d.value).toFixed(1)) - 15; })
										      .attr("dy", ".75em");   	      

										    svgContainer.select('.x.axis').call(xAxis.orient('bottom')).selectAll("text").attr("y",10).call(wrap, xScale.rangeBand());
										}

										function wrap(text, width) {
										  text.each(function() {
										    var text = d3.select(this),
										        words = text.text().split(/\s+/).reverse(),
										        word,
										        line = [],
										        lineNumber = 0,
										        lineHeight = 1.1, // ems
										        y = text.attr("y"),
										        dy = parseFloat(text.attr("dy")).toFixed(1),
										        tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y).attr("dy", dy + "em");
										    while (word = words.pop()) {
										      line.push(word);
										      tspan.text(line.join(" "));
										      if (tspan.node().getComputedTextLength() > width) {
										        line.pop();
										        tspan.text(line.join(" "));
										        line = [word];
										        tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
										      }
										    }
										  });
										}
									}
								}
							}
						});

						stateLayer.addListener('mouseout', function(e) {
							stateLayer.overrideStyle(e.feature, {
								strokeColor: '#fff',
								strokeWeight: 1.5,
								zIndex: 1
							});
						});

						anotherLayer.addListener('mouseout', function(e) {
							anotherLayer.overrideStyle(e.feature, {
								strokeColor: '#fff',
								strokeWeight: 1.5,
								zIndex: 3
							});
						});

						stateLayer.setMap(map);
	      	}else{

	      	}

	      },
	      error: function(res) {
	        console.log('failed')
	      }
	  	});
	}

	
	function processPoints(geometry, callback, thisArg) {
		if (geometry instanceof google.maps.LatLng) {
		  callback.call(thisArg, geometry);
		} else if (geometry instanceof google.maps.Data.Point) {
		  callback.call(thisArg, geometry.get());
		} else {
		  geometry.getArray().forEach(function(g) {
		    processPoints(g, callback, thisArg);
		  });
		}
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

	
	{{-- radial progress --}}
	<script>
		// new RadialProgressChart('#maternal-health', {series: [24, 85]});
		// new RadialProgressChart('#child-health', {series: [24, 85]});

	    // Firefox 1.0+
	    curcularCharts(
	    	{{ $maternal_nutrition_data['maternal_nutrition_counseling'] }},
	    	{{ $maternal_nutrition_data['ifa_distribution'] }},
	    	{{ $maternal_nutrition_data['weight_measured'] }},
	    	{{ $maternal_nutrition_data['exclusive_breastfeeding'] }},
	    	{{ $child_nutrition_data['iycf_counselling'] }},
	    	{{ $child_nutrition_data['supplements_distributed'] }},
	    	{{ $child_nutrition_data['child_growth_monitoring'] }},
	    	{{ $child_nutrition_data['minimum_acceptable_diet'] }},
	    );

	    function curcularCharts(maternal_nutrition_counseling, ifa_distribution, weight_measured, exclusive_breastfeeding, iycf_counselling, supplements_distributed, child_growth_monitoring, minimum_acceptable_diet) {
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
						labelStart: ~~maternal_nutrition_counseling + '%', //maternal_nutrition_counseling
						value: maternal_nutrition_counseling,
						color: '#eea039',
					},
					{
						labelStart: ~~ifa_distribution + '%', // IFA Distributed
						value: ifa_distribution,
						color: '#3b8090',
					},
					{
						labelStart: ~~weight_measured + '%', // Weight Measured
						value: weight_measured,
						color: "#ea5c58"
					},
					// {
					// 	labelStart: exclusive_breastfeeding + '%', //Exclusive Breastfeeding
					// 	value: exclusive_breastfeeding,
					// 	color: "#003d48"
					// },
				],
				center: {
					content: [
					'', 'MATERNAL','NUTRITION'
					],
				}
			});

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
					labelStart: ~~iycf_counselling + '%', //IYCF Counselling
					value: iycf_counselling,
					color: '#eea039',
				},
				// {
			 //  		labelStart: supplements_distributed + '%', //supplementss
			 //  		value: supplements_distributed,
			 //  		color: '#137f91',
			 //  	},
			  	{
			  		labelStart: ~~child_growth_monitoring + '%', //Child Growth Monitoring
			  		value: child_growth_monitoring,
			  		color: '#ea5c58'
			  	},
			  	// {
			  	// 	labelStart: minimum_acceptable_diet + '%', //Minimum acceptable diet
			  	// 	value: minimum_acceptable_diet,
			  	// 	color: '#003d48'
			  	// },
				],
				center: {
					content: [
						'', 'CHILD', 'NUTRITION'
					],
				}
			});
	    } 
	    // console.API.clear();
	</script>

	<script>
		$('.slideTrigger').click(function(){
			TweenMax.staggerTo(".slideInContainer", 1, {left:'0', backgroundColor: "#CCC", ease:Power4.easeInOut});
		});
	</script>

	

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



    swiper.on('paginationUpdate', function(i){
    	// console.log(i.realIndex, barisalClicked, barisalClicked==true);
    	if(i.realIndex == 0) {
    		$('#chartID').hide();
				document.getElementById('barchart-title-id').style.visibility = 'hidden';
				$('#map-title').hide();
    	} else if(i.realIndex == 1 && barisalClicked == true) {
    		$('#chartID').show();
    		document.getElementById('barchart-title-id').style.visibility = 'visible';
    		$('#map-title').show();
    	} else {
    		$('#chartID').hide();
    		document.getElementById('barchart-title-id').style.visibility = 'hidden';
    		$('#map-title').hide();
    	}
    })
  </script>

  <script>
  	const getMapData = (model, item, id, text) => {
  		clicked = false;
  		$('#chartID').html('');
  		if(model == 'BdhsStunting' || model == 'BdhsWasting' || model == 'BdhsAnemia' || model == 'BdhsBmi') {

  		} else {
	  		document.getElementById('map-hint-id').classList.remove('slowhide');
	  		setTimeout(function(){
			    document.getElementById('map-hint-id').classList.add('slowhide');
				}, 2000);
				document.getElementById('barchart-title-id').style.visibility = 'hidden';
			}
			
  		$('.maplinks').removeClass('active').addClass('inactive');
      $(id).removeClass('inactive').addClass('active');
  		
			$.ajax({
	      type: 'get',
	      url: '/dashboard_specific_map',
	      data: {"model": model},
	      success: function (res) {
	      	// console.log(res);
	      	if(res['dataExists']) {
		      	if(model == 'BdhsStunting' || model == 'BdhsWasting' || model == 'BdhsBmi') {
		      		$('#low-text').html('Low');
							$('#avg-text').html('Medium');
							$('#high-text').html('High');
							$('#vhigh-text').html('Very High');
		      	} else if(model == 'BdhsAnemia') {
		      		$('#low-text').html('None');
							$('#avg-text').html('Mild');
							$('#high-text').html('Moderate');
							$('#vhigh-text').html('Severe');
		      	} else {
		      		$('#low-text').html('Very High');
							$('#avg-text').html('High');
							$('#high-text').html('Medium');
							$('#vhigh-text').html('Low');
		      	}
						$('#map-title').html(text)
						$('#map-title').show();
	      		map = new google.maps.Map(document.getElementById('mapdiv'), {
			        center: {lat: 23.684994, lng: 90.356331},
			        zoom: 7,
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
						var anotherLayer = new google.maps.Data();
						var stateLayer = new google.maps.Data();
						
						anotherLayer.loadGeoJson("{{asset('js/barisal.geojson')}}");
						stateLayer.loadGeoJson("{{asset('js/test_complete.json')}}");
						var clicked = false;
						stateLayer.setStyle(function(feature) {
							var localColor = '#ededed';
							// if(feature.getProperty('name') != 'Barisal Division') {
								var ids = feature.getProperty('ids').split('-');
								var id = ids[0];
								if(res['server'] == 'community')
									id = ids[1];
								var value = parseInt(res['minimalData'][id]).toFixed(1);
								var localColor = '';
								if(model == 'BdhsStunting' || model == 'BdhsWasting' || model == 'BdhsAnemia' || model == 'BdhsBmi') {
									if(value >= parseFloat(res['ranges']['min']).toFixed(1) && value < parseFloat(res['ranges']['q1']).toFixed(1)){
										localColor = scoreColors['low'];
									} else if(value >= parseFloat(res['ranges']['q1']).toFixed(1) && value < parseFloat(res['ranges']['q2']).toFixed(1)) {
										localColor = scoreColors['average'];
									} else if(value >= parseFloat(res['ranges']['q2']).toFixed(1) && value < parseFloat(res['ranges']['q3']).toFixed(1)) {
										localColor = scoreColors['high'];
									} else if(value >= parseFloat(res['ranges']['q3']).toFixed(1)) {
										localColor = scoreColors['very high'];
									}
								}else {
									// console.log(res['ranges'], value);
									if(value >= parseInt(res['ranges']['min']) && value < parseInt(res['ranges']['q1'])){
										localColor = scoreColors['very high'];
									} else if(value >= parseInt(res['ranges']['q1']) && value < parseInt(res['ranges']['q2'])) {
										localColor = scoreColors['high'];
									} else if(value >= parseInt(res['ranges']['q2']) && value < parseInt(res['ranges']['q3'])) {
										localColor = scoreColors['average'];
									} else if(value >= parseInt(res['ranges']['q3'])) {
										localColor = scoreColors['low'];
									}
								}	
							// }
							
							// color = feature.getProperty('color');
							return {
								fillColor: localColor,
								fillOpacity: 1,
								strokeColor: '#fff',
								strokeWeight: 1.5,
								zIndex: 1
							};
						});

						anotherLayer.setStyle(function(feature) {
							var localColor = feature.getProperty('color');
							var ids = feature.getProperty('ids').split('-');
							var id = ids[0];
							if(res['server'] == 'community')
								id = ids[1];
							var value = parseInt(res['minimalData'][id]);
							// console.log(value, res['districtRanges']['min'], res['districtRanges']['q1'], res['districtRanges']['q2']);
							localColor = districtScoreColor['low'];
							if(!res['emptydistricts']) {
								if(value >= parseFloat(res['districtRanges']['min']).toFixed(1) && value < parseFloat(res['districtRanges']['q1']).toFixed(1)) {
									localColor = districtScoreColor['very high'];
								} else if(value >= parseFloat(res['districtRanges']['q1']).toFixed(1) && value < parseFloat(res['districtRanges']['q2']).toFixed(1)) {
									localColor = districtScoreColor['high'];
								} else if(value >= parseFloat(res['districtRanges']['q2']).toFixed(1)) {
									localColor = districtScoreColor['average'];
								} 
							}
															
							return {
								fillColor: localColor,
								fillOpacity: 1,
								strokeColor: '#fff',
								strokeWeight: 1.5,
								zIndex: 3
							};
						});

						// Add mouseover and mouse out styling for the GeoJSON State data
						stateLayer.addListener('mouseover', function(e) {
							if(clicked){
								if(e.feature.getProperty('name') == 'Barisal Division') {
									ids = e.feature.getProperty('ids').split('-');
									id = ids[0];
									if(res['server'] == 'community')
										id = ids[1];
									value = res['minimalData'][id];
									if(isNaN(value))
										value = 'N/A';
									else
										value = parseFloat(res['minimalData'][id]).toFixed(1);
									if(model == 'BdhsStunting' || model == 'BdhsWasting' || model == 'BdhsAnemia' || model == 'BdhsBmi')
										value += '%';
									infoWindow.setContent('<div style="line-height:1.00;overflow:hidden;white-space:nowrap;">' + e.feature.getProperty('name') + '<br />' + res['text'] + '<span class="map-text">' + value + '</span>' + '</div>');
									var anchor = new google.maps.MVCObject();
						    	anchor.set("position", e.latLng);
						    	infoWindow.open(map, anchor);
									stateLayer.overrideStyle(e.feature, {
										strokeColor: '#000',
										strokeWeight: 1,
										zIndex: 2
									});
								}
							} else {
								ids = e.feature.getProperty('ids').split('-');
								id = ids[0];
								if(res['server'] == 'community')
									id = ids[1];
								value = res['minimalData'][id];
								// console.log(isNaN(value));
								if(isNaN(value))
										value = 'N/A';
								else
									value = parseFloat(res['minimalData'][id]).toFixed(1);
								if(model == 'CcMrAncNutriCounsel' || model == 'CcMrAncIfaDistribution' || model == 'ImciCounselling' || model == 'BdhsStunting' || model == 'BdhsWasting' || model == 'BdhsAnemia' || model == 'BdhsBmi') {
									if(value != 'N/A') {
										value += "%";
									}
								}
								infoWindow.setContent('<div style="line-height:1.00;overflow:hidden;white-space:nowrap;">' + e.feature.getProperty('name') + '<br />' + res['text'] + '<span class="map-text">' + value + '</span>' + '</div>');
								var anchor = new google.maps.MVCObject();
					    	anchor.set("position", e.latLng);
					    	infoWindow.open(map, anchor);
								stateLayer.overrideStyle(e.feature, {
									// fillColor: e.feature.getProperty('color'),
									strokeColor: '#000',
									// strokeColor: e.feature.getProperty('color'),
									strokeWeight: 1,
									zIndex: 2
								});
							}	
						});

						anotherLayer.addListener('mouseover', function(e) {
							ids = e.feature.getProperty('ids').split('-');
							id = ids[0];
							if(res['server'] == 'community')
								id = ids[1];
							value = res['minimalData'][id];
							if(isNaN(value))
								value = 'N/A';
							else {
								value = parseFloat(value).toFixed(1);
							}

							if(model == 'CcMrAncNutriCounsel' || model == 'CcMrAncIfaDistribution' || model == 'ImciCounselling' || model == 'BdhsStunting' || model == 'BdhsWasting' || model == 'BdhsAnemia' || model == 'BdhsBmi') {
								if(value != 'N/A') {
									value += "%";
								}
							}

							if(res['emptydistricts'] && value == 0) {
								value = 'N/A';
							}
							infoWindow.setContent('<div style="line-height:1.00;overflow:hidden;white-space:nowrap;">' + e.feature.getProperty('name') + '<br />' + res['text'] + '<span class="map-text">' + value + '</span>' + '</div>');
							var anchor = new google.maps.MVCObject();
				    	anchor.set("position", e.latLng);
				    	infoWindow.open(map, anchor);
							anotherLayer.overrideStyle(e.feature, {
								strokeColor: '#000',
								strokeWeight: 1,
								zIndex: 5
							});
							
						});

						stateLayer.addListener('click', function(e) {
							if(model == 'BdhsStunting' || model == 'BdhsWasting' || model == 'BdhsAnemia' || model == 'BdhsBmi') {
							} else {
								if(e.feature.getProperty('name') == 'Barisal Division') {

										var bounds = new google.maps.LatLngBounds();
								    processPoints(e.feature.getGeometry(), bounds.extend, bounds);
								    map.fitBounds(bounds);
								    stateLayer.overrideStyle(e.feature, {
											fillColor: '#ededed',
											strokeColor: '#ededed',
											// strokeColor: e.feature.getProperty('color'),
											strokeWeight: 1,
											zIndex: 1
										});
										// console.log(res);
										anotherLayer.setMap(map);

									if(model == 'CcMrAncIfaDistribution' || model == 'CcMrAncNutriCounsel' || model == 'ImciCounselling') {
										$('#barchart-title-id').html(text);
										document.getElementById('barchart-title-id').style.visibility = 'visible';
										barisalClicked = true;
										$('#chartID').html('');
										$('#chartID').show();
										$('html,body').animate({
							        scrollTop: $("#chartID").offset().top},
							        'slow');
										var max = 0;
										var dataCSV = [];
										console.log(res['minimalDistrict']);
										for(var key in res['minimalDistrict']) {
											temp = {};
											temp.id = key;
											temp.value = res['minimalDistrict'][key];
											if(max < temp.value)
												max = temp.value;
											dataCSV.push(temp);
										}
										
										parentDiv = document.getElementById('chartID');
									  var margin = {top:20, right:20, bottom:20, left:20};

										var width = parentDiv.clientWidth - margin.left - margin.right;

										var height = 185;
										var xScale = d3.scale.ordinal().rangeRoundBands([0, width], .03)

										var yScale = d3.scale.linear()
										      .range([height, 0]);


										var xAxis = d3.svg.axis()
												.scale(xScale)
												.orient("bottom");
										      
										      
										var yAxis = d3.svg.axis()
												.scale(yScale)
												.orient("left");

										var svgContainer = d3.select("#chartID").append("svg")
												.attr("width", width+margin.left + margin.right)
												.attr("height",height+margin.top + margin.bottom)
												.append("g").attr("class", "container")
												.attr("transform", "translate("+ margin.left +","+ margin.top +")");

										xScale.domain(dataCSV.map(function(d) { return d.id; }));
										yScale.domain([0, d3.max(dataCSV, function(d) { return parseFloat(d.value).toFixed(1); })]);


										//xAxis. To put on the top, swap "(height)" with "-5" in the translate() statement. Then you'll have to change the margins above and the x,y attributes in the svgContainer.select('.x.axis') statement inside resize() below.
										var xAxis_g = svgContainer.append("g")
												.attr("class", "x axis")
												.attr("transform", "translate(0," + (height) + ")")
												.call(xAxis)
												.selectAll("text");
													
										// Uncomment this block if you want the y axis
										/*var yAxis_g = svgContainer.append("g")
												.attr("class", "y axis")
												.call(yAxis)
												.append("text")
												.attr("transform", "rotate(-90)")
												.attr("y", 6).attr("dy", ".71em")
												//.style("text-anchor", "end").text("Number of Applicatons"); 
										*/


										svgContainer.selectAll(".bar")
									  		.data(dataCSV)
									  		.enter()
									  		.append("rect")
									  		.attr("class", function(d) {
									  			if(parseInt(d.value) >= parseFloat(res['districtRanges']['min']).toFixed(1) && parseInt(d.value) < parseFloat(res['districtRanges']['q1']).toFixed(1)) {
														return 'bar vhigh';
													} else if(parseInt(d.value) >= parseFloat(res['districtRanges']['q1']).toFixed(1) && parseInt(d.value) < parseFloat(res['districtRanges']['q2']).toFixed(1)) {
														return 'bar high';
													} else if(parseInt(d.value) > parseFloat(res['districtRanges']['q2']).toFixed(1)) {
														return 'bar mid';
													}
									  		})
									  		.attr("x", function(d) { return xScale(d.id); })
									  		.attr("width", xScale.rangeBand())
									  		.attr("y", function(d) { return yScale(d.value); })
									  		.attr("height", function(d) { return height - yScale(d.value); });
									  svgContainer.selectAll(".text")  		
											  .data(dataCSV)
											  .enter()
											  .append("text")
											  .attr("class","label")
											  .attr("x", (function(d) { return xScale(d.id) + xScale.rangeBand() / 2 ; }  ))
											  .attr("y", function(d) { return yScale(d.value) - 15; })
											  .attr("dy", ".75em")
											  .text(function(d) { return parseFloat(d.value).toFixed(1)+"%"; });

										document.addEventListener("DOMContentLoaded", resize);
										d3.select(window).on('resize', resize);
										
										function resize() {
										  width = parseInt(d3.select('#chartID').style('width'), 10);
										  width = parseInt(width - margin.left - margin.right);

										  height = parseInt(d3.select("#chartID").style("height"));
										  height = parseInt(height - margin.top - margin.bottom);
										    xScale.range([0, width]);
										    xScale.rangeRoundBands([0, width], .03);
										    yScale.range([height, 0]);

										    yAxis.ticks(Math.max(height/50, 2));
										    xAxis.ticks(Math.max(width/50, 2));

										    d3.select(svgContainer.node().parentNode)
										        .style('width', (width + margin.left + margin.right) + 'px');

										    svgContainer.selectAll('.bar')
										    	.attr("x", function(d) { return xScale(d.id); })
										      .attr("width", xScale.rangeBand());
										      
										   svgContainer.selectAll("text")  		
											 .attr("x", (function(d) { if(isNaN(xScale(d.id	) + xScale.rangeBand() / 2)) return 0; else return xScale(d.id	) + xScale.rangeBand() / 2 ; }  ))
										      .attr("y", function(d) { if(isNaN(yScale(parseFloat(d.value).toFixed(1)) - 15)) return 0; return yScale(parseFloat(d.value).toFixed(1)) - 15; })
										      .attr("dy", ".75em");   	      

										    svgContainer.select('.x.axis').call(xAxis.orient('bottom')).selectAll("text").attr("y",10).call(wrap, xScale.rangeBand());
										}

										function wrap(text, width) {
										  text.each(function() {
										    var text = d3.select(this),
										        words = text.text().split(/\s+/).reverse(),
										        word,
										        line = [],
										        lineNumber = 0,
										        lineHeight = 1.1, // ems
										        y = text.attr("y"),
										        dy = parseFloat(text.attr("dy")).toFixed(1),
										        tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y).attr("dy", dy + "em");
										    while (word = words.pop()) {
										      line.push(word);
										      tspan.text(line.join(" "));
										      if (tspan.node().getComputedTextLength() > width) {
										        line.pop();
										        tspan.text(line.join(" "));
										        line = [word];
										        tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
										      }
										    }
										  });
										}
									}
								}
							}
						});

						stateLayer.addListener('mouseout', function(e) {
							stateLayer.overrideStyle(e.feature, {
								strokeColor: '#fff',
								strokeWeight: 1.5,
								zIndex: 1
							});
						});

						anotherLayer.addListener('mouseout', function(e) {
							anotherLayer.overrideStyle(e.feature, {
								strokeColor: '#fff',
								strokeWeight: 1.5,
								zIndex: 3
							});
						});

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
