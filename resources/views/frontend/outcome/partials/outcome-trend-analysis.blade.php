<div class="trend-analysis-goal" style="margin-top: 20px;">
	<h3>{!! str_replace('_', ' ', $key) !!}</h3>
	{{-- <p>{{ $analysis['month'] }}</p> --}}
	
	<div class="row row-no-padding">
		<div class="col-md-3">
			<div id="canvas-holder">
				<div class="progress-bar-v" id="goal-chart-{{
				$key}}">
					<div class="goal" style="height: 30%;">
						@if(count($analysis) > 5)
							{{$trend_analysis[$key]['goal']}}
						@elseif(count($trend_analysis[$key]) == 2)
							{{$trend_analysis[$key][0]['goal']}}
						@endif
					</div>
					
					<div class="current" style="height: 70%;">
						@if(count($analysis) > 5)
							{{$analysis['goal_values']}}  %
						@elseif(count($trend_analysis[$key]) == 2)
							{{$trend_analysis[$key][0]['goal_values']}} %
						@endif
					</div>	
				</div>
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

