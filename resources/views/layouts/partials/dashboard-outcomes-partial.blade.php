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

	<div class="col-md-4">
		<div class="report-heading">
			<div class="report-icon float-left">
				@if (strpos(strtolower($key), 'stunting') !== false) 
				<img src="{{ asset('images\stunting.svg') }}" alt="">
				@elseif (strpos(strtolower($key), 'wasting') !== false) 
				<img src="{{ asset('images\wasting.svg') }}" alt="">
				@elseif (strpos(strtolower($key), 'breastfeed') !== false)
				<img src="{{ asset('images\breastfeed.svg') }}" alt="">
				@endif
			</div>
			<h4>{!! str_replace('_', ' ', $key) !!}</h4>
		</div>
		{{-- <div id="canvas-holder" class="d-none d-md-block">
			<div class="progress-bar-v" id="goal-chart-{{
			$key}}">
				
				<div class="goal" style="height: {{$incomplete}}%;">
					{{$analysis['goal']}}
				</div>
				
				<div class="current grow-v-animation" style="height: {{$complete}}%;">
					{{$analysis['goal_values']}}  %
				</div>

			</div>

		</div> --}}
		<div class="progress-bar-note">
			{{$analysis['goal_text']}}
		</div>
		<div id="canvas-holder-h" class="d-md-none-">
			<div class="progress-bar-h" id="goal-chart-h-{{
			$key}}">
				
				<div class="goal" style="width: {{$incomplete}}%;">
					{{$analysis['goal']}}
				</div>
				
				<div class="current grow-h-animation" style="width: {{$complete}}%;">
					{{$analysis['goal_values']}}  %
				</div>

			</div>

		</div>
	</div>