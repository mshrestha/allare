<div class="swiper-slide" data-hash="slide{{$key}}">
  <div class="row">
    <div class="col-xl-2">
      <div class="tab-col-title">{{$analysis['name']}}</div>
      <div class="tab-col-subtitle"> {{strtoupper($analysis['current_month'])}}</div>
      <div id="canvas-holder">
				<canvas id="chart-area-{{ $key }}"></canvas>
			</div>
    </div> {{-- col-xs-2 --}}
    <div class="col-xl-5">
      <div class="tab-col-title">People Counselled on Maternal Health</div>
      <div class="tab-col-subtitle">Jan 14 - Feb 18</div>
      <div id="canvas-holder">
				<canvas id="line-chart-{{ $key }}"></canvas>
			</div>
    </div> {{-- col-xs-5 --}}
    <div class="col-xl-5">
	    <div class="row">
		    <div class="col-xl-5">
		      <div class="tab-col-title">Reports on Maternal Health</div>
		      <div class="tab-col-subtitle">Jan 14 - Feb 18</div>
		      
		    </div> {{-- col-xs-5 --}}
		    <div class="col-xl-5">
		      <div class="tab-col-title">Reports on Maternal Health</div>
		        <div class="report-list">repot list</div>
		    </div> {{-- col-xs-5 --}}
	    </div>
    </div>
  </div>
</div>