@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row row-no-padding">

		{{-- Selectors --}}
		<div class="col-md-3">
			<div class="side-filter-div">
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <label class="input-group-text" for="division-id">Divisions</label>
				  </div>
				  <select class="custom-select" id="division-id">
				  </select>
				</div>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <label class="input-group-text" for="period-id">Periods</label>
				  </div>
				  {{-- <select class="custom-select" id="period-id" multiple>
				  </select> --}}
				  <select class="custom-select" id="period-id">
				  	<option value="LAST_MONTH">1 month</option>
				  	<option value="LAST_6_MONTHS">6 months</option>
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
	        height: 700px;
	    }
	</style>
@endsection

@section('outjavascript')
		    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script> -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOIfN5zpG8afvKRUIop9qiZqKIUPqw7_4&v=3.exp&sensor=false"></script>
    <script>
		var map,
			cachedGeoJson,
			province = ['One','Two','Three','Four','Five','Six','Seven'],
			infoWindow = new google.maps.InfoWindow({
				content: ""
				});

		function processGeoJson(promise) {
			promise.then(function(data){
				map.data.forEach(function(data) {
				    // filter...
				    map.data.remove(data);
				});

				cachedGeoJson = data; //save the geojson in case we want to update its values
				map.data.addGeoJson(cachedGeoJson,{idPropertyName:"id"});  
			});
		}

		function setMap(triangleCoords) {
			var bermudaTriangle = new google.maps.Polygon({
				paths: triangleCoords,
				strokeColor: '#FF0000',
				strokeOpacity: 0.8,
				strokeWeight: 2,
				fillColor: '#FF0000',
				fillOpacity: 0.35
			});
			bermudaTriangle.setMap(map);
		}
		
		var provincedata;

		google.maps.event.addDomListener(window, 'load', function initialize() {
			//create the map
			map = new google.maps.Map(document.getElementById('map-canvas'), {
				zoom: 7,
				center: { lat: 23.684994, lng: 90.3563309 },
				scrollwheel: false
			});

			//style fucntions
			var setColorStyleFn = function(feature) {
				return {strokeWeight: 1};
			}
			
			// Set the stroke width, and fill color for each polygon, with default colors at first
			map.data.setStyle(setColorStyleFn);
			
			// Load GeoJSON.
			var promise = $.getJSON("{{asset('js/test.geojson')}}"); //same as map.data.loadGeoJson();
			processGeoJson(promise);

	      	// listen for click events
			map.data.addListener('click', function(event) {
				//show an infowindow on click   
				infoWindow.setContent('<div style="line-height:1.35;overflow:hidden;white-space:nowrap;">'+ event.feature.getProperty('name') + '</div>');
				var anchor = new google.maps.MVCObject();
				anchor.set("position",event.latLng);
				infoWindow.open(map,anchor);
			});
		});
    </script>
@endsection

@section('outjavascripts')
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOIfN5zpG8afvKRUIop9qiZqKIUPqw7_4&v=3.exp&sensor=false"></script>
	<script>
		$(document).ready(function() {
			loadGeoJson();
		})

		function initMap(coordinates) {
			var map = new google.maps.Map(document.getElementById('map-canvas'), {
				zoom: 5,
				center: {lat: 24.886,lng: -70.268},
				mapTypeId: google.maps.MapTypeId.TERRAIN
			});

			// Define the LatLng coordinates for the polygon's path.
			var triangleCoords = [
				{lat: 25.774, lng: -80.190},
				{lat: 18.466, lng: -66.118},
				{lat: 32.321, lng: -64.757},
				{lat: 25.774, lng: -80.190}
			];

			console.log(coordinates)

			// Construct the polygon.
			var bermudaTriangle = new google.maps.Polygon({
				paths: coordinates,
				strokeColor: '#FF0000',
				strokeOpacity: 0.8,
				strokeWeight: 2,
				fillColor: '#FF0000',
				fillOpacity: 0.35
			});
			
			bermudaTriangle.setMap(map);
		}
			// google.maps.event.addDomListener(window, "load", initMap);

		
		function convertJsonArrayToObject(triangleCoords) {
			var points = [];
		
			for (var i = 0; i < triangleCoords.length; i++) {
				points.push({
				  lat: triangleCoords[i][0],
				  lng: triangleCoords[i][1]
				});
			}

			return points;
		}

		function loadGeoJson() {
			// $.ajax({
			// 	type: 'GET',
			// 	url: 'load-geojson',
			// 	success: function (res) {
			// 		let geojson = JSON.parse(res)
			// 		let lastdate;

			// 		$.each(geojson, function(key, geo_coord) {
			// 			let response = JSON.parse(geo_coord['co'])
			// 			let converted_coordinates = convertJsonArrayToObject(response[0][0])	

			// 			console.log(converted_coordinates)
			// 		});

			// 		// initMap(converted_coordinates)
			// 	}
			// })
		}
	</script>
@endsection