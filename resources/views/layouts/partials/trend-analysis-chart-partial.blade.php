<div class="swiper-slide" data-hash="slide{{$key}}">
  <div class="row">
    <div class="col-xl-3 col-lg-3 col-sm-4">
      <div class="tab-col-title">{{$analysis['name']}}</div>
{{-- <<<<<<< HEAD
      <div class="tab-col-subtitle"> {{strtoupper($analysis['current_month'])}}</div>
======= --}}
      <div class="tab-col-subtitle specific-date"> {{strtoupper($analysis['current_month'])}}</div>
      <div class="canvas-holder pie-chart" id="pie-chart-{{ $key }}">
      {{-- <div id="canvas-holder">
>>>>>>> 1d0f6dc195de0557c17d27d1f1676607ccbfcee0 --}}
				<svg id="chart-area-{{ $key }}"></svg>
			</div>
    </div> {{-- col-xs-2 --}}
    <div class="col-xl-5 pr-xl-0 col-lg-6 col-sm-8">
      <div class="tab-col-title">People Counselled on {{$analysis['name']}}</div>
{{-- <<<<<<< HEAD
      <div class="tab-col-subtitle">Jan 14 - Feb 18</div>
      <div class="canvas-holder">
======= --}}
      <div class="tab-col-subtitle area-date">Jan 14 - Feb 18</div>
      <div class="canvas-holder" id="area-chart-{{ $key }}">
{{-- >>>>>>> 1d0f6dc195de0557c17d27d1f1676607ccbfcee0 --}}
				<svg id="line-chart-{{ $key }}"></svg>
			</div>
    </div> {{-- col-xs-5 --}}
    <div class="col-xl-3 offset-xl-1 report-col col-lg-3">
			<div class="tab-col-title">Reports on {{$analysis['name']}}</div>
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