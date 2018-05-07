@extends('layouts.app')
@section('content')
	<div class="container">

    {{-- tabcontent start  --}}

    <div class="tab-content mt-3">
      <div class="row">
        <div class="col-12">
          <div class="box-heading float-left ml-0">OUTCOMES</div>
          <div class="swiper-tab-nav">
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="#slide0">STUNTING</a>
              </li>
              <li class="list-inline-item">
                <a href="#slide1">WASTING</a>
              </li>
              <li class="list-inline-item">
                <a href="#slide2">EXCLUSIVE BREASTFEEDING</a>
              </li>
            </ul>
          </div> {{-- swiper-tab-nav --}}
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          {{-- tab slide swiper --}}
          <!-- Swiper -->
          <div class="swiper-container swiper-tab" id="swiper-tab-outcome">
            <div class="swiper-wrapper">
              <div class="swiper-slide" data-hash="slide0">
                <div class="row">
                  <div class="col-xl-2 col-lg-3 col-sm-4">
                    <div class="tab-col-title">title</div>
                    <div class="tab-col-subtitle"> date</div>
                    <div id="canvas-holder">
                      CHART GOES HERE
                    </div>
                  </div> {{-- col-xs-2 --}}
                  <div class="col-xl-5 offset-xl-1 pr-xl-0 col-lg-6 col-sm-8">
                    <div class="tab-col-title">People Counselled on Maternal Health</div>
                    <div class="tab-col-subtitle">Jan 14 - Feb 18</div>
                    <div id="canvas-holder">
                      LINECHART HERE
                    </div>
                  </div> {{-- col-xs-5 --}}
                  <div class="col-xl-3 offset-xl-1 report-col col-lg-3">
                    <div class="tab-col-title">Reports on Maternal Health</div>
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
              <div class="swiper-slide" data-hash="slide1">
                <div class="row">
                  <div class="col-xl-2 col-lg-3 col-sm-4">
                    <div class="tab-col-title">title</div>
                    <div class="tab-col-subtitle"> date</div>
                    <div id="canvas-holder">
                      CHART GOES HERE
                    </div>
                  </div> {{-- col-xs-2 --}}
                  <div class="col-xl-5 offset-xl-1 pr-xl-0 col-lg-6 col-sm-8">
                    <div class="tab-col-title">People Counselled on Maternal Health</div>
                    <div class="tab-col-subtitle">Jan 14 - Feb 18</div>
                    <div id="canvas-holder">
                      LINECHART HERE
                    </div>
                  </div> {{-- col-xs-5 --}}
                  <div class="col-xl-3 offset-xl-1 report-col col-lg-3">
                    <div class="tab-col-title">Reports on Maternal Health</div>
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
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination invisible"></div>  
            <!-- Add Arrows -->
            <div class="swiper-button-next invisible"></div>
            <div class="swiper-button-prev invisible"></div>
          </div>
          {{-- tab slide swiper end --}}
        </div>
      </div>
  </div>

  {{-- tabcontent end --}}

		{{-- @include('layouts.partials.main-chart-partial') --}}
       {{-- {{dd($trend_analysis)}} --}}
		@foreach($trend_analysis as $key => $analysis)
			@include('frontend.outcome.partials.outcome-trend-analysis-partial')
		@endforeach
	</div>
@endsection

