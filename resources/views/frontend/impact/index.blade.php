@extends('layouts.app')
@section('styles')
<style>
.axis path, .axis line {
  fill: none;
  stroke: #fff;
}
.axis path {
  stroke: #9f9f9f !important;
}
.axis line {
  stroke: #9f9f9f !important;
}
.axis text {
  font-size: 13px;
  fill: #9f9f9f;
}
.areachart {
    fill: #9fdfd0;
  }

svg text.label {
  fill:white;
  font: 15px;  
  font-weight: 400;
  text-anchor: middle;
}
</style>
@section('content')
  <div class="white-bg"></div>
	<div class="container">

    {{-- tabcontent start  --}}

    <div class="tab-content mt-3">
      <div class="row">
        <div class="col-12">
          <div class="box-heading float-left ml-0 mr-1">IMPACTS</div>
          <div class="swiper-tab-nav">
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="#slide0" class="swipernav nav-slide0 active">STUNTING</a>
              </li>
              <li class="list-inline-item">
                <a href="#slide1" class="swipernav nav-slide1">WASTING</a>
              </li>
              <li class="list-inline-item">
                <a href="#slide2" class="swipernav nav-slide2">EXCLUSIVE BREASTFEEDING</a>
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
                @include('frontend.impact.partials.outcome-trend-analysis-partial')
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
    @php
      $counter = 0;
    @endphp
    @foreach($trend_analysis as $key => $analysis)
      var arr = {!! json_encode($analysis) !!};
      trendAnalysisChart('{{ $counter }}', arr)
      @php
        $counter = $counter + 1;
      @endphp
    @endforeach

    
    function trendAnalysisChart(id, data_value) {
      var startDate, endDate;
      var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
      };

      var interpolateTypes = ['linear','step-before','step-after','basis','basis-open','basis-closed','bundle','cardinal','cardinal-open','cardinal-closed','monotone'];

      var dataCSV = [];

      for (var i = data_value.values.length - 1; i > 0; i--) {
        temp = {};
        if(data_value.periods[i] == '1993-1994') {
          temp.date = '1994';
        }else if(data_value.periods[i] == '1996-1997') {
          temp.date = '1997';
        }else if(data_value.periods[i] == '1999-2000') {
          temp.date = '2000';
        }else {
          temp.date = data_value.periods[i];
        }
        // if(i == 0)
        //   startDate = temp.date;
        // if(i == data_value.values.length - 1)
        //   endDate = temp.date;
        temp.value = data_value.values[i];
        dataCSV.push(temp);
      };

      startDate = dataCSV[dataCSV.length - 1].date;
      endDate = dataCSV[0].date;
      var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      $('.specific-date').html((months[new Date().getMonth()])+" "+(new Date().getFullYear()));
      $('#area-date-'+id).html(startDate + ' - ' + endDate);


      // dataCSV.forEach(function(d) {
      //   d.date = d3.time.format("%Y").parse(d.date);
      // });


      var parentDiv = document.getElementById('area-chart-'+id);
      var margin = {top:20, right:20, bottom:20, left:20};
      var w = parentDiv.clientWidth, h = parentDiv.clientHeight;  
      var margin = {top: 20, right: 20, bottom: 30, left: 50},
          width = w - margin.left - margin.right,
          height = h - margin.top - margin.bottom;

      var x = d3.time.scale()
                .range([0, width])
                .domain([d3.min(dataCSV, function(d) { return d.date; }), d3.max(dataCSV, function(d) { return d.date; })]);

      // var x = d3.scale.linear()
      //     .domain([0, d3.max(dataCSV, function(d) { return d.date; })])
      //     .range([0, width]);
      var xScale = d3.scale.ordinal().rangeRoundBands([width, 0], .03)
      var yScale = d3.scale.linear()
                        .range([height, 0]);
      var xAxis = d3.svg.axis()
                      .scale(xScale)
                      .orient("bottom");
                        
                        
      var yAxis = d3.svg.axis()
          .scale(yScale)
          .orient("left");

      var y = d3.scale.linear()
          .domain([0, d3.max(dataCSV, function(d) { return parseInt(d.value); })])
          .range([height, 0]);

      var svgContainer = d3.select("#line-chart-"+id)
                      .attr("width", width+margin.left + margin.right)
                      .attr("height",height+margin.top + margin.bottom)
                      .append("g").attr("class", "container")
                      .attr("transform", "translate("+ margin.left +","+ margin.top +")");

      xScale.domain(dataCSV.map(function(d) { return d.date; }));
      yScale.domain([0, d3.max(dataCSV, function(d) { return parseInt(d.value); })]);
      var xAxis_g = svgContainer.append("g")
                      .attr("class", "x axis")
                      .attr("transform", "translate(0," + (height) + ")")
                      .call(xAxis)
                      .selectAll("text");

      var yAxis_g = svgContainer.append("g")
                      .attr("class", "y axis")
                      .call(yAxis)
                      .append("text")
                      .attr("transform", "rotate(-90)")
                      .attr("y", 6).attr("dy", ".71em")
                      //.style("text-anchor", "end").text("Number of Applicatons"); 
      svgContainer.selectAll(".areachart")
                      .data(dataCSV)
                      .enter()
                      .append("rect")
                      .attr("class", "areachart")
                      .attr("x", function(d) { return xScale(d.date); })
                      .attr("width", xScale.rangeBand())
                      .attr("y", function(d) { return yScale(d.value); })
                      .attr("height", function(d) { return height - yScale(d.value); });

      document.addEventListener("DOMContentLoaded", resize);
      d3.select(window).on('resize', resize);
      function resize() {
        // console.log('----resize function----');
        // update width
        width = parseInt(d3.select("#area-chart-"+id).style('width'), 10);
        width = parseInt(width - margin.left - margin.right);

        height = parseInt(d3.select("#area-chart-"+id).style("height"));
        height = parseInt(height - margin.top - margin.bottom);
        // console.log('----resiz width----'+width);
        // console.log('----resiz height----'+height);
        // resize the chart
        
          xScale.range([width, 0]);
          xScale.rangeRoundBands([width, 0], .03);
          yScale.range([height, 0]);

          yAxis.ticks(Math.max(height/50, 2));
          xAxis.ticks(Math.max(width/50, 2));

          d3.select(svgContainer.node().parentNode)
              .style('width', (width + margin.left + margin.right) + 'px');

          svgContainer.selectAll('.areachart')
            .attr("x", function(d) { return xScale(d.date); })
            .attr("width", xScale.rangeBand());    

          // svgContainer.select('.x.axis').call(xAxis.orient('bottom')).selectAll("text").attr("y",10).call(wrap, xScale.rangeBand());
          // Swap the version below for the one above to disable rotating the titles
          // svgContainer.select('.x.axis').call(xAxis.orient('top')).selectAll("text").attr("x",55).attr("y",-25);
      }

      function wrap(text, width) {
        text.each(function() {
          var text = d3.select(this),
              words = text.text().split(/\s+/).reverse(),
              word,
              line = [],
              lineNumber = 0,
              lineHeight = 1.1, // ems
              y = text.attr("y"),
              dy = parseFloat(text.attr("dy")),
              tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y).attr("dy", dy + "em");
          while (word = words.pop()) {
            line.push(word);
            tspan.text(line.join(" "));
            if (tspan.node().getComputedTextLength() > width) {
              line.pop();
              tspan.text(line.join(" "));
              line = [word];
              tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
            }
          }
        });
      }
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
    
  </script>

  <script> 
    if(location.hash.slice(1)) {
      $('.swipernav').removeClass('active');
      $('.nav-'+ location.hash.slice(1)).addClass('active');
    }

    $(window).on('hashchange',function(){ 
        $('.swipernav').removeClass('active');
        $('.nav-'+ location.hash.slice(1)).addClass('active');
    });
  </script>
@endsection
