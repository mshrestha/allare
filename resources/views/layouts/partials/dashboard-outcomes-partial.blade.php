
<div class="col-md-12 col-lg-6 outcome-progress-col">
	<div class="report-heading row">
		<div class="txt-icon col-12">
			<div class="report-icon" style="float: left; margin-right: 10px;">
				@if (strpos(strtolower($key), 'stunting') !== false)
				<span class="icon-stunting-n icon"></span>
				{{-- <img src="{{ asset('images\stunting.svg') }}" alt=""> --}}
				@elseif (strpos(strtolower($key), 'wasting') !== false)
				<span class="icon-wasting-n icon"></span>
				{{-- <img src="{{ asset('images\wasting.svg') }}" alt=""> --}}
				@elseif (strpos(strtolower($key), 'anemia') !== false)
				<span class="icon-blood-drop icon"></span>
				@elseif (strpos(strtolower($key), 'breastfeed') !== false)
				<span class="icon-breastfeeding icon"></span>
				{{-- <img src="{{ asset('images\breastfeed.svg') }}" alt=""> --}}
				@elseif (strpos(strtolower($key), 'supplements') !== false)
				<span class="icon-ifa-tablets icon"></span>
				{{-- <img src="{{ asset('images\supplement.svg') }}" alt=""> --}}
				@endif
				
			</div>
			<div class="outcome-icon-dis" style="float: left;">
				<h6 class="mb-0">{!! str_replace('_', ' ', $key) !!}</h6>
				<div>{{$analysis['goal_text']}}</div>

			</div>
		</div>
	</div>
	<div class="canvas-holder-h d-md-none-">
		<div class="progress-bar-h" id="goal-chart-h-{{$analysis['id']}}">

			<div class="goal" style="width: {{$analysis['incomplete']}}%;">
				{{-- {{$analysis['goal']}} --}}
			</div>

			<div class="current grow-h-animation" style="width: {{$analysis['goal_values']}}%;">
				{{$analysis['goal_values']}}  %
			</div>

		</div>
	</div>
	<div class="tgtxt">
		<div class="target" style="right: {{$analysis['target']}}%;"></div>
		<div class="target target-label"></div>
		<span class="target-label-text">{{$analysis['goal']}}</span>
	</div>
</div>