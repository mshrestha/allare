<h3>{!! str_replace('_', ' ', $key) !!}</h3>
<div class="trend-analysis-goal" style="margin-top: 20px;">
	{{-- <p>{{ $analysis['month'] }}</p> --}}
	@php
		if($analysis['direction'] == -1) {
			$complete = 100 / ($analysis['limit'] - $analysis['max']) * ($analysis['goal_values'] - $analysis['max']);
			$incomplete = 100 - $complete;
		}
		else {
			$complete = 100 / ($analysis['limit'] - $analysis['min']) * ($analysis['goal_values'] - $analysis['min']);
			$incomplete = 100 - $complete;
		}
	@endphp
	<div class="row">
		<div class="col-md-3">
			<div class="report-heading">
				<h5>Current</h5>
			</div>
			<div id="canvas-holder">
				<div class="progress-bar-v" id="goal-chart-{{
				$key}}">
					<div class="goal" style="height: {{$incomplete}}%;">
						{{$analysis['goal']}}
					</div>
					
					<div class="current" style="height: {{$complete}}%;">
						{{$analysis['goal_values']}}  %
					</div>	
				</div>
			</div>
			<div class="progress-bar-note">
				Reduce stunting in children under-5 years from 36.1% (BDHS 2014) to 25 % by 2021
			</div>
		</div>
		<div class="col-md-6">
			<h5>Trending</h5>
			<div id="canvas-holder">
				<canvas id="line-chart-{{$key}}"></canvas>
			</div>
		</div>
		<div class="col-md-3">
			<div class="row">
				<div class="col-9"><h5>Reports</h5></div>
				<div class="col-3">
					<div class="report-icon float-right">
						@if (strpos(strtolower($key), 'stunting') !== false) 
						<img src="{{ asset('images\stunting.svg') }}" alt="">
						@elseif (strpos(strtolower($key), 'wasting') !== false) 
						<img src="{{ asset('images\wasting.svg') }}" alt="">
						@elseif (strpos(strtolower($key), 'breastfeed') !== false)
						<img src="{{ asset('images\breastfeed.svg') }}" alt="">
						@endif
					</div>
				</div>
			</div>
			<div class="reports-wrapper">
				<p>Lorem ipsum dolor sit amet adipiscing.</p>
				<p>Feb 13,2018</p>
				
				<p>Proin magna elit, congue dictum blandit sed, laor eet quis quam. Praesent sit amet arcu vel nibh tempor hendrerit et id lacus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis in placerat arcu. Sed tinc idunt orci viverra nisl vehicula dignissim.</p>		
			</div>
		</div>
	</div> <!-- row -->
</div> <!-- trend-analysis-pie-chart -->
<hr />

