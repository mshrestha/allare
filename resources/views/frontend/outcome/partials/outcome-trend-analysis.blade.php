<div class="trend-analysis-goal" style="margin-top: 20px;">
	<h3>{{ $key }}</h3>
	{{-- <p>{{ $analysis['month'] }}</p> --}}
	
	<div class="row row-no-padding">
		<div class="col-md-3">
			<div id="canvas-holder">
				<canvas id="chart-area-{{$key}}"></canvas>
			</div>
		</div>
		<div class="col-md-6">
			<div id="canvas-holder">
				<canvas id="line-chart-{{$key}}"></canvas>
			</div>
		</div>
		<div class="col-md-3">
			<h3>Reports</h3>
			<div class="reports-wrapper">
				<p>Lorem ipsum dolor sit amet adipiscing.</p>
				<p>Feb 13,2018</p>
				
				<p>Proin magna elit, congue dictum blandit sed, laor eet quis quam. Praesent sit amet arcu vel nibh tempor hendrerit et id lacus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis in placerat arcu. Sed tinc idunt orci viverra nisl vehicula dignissim.</p>		
			</div>
		</div>
	</div> <!-- row -->
</div> <!-- trend-analysis-pie-chart -->


@section('injavascript')
	// <script>
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

		ctx = document.getElementById('chart-area-{{$key}}').getContext('2d');
		myPie = new Chart(ctx, config);
		canvas = document.getElementById("line-chart-{{$key}}");
    ctx = canvas.getContext("2d");

		trendChart = new Chart(ctx, {
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
@endsection