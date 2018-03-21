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
			{{-- <ul class="bar-graph" id="platform-bar-graph-id"></ul> --}}
			<div class="bargraph-div">
				<canvas id="myChart" width="400" height="400"></canvas>
			</div>
		</div>
	</div>
</div>
@endsection

@section('injavascript')
	//<script>
	$(document).ready(function() {  
		$('#affected-id').parent().hide();
    getDivisions();
    getPeriods();
    getElements();
  });

	var affectedExists = 0;
	var Divisions = '';
	var Programme = '';
	var AffectedArrs = '';
	var ctx = document.getElementById("myChart");
	ctx.height = 500;
	var myChart;
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

		            ]
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
	    url: '/get_elements',
	    success: function (res) {
	    	// keys = Object.keys(res);
	    	programmes = res["programmes"];
	    	Programme = programmes;
	    	for(programme in programmes) {
	    		$("#programme-id").append('<option value="'+programme+'">'+programmes[programme]+'</option>');
	    	}
	    },
	    error: function (res) {
	      console.log('failed')
	    }
		})
  }

	
	$('#programme-id').change(function(){
  	dataElement = ($('#programme-id').val())
  	$.ajax({
      type: 'get',
      url: '/get_category/',
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

  $('#submit-platform-btn').click(function() {
  	division = $('#division-id').val();
  	period = $('#period-id').val();
  	programme = $('#programme-id').val();
  	affected = -1;
  	if(affectedExists) {
  		affected = $('#affected-id').val();
  	}
  	platformDiction = {division: division, period: period, programme: programme, affected: affected}
  	$.ajax({
      type: 'get',
      url: '/get_data_value_set/',
      data: {platformDiction: platformDiction},
      success: function (res) {
      	
      	dataValues = res.dataValueSets.dataValues;
      	// console.log(dataValues);
      	output = '';
      	label = [];
      	data = [];
      	bgColor = [];
      	bdColor = [];
      	title = Programme[programme];
      	console.log(title);
      	for(dataValue in dataValues) {
      		// console.log("cc" + dataValue);
       		currData = dataValues[dataValue];
      		// output += '<li class="bar alert" style="height: '+currData['value']+';" title="'+currData['value']+'"><div class="percent">'+currData['value']+'<span>%</span></div><div class="description">'+currData['period']+'</div></li>';
      		label.push(currData['period']);
      		data.push(currData['value']);
      		bgColor.push(colors[dataValue]);
      	}
      	// $('#platform-bar-graph-id').html(output);
      	if(window.myChart != undefined){
      		window.myChart.destroy();
      	}
				window.myChart = new Chart(ctx, {
		    type: 'bar',
		    data: {
		        labels: label,
		        datasets: [{
		            label: title,
		            data: data,
		            backgroundColor: bgColor,
		            borderColor: bgColor,
		            borderWidth: 1
		        }]
		    },
		    options: {
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero:true
		                }
		            }]
		        },
		        maintainAspectRatio: false
		    }
			});
      	
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