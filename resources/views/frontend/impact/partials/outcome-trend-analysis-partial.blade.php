<div class="swiper-slide" data-hash="slide{{$counter}}">
	
  <div class="row">
    <div class="col-xl-2 col-lg-3 col-sm-4">
      <div class="tab-col-title">{{$analysis['heading']}}</div>
{{-- <<<<<<< HEAD
      <div class="tab-col-subtitle"></div>
      <div class="canvas-holder">
======= --}}
      <div class="tab-col-subtitle specific-date" id="specific-date-{{$counter}}"></div>
      <div class="canvas-holder">
{{-- >>>>>>> 1d0f6dc195de0557c17d27d1f1676607ccbfcee0 --}}
        <div class="progress-bar-v" id="goal-chart-{{
				$key}}">
					
					<div class="goal" style="height: {{100 - $analysis['goal_value']}}%;">
						{{-- {{$analysis['goal']}} --}}
					</div>
					
					<div class="current grow-v-animation" style="height: {{$analysis['goal_value']}}%;">
						{{$analysis['goal_values']}}  %
					</div>

				</div>
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