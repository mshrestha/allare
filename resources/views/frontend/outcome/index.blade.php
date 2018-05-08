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
              @php
                $counter = 0;
              @endphp
              @foreach($trend_analysis as $key => $analysis)
                @include('frontend.outcome.partials.outcome-trend-analysis-partial')
                @php
                $counter = $counter + 1;
              @endphp
              @endforeach
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

      var dataCSV = [];
      for (var i = 0; i < data_value.values.length; i++) {
        temp = {};
        temp.date = data_value.periods[i];
        temp.value = data_value.values[i];
        dataCSV.push(temp);
      };

      dataCSV.forEach(function(d) {
        d.date = d3.time.format("%Y").parse(d.date);
      });

      var margin = {top: 20, right: 20, bottom: 30, left: 50},
          width = 500 - margin.left - margin.right,
          height = 300 - margin.top - margin.bottom;

      var x = d3.time.scale()
                .range([0, width])
                .domain([d3.max(dataCSV, function(d) { return d.date; }), d3.min(dataCSV, function(d) { return d.date; })]);

      // var x = d3.scale.linear()
      //     .domain([0, d3.max(dataCSV, function(d) { return d.date; })])
      //     .range([0, width]);

      var y = d3.scale.linear()
          .domain([0, d3.max(dataCSV, function(d) { return d.value; })])
          .range([height, 0]);

      var xAxis = d3.svg.axis()
          .scale(x)
          .orient("bottom");

      var yAxis = d3.svg.axis()
          .scale(y)
          .orient("left");

      var area = d3.svg.area()
          .x(function(d) { return x(d.date); })
          .y0(height)
          .y1(function(d) { return y(d.value); });

      var svg = d3.select("#line-chart-"+id)
          .attr("width", width + margin.left + margin.right)
          .attr("height", height + margin.top + margin.bottom)
        .append("g")
          .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

      svg.append("path")
          .datum(dataCSV)
          .attr("class", "area")
          .attr("d", area);

      // svg.append("g")
      //     .attr("class", "x axis")
      //     .attr("transform", "translate(0," + height + ")")
      //     .call(xAxis);

      // svg.append("g")
      //     .attr("class", "y axis")
      //     .call(yAxis);

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

  <script>
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    $('.tab-col-subtitle').html((months[new Date().getMonth()])+" "+(new Date().getFullYear()));
  </script>
@endsection
