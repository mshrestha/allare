<div class="swiper-slide" data-hash="slide{{$key}}">
  <div class="row">
    <div class="col-xl-2 col-lg-3 col-sm-4">
      <div class="tab-col-title">{{$analysis['name']}}</div>
      <div class="tab-col-subtitle"> {{strtoupper($analysis['current_month'])}}</div>
      <div id="canvas-holder">
				<canvas id="chart-area-{{ $key }}"></canvas>
			</div>
    </div> {{-- col-xs-2 --}}
    <div class="col-xl-5 offset-xl-1 pr-xl-0 col-lg-6 col-sm-8">
      <div class="tab-col-title">People Counselled on {{$analysis['name']}}</div>
      <div class="tab-col-subtitle">Jan 14 - Feb 18</div>
      <div id="canvas-holder">
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