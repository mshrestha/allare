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

	<div class="col-6 outcome-progress-col">
		<div class="report-heading row">
			<div class="txt-icon col-6">
				<div class="report-icon" style="float: left; margin-right: 10px;">
					@if (strpos(strtolower($key), 'stunting') !== false)
					<span class="icon-children icon"></span>
					{{-- <img src="{{ asset('images\stunting.svg') }}" alt=""> --}}
					@elseif (strpos(strtolower($key), 'wasting') !== false)
					<span class="icon-wasting icon"></span>
					{{-- <img src="{{ asset('images\wasting.svg') }}" alt=""> --}}
					@elseif (strpos(strtolower($key), 'breastfeed') !== false)
					<span class="icon-breastfeeding icon"></span>
					{{-- <img src="{{ asset('images\breastfeed.svg') }}" alt=""> --}}
					@elseif (strpos(strtolower($key), 'supplements') !== false)
					<span class="icon-supplement icon"></span>
					{{-- <img src="{{ asset('images\supplement.svg') }}" alt=""> --}}
					@endif
				</div>
				<div class="outcome-icon-dis" style="float: left;">
					<h6 class="mb-0">{!! str_replace('_', ' ', $key) !!}</h6>
					<div>{{$analysis['goal_text']}}</div>
				</div>
			</div>
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

		<div class="canvas-holder-h d-md-none-">
			<div class="progress-bar-h" id="goal-chart-h-{{
			$key}}">

				<div class="goal" style="width: {{$incomplete}}%;">
					{{-- {{$analysis['goal']}} --}}
				</div>

				<div class="current grow-h-animation" style="width: {{$complete}}%;">
					{{$analysis['goal_values']}}  %
				</div>

			</div>
		</div>
		<div class="tgtxt">
			<div class="target" style="right: {{$analysis['target']}}%;"></div>
			Target {{$analysis['goal']}}
		</div>
	</div>
