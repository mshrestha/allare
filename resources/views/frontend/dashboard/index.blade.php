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
					<h1><b>Outputs</b></h1>
					<div id="maternal-health" class="mt-5">
						<h3>Maternal Health</h3>
						<div class="row">
							@foreach($maternal_trend_analysis as $key => $maternal_trend)
							<div class="col-sm-4">
								<h4>{{ $maternal_trend['name'] }}</h4>
								<div id="canvas-holder">
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
							<div class="col-sm-4">
								<h4>{{ $child_trend['name'] }}</h4>
								<div id="canvas-holder">
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
	<script>
	@foreach($maternal_trend_analysis as $key => $maternal_trend) 
		pieChart('maternal-' + '{{$key }}', {{ $maternal_trend['percent'] }})
	@endforeach

	@foreach($child_trend_analysis as $key => $child_trend)
		pieChart('child-' + '{{$key }}', {{ $child_trend['percent'] }})
	@endforeach

	function pieChart(id, data_value) {
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
              'rgba(54, 162, 235, 0.8)',
              // 'rgba(255, 99, 132, 0.8)',
            ],
            label: 'Dataset 1'
          }],
          labels: [
            'Last Month',
            'Rest of the year',
          ]
        },
        options: {
          responsive: true
        }
      };

      var ctx = document.getElementById('chart-area-'+ id).getContext('2d');
      window.myPie = new Chart(ctx, config);
    }
	</script>
@endsection