@section('injavascript')
  // <script>
  // $(document).ready(function() {
  // });

  // var affectedExists = 0;
  // var Divisions = '';
  // var Programme = '';
  // var AffectedArrs = '';
  // var ctxMain = document.getElementById("mainChart").getContext('2d');
  // ctxMain.height = 500;
  // var mainChart;
  var colors = [
      'rgba(255, 99, 132, 0.8)',
      'rgba(54, 162, 235, 0.8)',
      'rgba(255, 206, 86, 0.8)',
      'rgba(75, 192, 192, 0.8)',
      'rgba(153, 102, 255, 0.8)',
      'rgba(255, 519, 64, 0.8)',
      'rgba(25, 59, 64, 0.8)',
      'rgba(55, 159, 64, 0.8)',
      'rgba(255, 15, 64, 0.8)',
      'rgba(255, 59, 64, 0.8)',
      'rgba(255, 59, 4, 0.8)',
      'rgba(255, 239, 64, 0.8)',
      'rgba(255, 19, 124, 0.8)',
      'rgba(55, 219, 64, 0.8)',
      'rgba(25, 39, 114, 0.8)',
      'rgba(215, 19, 164, 0.8)',
      'rgba(252, 129, 64, 0.8)',
  ];

  // function charts(datasets, labels) {
  //     // console.log(datasets);
  //     window.mainChart = new Chart(ctxMain, {
  //         type: 'bar',
  //         data: datasets,
  //         options: {
  //             title: {
  //                 display: true,
  //                 text: labels
  //             },
  //             tooltips: {
  //              mode: 'index',
  //              intersect: false
  //             },
  //             responsive: true,
  //             maintainAspectRatio: false,
  //             scales: {
  //                 xAxes: [{
  //                     stacked: true,
  //                 }],
  //                 yAxes: [{
  //                     stacked: true
  //                 }]
  //             },
  //             // Container for pan options
  //             // pan: {
  //             //     // Boolean to enable panning
  //             //     enabled: true,

  //             //     // Panning directions. Remove the appropriate direction to disable
  //             //     // Eg. 'y' would only allow panning in the y direction
  //             //     mode: 'xy'
  //             // },

  //             // // Container for zoom options
  //             // zoom: {
  //             //     // Boolean to enable zooming
  //             //     enabled: true,

  //             //     // Zooming directions. Remove the appropriate direction to disable
  //             //     // Eg. 'y' would only allow zooming in the y direction
  //             //     mode: 'xy',
  //             // }
  //         }
  //     });
  // }

  
  // </script>
@endsection

@section('outjavascript')
  <script>
  //   $('#main-chart-form').on('submit', function() {
  //     formData = $(this).serialize();
  //     indicator = $('#indicator_id').val();
  //     department = $('#department_id').val();
  //     title = $("#indicator_id option[value="+indicator+"]").text()
  //     dataSets = [];
  //     $.ajax({
  //         type: 'post',
  //         url: '/outcomes/get-outcome-data',
  //         data: $(this).serialize(),
  //         success: function (res) {
  //             labels = res['labels'];
  //             data = res['data'];
  //             titles = res['titles'];
  //             console.log(titles);
  //             if(res['mixed'] == 1) {
  //                 for(var i = 0; i < data.length; i++) {
  //                    dataSets.push({
  //                         'label': titles[i],
  //                         'data': data[i],
  //                         'stack': 'Stack 0',
  //                         'backgroundColor': colors[i]
  //                     // 'borderColor': bgColor,
  //                     // 'borderWidth': 1
  //                     }); 
  //                 } 
  //             } else {
  //                 dataSets.push({
  //                     'label': titles[0],
  //                     'data': data,
  //                     'backgroundColor': colors[0]
  //                 // 'borderColor': bgColor,
  //                 // 'borderWidth': 1
  //                 }); 
  //             }
              
  //             if(window.mainChart != undefined){
  //                 window.mainChart.destroy();
  //             }
  //             dataSets = {labels: labels, datasets: dataSets};
  //             console.log(dataSets);

  //             charts(dataSets, title);
  //         },
  //         error: function(res) {
  //             console.log('failed')
  //         }
  //     })

  //     return false;
  // });

    @foreach($trend_analysis as $key => $analysis)
      var arr = {!! json_encode($analysis) !!};
      trendAnalysisChart('{{ $key }}', arr)
    @endforeach

    function trendAnalysisChart(id, data_value) {
      var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
      };

      var ctx = document.getElementById("line-chart-"+id).getContext('2d');
      // var ctx = canvas.getContext("2d");
      dataSet =[];
      label = '';
      if(data_value.length > 1) {
        // for (var i = 0; i < data_value.length; i++){
          currSet = {
            label: data_value[0].title,
            borderColor: colors[0],
            borderWidth: 2,
            fill: false,
            data: data_value[0].values
          };
          dataSet.push(currSet);
          label = data_value[0].periods;
        // };
      } else {
        currSet = {
            label: data_value.title,
            borderColor: colors[0],
            borderWidth: 2,
            fill: false,
            data: data_value.values
          };
        dataSet.push(currSet);
        label = data_value.periods;
      }
      data = {labels: label, datasets: dataSet};
      window.myTrendChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
          responsive: true,
          title: {
            display: true,
            // text: 'Chart.js Drsw Line on Chart'
          },
          tooltips: {
            mode: 'index',
            intersect: true
          },
          maintainAspectRatio: true,
        }
      });
    }
  </script>
  <script src="{{asset('js/swiper.min.js')}}"></script>
  <script>
     var swiper = new Swiper('#swiper-tab-outcome', {
      spaceBetween: 30,
      hashNavigation: {
        watchState: true,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  </script>
@endsection
