<div class="swiper-slide" data-hash="slide{{$counter}}">
	
  <div class="row">
    <div class="col-xl-2 col-lg-3 col-sm-4">
      <div class="tab-col-title">{{$analysis['heading']}}</div>
      <div class="tab-col-subtitle specific-date" id="specific-date-{{$counter}}"></div>
      <div class="canvas-holder">
        <div class="progress-bar-v" id="goal-chart-{{
				$key}}">
					
					<div class="goal" style="height: {{100 - $analysis['goal_values']}}%;">
						{{-- {{$analysis['goal']}} --}}
					</div>
					
					<div class="current grow-v-animation" style="height: {{$analysis['goal_values']}}%;">
						{{$analysis['goal_values']}}  %
					</div>

          <div class="target" style="top: {{$analysis['goal_value']}}% !important;"></div>
          
				</div>
      </div>
      <div class="tgtxt">
        <div class="target-h" style="right: {{$analysis['goal_value']}}%;"></div>
        <div class="target target-label vertical"></div>
        <span class="target-label-text">Target {{$analysis['goal']}}</span>
      </div>
    </div> {{-- col-xs-2 --}}
    <div class="col-xl-6 offset-xl-1 pr-xl-0 col-lg-6 col-sm-8">
      <div class="tab-col-title">{!! str_replace('_', ' ', $key) !!}</div>
{{-- <<<<<<< HEAD
      <div class="tab-col-subtitle">Jan 14 - Feb 18</div>
      <div class="canvas-holder">
======= --}}
      <div class="tab-col-subtitle area-date" id="area-date-{{$counter}}">Jan 14 - Feb 18</div>
      <div class="canvas-holder area-chart" id="area-chart-{{$counter}}">
{{-- >>>>>>> 1d0f6dc195de0557c17d27d1f1676607ccbfcee0 --}}
        <svg id="line-chart-{{$counter}}"></svg>
      </div>
    </div> {{-- col-xs-5 --}}
    <div class="col-xl-3 report-col col-lg-3">
      <div class="tab-col-title">Reports on {{$analysis['heading']}}</div>
      <ul class="report-list row">
        @foreach($analysis['reports'] as $report)
        <li class="col-sm-6 col-lg-12">
          <a href="{{$report['link']}}" target="_blank" class="row">
            <span class="col-md-3 col-sm-3 col-3 pr-0"><img src="{{asset('images\report-img.png')}}" alt="" class="img-fluid"> </span>
            <span class="col-sm-9 col-md-9 col-9"><span class="report-title">{{$report['title']}}</span> <span class="date">{{$report['date']}}</span></span>
          </a>
        </li>
        @endforeach        
      </ul>

    </div>
  </div>
</div>