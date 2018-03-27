@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row row-no-padding">

		{{-- Selectors --}}
		<div class="col-md-2">
			<div class="side-filter-div">
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
				  <button type="button" class="btn btn-primary" id="submit-platform-btn">Submit</button>
				</div>
			</div>
		</div>

		{{-- Bargraph --}}
		<div class="col-md-10">
			{{-- <ul class="bar-graph" id="platform-bar-graph-id"></ul> --}}
			<div class="bargraph-div">
				<canvas id="maternal" width="400" height="400"></canvas>
				<canvas id="child" width="400" height="400"></canvas>
			</div>
		</div>
	</div>
</div>
@endsection

@section('injavascript')
	//<script>
	$(document).ready(function() {  
		// $('#affected-id').parent().hide();
    // getDivisions();
    getPeriods();
    // getElements();
  });

	var affectedExists = 0;
	var Divisions = '';
	var Programme = '';
	var AffectedArrs = '';
	var ctxMaternal = document.getElementById("maternal").getContext('2d');
	var ctxChild = document.getElementById("child").getContext('2d');
	// ctx.height = 500;
	var chartMaternal, chartChild;
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


  function getMCElements(element) {
  	url = 'get_elements_maternal';
  	if(element == 'maternal')
  		url = 'get_elements_maternal';
  	else if(element == 'child')
  		url = 'get_elements_children';
  	$.ajax({
	    type: 'get',
	    url: url,
	    success: function (res) {
	    	programmes = res["programmesJoint"];
	    	Programme = res['programmes'];
    		$('#programme-id').find('option').remove();
	    	for(programme in programmes) {
	    		$("#programme-id").append('<option value="'+programmes[programme].toString()+'">'+programme+'</option>');
	    	}
	    },
	    error: function (res) {
	      console.log('failed')
	    }
		})
  }

  function getDivisions() {
  	$.ajax({
	    type: 'get',
	    url: '/get_org_division',
	    success: function (res) {
	    	divisions = res["divisions"];
	    	Divisions = divisions;
	    	for(division in divisions) {
	    		$("#division-id").append('<option value="'+division+'">'+divisions[division]+'</option>');
	    	}
	    	$('.organization_units_wrapper').show();
	      $('.datasets_wrapper .loading').hide();
	    },
	    error: function (res) {
	      console.log('failed')
	    }
		})
  }

  function getPeriods() {
    $.ajax({
      type: 'get',
      url: '/get_periods',
      success: function (res) {
        dataSets = res["periods"];
        for(data in dataSets) {
            $("#period-id").append('<option value="'+dataSets[data]+'">'+data+'</option>');
        }
        $('.periods_wrapper .loading').hide()
      },
      error: function (res) {
        console.log('failed')
      }
    })
	}

	function getElements() {
  	$.ajax({
	    type: 'get',
	    url: '/get_elements_joint',
	    success: function (res) {
	    	// keys = Object.keys(res);
	    	programmes = res["programmesJoint"];
	    	Programme = res['programmes'];
	    	for(programme in programmes) {
	    		$("#programme-id").append('<option value="'+programmes[programme].toString()+'">'+programme+'</option>');
	    	}
	    },
	    error: function (res) {
	      console.log('failed')
	    }
		})
  }

	$('#platformType-id').change(function(){
		platformType = $('#platformType-id').val();
		getMCElements(platformType);
	});

	$('#programme-id').change(function(){
  	dataElement = ($('#programme-id').val())
  	$.ajax({
      type: 'get',
      url: '/get_category_mc/',
      data: {dataElement: dataElement},
      success: function (res) {
      	if(res.exists == "true") {
      		$('#affected-id').find('option').remove();
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

	function charts(datasets, labels) {
		// console.log(datasets);
		window.myChart = new Chart(ctx, {
		    type: 'bar',
		    data: datasets,
		    options: {
					title: {
						display: true,
						text: labels
					},
					// tooltips: {
					// 	mode: 'index',
					// 	intersect: false
					// },
					// responsive: true,
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
	            enabled: true,

	            // Zooming directions. Remove the appropriate direction to disable 
	            // Eg. 'y' would only allow zooming in the y direction
	            mode: 'xy',
	        }
				}
			});
	}

  $('#submit-platform-btn').click(function() {
  	division = $('#division-id').val();
  	period = $('#period-id').val();
  	programme = $('#programme-id').val();
  	affected = -1;
  	if(affectedExists) {
  		affected = $('#affected-id').val();
  	}
  	platformDiction = {division: division, period: period, programme: programme, affected: affected}
  	console.log(platformDiction);
  	$.ajax({
      type: 'get',
      url: '/get_data_value_set_mc/',
      data: {platformDiction: platformDiction},
      success: function (res) {
      	periods = res.periods;
      	dataValues = res.dataValueSets;
      	dataSets = [];
      	output = '';
      	label = [];
      	data = [];
      	
      	if (affectedExists) {
      		title = $("#programme-id option[value='"+programme+"']").text()+' - '+$("#affected-id option[value='"+affected+"']").text();
      	} else {
      		title = $("#programme-id option[value='"+programme+"']").text();
      	}
      	
      	counter = 0;
      	for(dataValue in dataValues) {
      		datas = dataValues[dataValue];
      		vals = [];
      		labs = [];
      		bgColor = [];
      		for(data in datas) {
      			currData = datas[data];
      			vals.push(currData['value']);
      			bgColor.push(colors[counter]);
      		}
      		labs.push(Programme[dataValue]);
      		
      		counter += 1;
      		dataSets.push({
  					'label': labs,
            'data': vals,
            'backgroundColor': bgColor
            // 'borderColor': bgColor,
            // 'borderWidth': 1
          });
      	}
      	if(window.myChart != undefined){
      		window.myChart.destroy();
      	}
      	dataSets = {labels: periods, datasets: dataSets};

      	charts(dataSets, title);
      	// $('#platform-bar-graph-id').html(output);
      	
				
      	
      	// if(res.exists == "true") {
      	// 	affectedArrs = res.affectedArrs;
      	// 	for(affectedArr in affectedArrs) {
      	// 		$("#affected-id").append('<option value="'+affectedArrs[affectedArr].id+'">'+affectedArrs[affectedArr].name+'</option>');
      	// 	}
      	// 	$('#affected-id').parent().show();
      	// 	affectedExists = 1;
      	// } else {
      	// 	$('#affected-id').parent().hide();
      	// 	affectedExists = 0;
      	// }
      },
      error: function (res) {
        console.log('failed')
      }
    });
  });


@endsection