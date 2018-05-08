<div class="swiper-slide" data-hash="slide{{$counter}}">
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
    <div class="col-xl-2 col-lg-3 col-sm-4">
      <div class="tab-col-title">{!! str_replace('_', ' ', $key) !!}</div>
      <div class="tab-col-subtitle"></div>
      <div id="canvas-holder">
        <div class="progress-bar-v" id="goal-chart-{{
				$key}}">
					
					<div class="goal" style="height: {{$incomplete}}%;">
						{{$analysis['goal']}}
					</div>
					
					<div class="current grow-v-animation" style="height: {{$complete}}%;">
						{{$analysis['goal_values']}}  %
					</div>

				</div>
      </div>
    </div> {{-- col-xs-2 --}}
    <div class="col-xl-5 offset-xl-1 pr-xl-0 col-lg-6 col-sm-8">
      <div class="tab-col-title">People Counselled on {!! str_replace('_', ' ', $key) !!}</div>
      <div class="tab-col-subtitle">Jan 14 - Feb 18</div>
      <div id="canvas-holder">
        <canvas id="line-chart-{{$key}}"></canvas>
      </div>
    </div> {{-- col-xs-5 --}}
    <div class="col-xl-3 offset-xl-1 report-col col-lg-3">
      <div class="tab-col-title">Reports on {!! str_replace('_', ' ', $key) !!}</div>
      <ul class="report-list row">
        <li class="col-sm-6 col-lg-12">
          <a href="#" class="row">
            <span class="col-md-3 col-sm-3 col-3 pr-0"><img src="{{asset('images\report-img.png')}}" alt="" class="img-fluid"> </span>
            <span class="col-sm-9 col-md-9 col-9"><span class="report-title">Lorem ipsum dolor sit amet adipiscing</span> <span class="date">Feb 13,2018</span></span>
          </a>
        </li>
        <li class="col-sm-6 col-lg-12">
          <a href="#" class="row">
            <span class="col-md-3 col-sm-3 col-3 pr-0"><img src="{{asset('images\report-img.png')}}" alt="" class="img-fluid"> </span>
            <span class="col-sm-9 col-md-9 col-9"><span class="report-title">Lorem ipsum dolor sit amet adipiscing</span> <span class="date">Feb 13,2018</span></span>
          </a>
        </li>
        <li class="col-sm-6 col-lg-12">
          <a href="#" class="row">
            <span class="col-md-3 col-sm-3 col-3 pr-0"><img src="{{asset('images\report-img.png')}}" alt="" class="img-fluid"> </span>
            <span class="col-sm-9 col-md-9 col-9"><span class="report-title">Lorem ipsum dolor sit amet adipiscing</span> <span class="date">Feb 13,2018</span></span>
          </a>
        </li>
        
      </ul>

    </div>
  </div>
</div>