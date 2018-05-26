<div class="swiper-slide" data-hash="slide{{$key}}">
	<div class="row">
		<div class="col-xl-3 col-lg-3 col-sm-4">
			<div class="tab-col-title">{{$analysis['name']}}</div>
			<div class="tab-col-subtitle specific-date"> {{strtoupper($analysis['current_month'])}}</div>
			<div class="row">
				<div class="input-group mb-1 col-6 col-sm-12 col-md-12 col-lg-12 col-xl-6">
					<select class="custom-select gry-borderd load_period_data" name="period" onchange="loadPeriodWiseData($(this), '{{ $analysis['model'] }}')">
						<option value="2018">2018</option>
						<option value="2017">2017</option>
						<option value="2016">2016</option>
					</select>
				</div>
			</div>
			<div class="canvas-holder pie-chart" id="pie-chart-{{ $key }}">
				<svg id="chart-area-{{ $key }}"></svg>
			</div>
			<div class="pie-legend">
				<span class="legend-text" id="current-text">{{$analysis['name']}} Given</span>
				<span class="legend-text" id="other-text">Total Patients Visited</span>
			</div>
		</div> {{-- col-xs-2 --}}
		<div class="col-xl-6 pr-xl-0 col-lg-6 col-sm-8">
			<div class="tab-col-title">People Counselled on {{$analysis['name']}}</div>
			<div class="tab-col-subtitle area-date">Jan 14 - Feb 18</div>
			<div class="canvas-holder output-area-chart" id="output-area-chart-{{ $key }}">
				<svg id="line-chart-{{ $key }}"></svg>
			</div>
		</div> {{-- col-xs-5 --}}
		<div class="col-xl-3 report-col col-lg-3">
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