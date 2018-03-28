@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row row-no-padding">

		{{-- Selectors --}}
		<div class="col-md-3">
			<div class="side-filter-div">
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <label class="input-group-text" for="division-id">Level</label>
				  </div>
				  <select class="custom-select" name="organisation_unit_levels_id" id="organisation-unit-levels-id">
				  	<option value="">-- Select Organisation Level --</option>
				  </select>
				</div>

				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <label class="input-group-text" for="organisation-unit-id">Organisation</label>
				  </div>
				  <select class="custom-select" id="organisation-unit-id" name="organisation-unit-id" multiple>
				  </select>
				</div>

				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <label class="input-group-text" for="period-id">Periods</label>
				  </div>
				  {{-- <select class="custom-select" id="period-id" multiple>
				  </select> --}}
				  <select class="custom-select" id="period-id">
				  	@foreach($periods as $key => $period)
				  		<option value="{{ $key }}">{{ $period }}</option>
				  	@endforeach
				  </select>
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <label class="input-group-text" for="programme-id">Programme</label>
				  </div>
				  <select class="custom-select" id="programme-id">
				  </select>
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <label class="input-group-text" for="affected-id">Affected</label>
				  </div>
				  <select class="custom-select" id="affected-id">
				  </select>
				</div>
				<div class="input-group mb-3">
				  <button type="button" class="btn btn-primary" id="submit-platform-btn">Submit</button>
				</div>
			</div>
		</div>

		{{-- Bargraph --}}
		<div class="col-md-9">
			<div class="bargraph-div">
				<div id="map-canvas"></div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('styles')
	<style>
		#map-canvas {
	    	width:100%;
	        height: 600px;
	    }
	</style>
@endsection

@section('outjavascript')
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOIfN5zpG8afvKRUIop9qiZqKIUPqw7_4&v=3.exp&sensor=false"></script>
    
    <script>
    	$(document).ready(function() { 
    		$('#affected-id').parent().hide();
			getOrganisationUnitLevels();
			getElements();
    	})

    	$('#organisation-unit-levels-id').on('change', function() {
    		$.ajax({
    			type: 'GET',
    			url: 'load-level-based-organisation-units',
    			data: $(this).serialize(),
    			success: function (res) {
    				var data = JSON.parse(res)
					var organisationUnits = data['organisationUnits']

					$("#organisation-unit-id").empty();
					$.each(organisationUnits, function(key, org) {
			            $("#organisation-unit-id").append('<option value="'+org.id+'">'+org.displayName+'</option>');
					})	
    			}
    		})
    	})

  //   	function getPeriods() {
		//     $.ajax({
		//       type: 'get',
		//       url: '/get_periods',
		//       success: function (res) {
		//         dataSets = res["periods"];
		//         for(data in dataSets) {
		//             $("#period-id").append('<option value="'+dataSets[data]+'">'+data+'</option>');
		//         }
		//         $('.periods_wrapper .loading').hide()
		//       },
		//       error: function (res) {
		//         console.log('failed')
		//       }
		//     })
		// }

		function getOrganisationUnitLevels() {
			$.ajax({
				type: 'GET',
				url: 'load-organisation-unit-levels',
				success: function (res) {
					var data = JSON.parse(res)
					var organisationUnitLevels = data['organisationUnitLevels']

					$.each(organisationUnitLevels, function(key, org) {
			            $("#organisation-unit-levels-id").append('<option selected="selected" value="'+org.level+'">'+org.name+'</option>');
					})
				}
			})
		}

		function getElements() {
		  	$.ajax({
			    type: 'get',
			    url: '/get_elements',
			    success: function (res) {
			    	// keys = Object.keys(res);
			    	// programmes = res["programmesJoint"];
			    	programmes = res['programmes'];
			    	console.log(programmes)
			    	$.each(programmes, function(key, programme) {
			    		$("#programme-id").append('<option value="'+key+'">'+programme+'</option>');	
			    	})
			    },
			    error: function (res) {
			      console.log('failed')
			    }
				})
		}

		var affectedExists = 0;
		var Divisions = '';
		var Programme = '';
		var AffectedArrs = '';
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

		$('#programme-id').change(function(){
		  	dataElement = ($('#programme-id').val())
		  	$.ajax({
		      type: 'get',
		      url: '/get_category_joint/',
		      data: {dataElement: dataElement},
		      success: function (res) {
		      	if(res.exists == "true") {
		      		$('#affected-id').find('option').remove()
		      		affectedArrs = res.affectedArrs;
		      		AffectedArrs = affectedArrs;
		      		for(affectedArr in affectedArrs) {
		      			$("#affected-id").append('<option value="'+affectedArr+'">'+affectedArrs[affectedArr]+'</option>');
		      		}
		      		$('#affected-id').parent().show();
		      		affectedExists = 1;
		      	} else {
		      		$('#affected-id').parent().hide();
		      		affectedExists = 0;
		      	}
		      },
		      error: function (res) {
		        console.log('failed')
		      }
		    });
		});
    </script>

    <script>
		  // Set the Map Options to be applied when the map is set.
		  var mapOptions = {
		    zoom: 7,
		    scrollwheel: true,
		    center: new google.maps.LatLng(23.684994, 90.3563309),
		    mapTypeId: google.maps.MapTypeId.ROADMAP,
		    mapTypeControl: false,
		    mapTypeControlOptions: {
		      mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.TERRAIN]
		    }
		  }

		  // Set a blank infoWindow to be used for each to state on click
		  var infoWindow = new google.maps.InfoWindow({
		    content: ""
		  });

		  // Set the map to the element ID and give it the map options to be applied
		  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		  map.setTilt(45);

		  // Create the state data layer and load the GeoJson Data
		  var stateLayer = new google.maps.Data();
		  // stateLayer.loadGeoJson('https://gist.githubusercontent.com/dmarg/b2959e771ae680acbc95/raw/815a03f55d028dace4371c27d0b787ca0f2f2b5d/states.json');
		  stateLayer.loadGeoJson("{{asset('js/test.geojson')}}");

		  // Set and apply styling to the stateLayer
		  stateLayer.setStyle(function(feature) {
		    return {
		      fillColor: getColor(feature.getProperty('calc')), // call function to get color for state based on the code
		      fillOpacity: 0.8,
		      strokeColor: '#777',
		      strokeWeight: 1,
		      zIndex: 1
		    };
		  });

		  // Add mouseover and mouse out styling for the GeoJSON State data
		  stateLayer.addListener('mouseover', function(e) {
		    stateLayer.overrideStyle(e.feature, {
		      strokeColor: '#444',
		      strokeWeight: 2,
		      zIndex: 2
		    });
		  });

		  stateLayer.addListener('mouseout', function(e) {
		    stateLayer.revertStyle();
		  });

		  // Adds an info window on click with in a state that includes the state name and COLI
		  stateLayer.addListener('click', function(e) {
		    console.log(e);
		    infoWindow.setContent('<div style="line-height:1.00;overflow:hidden;white-space:nowrap;">' +
		      e.feature.getProperty('name') + '<br> Value: ' +
		      e.feature.getProperty('data_value') + '</div>');

		    var anchor = new google.maps.MVCObject();
		    anchor.set("position", e.latLng);
		    infoWindow.open(map, anchor);
		  });


		  // Final step here sets the stateLayer GeoJSON data onto the map
		  stateLayer.setMap(map);


		  // returns a color based on the value given when the function is called
		  function getColor(coli) {
		    var colors = [
		      '#d1ccad',
		      '#c2c083',
		      '#4c5d27'
		    ];

		    // return coli >= 60 ? colors[6] :
		    //   coli > 50 ? colors[5] :
		    //   coli > 40 ? colors[4] :
		    //   coli > 30 ? colors[3] :
		    //   coli > 20 ? colors[2] :
		    //   coli > 10 ? colors[1] :
		    //   colors[0];
		    
		    return coli == 'min' ? colors[2] :
		      coli == 'avg' ? colors[1] :
		      colors[0];
		  }
    </script>

    <script>
    	$('#submit-platform-btn').click(function() {
		  	organisation_units = $('#organisation-unit-id').val();
		  	period = $('#period-id').val();
		  	programme = $('#programme-id').val();
		  	affected = -1;
		  	if(affectedExists) {
		  		affected = $('#affected-id').val();
		  	}
		  	platformDiction = {organisation_units: organisation_units, period: period, programme: programme, affected: affected}
		  	
		  	$.ajax({
		      type: 'get',
		      url: '/load-data-value-set',
		      data: {platformDiction: platformDiction},
		      success: function (res) {
		      	// console.log(res)
				stateLayer.addGeoJson(res.geocoordinates);
		      },
		      error: function (res) {
		        console.log('failed')
		      }
		    });
		  });
    </script>
@endsection
