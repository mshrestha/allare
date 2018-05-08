@extends('layouts.app')
@section('content')
  <div class="container">
    @include('layouts.partials.main-chart-partial')

    {{-- tabcontent start  --}}

    <div class="tab-content mt-3">
      <div class="row">
        <div class="col-12">
          <div class="box-heading float-left ml-0">MATERNAL</div>
          <div class="swiper-tab-nav">
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="#slide0">Counselling</a>
              </li>
              <li class="list-inline-item">
                <a href="#slide1">IFA DISTRIBUTION</a>
              </li>
              <li class="list-inline-item">
                <a href="#slide2">WEIGHT MEASUREMENT</a>
              </li>
            </ul>
          </div> {{-- swiper-tab-nav --}}
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          {{-- tab slide swiper --}}
          <!-- Swiper -->
          <div class="swiper-container swiper-tab" id="swiper-tab">
            <div class="swiper-wrapper">
              @foreach($trend_analysis as $key => $analysis)
                @include('layouts.partials.trend-analysis-chart-partial')
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
  </div>
@endsection

@section('outjavascript')
<script src="{{ asset('js/Chart.PieceLabel.min.js') }}"></script>

<script>
// $('.side-filter-div').height($('#mainChart').height()-30+8);
$(document).ready(function() {
    $('#affected-id').parent().hide();
});

var affectedExists = 0;
var Divisions = '';
var Programme = '';
var AffectedArrs = '';
var mainChartCtx = document.getElementById("mainChart").getContext('2d');
mainChartCtx.height = 500;
var mainChart;
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
]

function charts(datasets, labels) {
    // console.log(datasets);
    window.mainChart = new Chart(mainChartCtx, {
        type: 'bar',
        data: datasets,
        options: {
            title: {
                display: true,
                text: labels
            },
            // tooltips: {
            //  mode: 'index',
            //  intersect: false
            // },
            // responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            },
            // Container for pan options
            pan: {
                // Boolean to enable panning
                enabled: true,

                // Panning directions. Remove the appropriate direction to disable
                // Eg. 'y' would only allow panning in the y direction
                mode: 'xy'
            },

            // Container for zoom options
            zoom: {
                // Boolean to enable zooming
                enabled: false,

                // Zooming directions. Remove the appropriate direction to disable
                // Eg. 'y' would only allow zooming in the y direction
                mode: 'xy',
            }
        }
    });
  }
    $(document).ready(function() {
      $("#organisation_unit_id").val("mykF7AaZv9R.mykF7AaZv9R");
      var organisation_unit_id = $("#organisation_unit_id").val();

      $("#period_id").val("LAST_6_MONTHS");
      var period_id = $("#period_id").val();
      
      $("#indicator_id").val("maternal_counselling");
      var indicator_id = $("#indicator_id").val();
      
      $("#department_id").val("DGHS");
      var department_id = $("#department_id").val();
      
      var output = 'maternal';

      var data = 'organisation_unit_id='+organisation_unit_id+'&period_id='+period_id+'&indicator_id='+indicator_id+'&department_id='+department_id+'&output='+output;
      data += "&_token={{ Session::token() }}";

      main_chart_data(data);

    });

    function main_chart_data(data) {
        $.ajax({
            type: 'POST',
            url: '/outputs/maternal-main-chart',
            data: data,
            success: function (res) {
                dataSets = { 
                    labels: res.labels, 
                    datasets: [{
                        label: res.pointers,
                        data: res.datasets,
                        backgroundColor: 'rgb(29, 192, 255)',
                    }]
                };

                title = res.title;

                if (window.mainChart != undefined) {
                    window.mainChart.destroy();
                }

                charts(dataSets, title);

            }, error : function () {
                console.log('error');
            }
        })
    }

    $('#main-chart-form').on('submit', function() {
        var data = $(this).serialize();
        data += '&output=maternal';

        main_chart_data(data);

        return false;
    });

    @foreach($trend_analysis as $key => $analysis)
        pieChart({{ $key }}, {{ $analysis['percent'] }}, {!! $analysis['labels'] !!})
        var arr = {!! json_encode($analysis) !!};
        trendAnalysisChart('{{ $key }}', arr)
    @endforeach

    

    function trendAnalysisChart(id, data_value) {
      var interpolateTypes = ['linear','step-before','step-after','basis','basis-open','basis-closed','bundle','cardinal','cardinal-open','cardinal-closed','monotone'];
      var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
      };

      var dataCSV = [];
      var max = 0;
      var origValues = [];
      var processedValues = [];
      for (var i = 0; i < data_value.values.length; i++) {
        temp = {};
        temp.date = data_value.periods[i];
        temp.value = data_value.values[i];
        if(max < temp.value)
          max = temp.value;

        dataCSV.push(temp);
      };

      origDataCSV = dataCSV;

      dataCSV.forEach(function(d) {
        origValues.push(d.value);
        processedValues.push(d.value/max);
        d.value = d.value / max;
      });

       var margin = {top: 20, right: 20, bottom: 20, left: 60},
          width = 500 - margin.left - margin.right,
          height = 300 - margin.top - margin.bottom;

      var x = d3.time.scale()
                .range([0, width])
                .domain([d3.max(dataCSV, function(d) { return d.date; }), d3.min(dataCSV, function(d) { return d.date; })]);

      // var x = d3.scale.linear()
      //     .domain([0, d3.max(dataCSV, function(d) { return d.date; })])
      //     .range([0, width]);

      var y = d3.scale.linear()
          .domain([0, d3.max(origDataCSV, function(d) {return d.value; })])
          .range([height, 0]);

      var ydash = d3.scale.linear()
          .domain([0, d3.max(dataCSV, function(d) {return d.value; })])
          .range([height, 0]);

      console.log(max);

      var xAxis = d3.svg.axis()
          .scale(x)
          .orient("bottom")
          .innerTickSize(-height)
          .outerTickSize(0)
          .ticks(5)
          .tickPadding(20);

      var yAxis = d3.svg.axis()
          .scale(y)
          .orient("left")
          .innerTickSize(-width)
          .outerTickSize(0)
          .ticks(5)
          .tickPadding(20);
          // .tickValues(processedValues)
          // .tickFormat(function(x){return origValues[processedValues.indexOf(x)];});

      var area = d3.svg.area()
          .x(function(d) { return x(d.date); })
          .y0(height)
          .y1(function(d) { return ydash(d.value); })
          .interpolate(interpolateTypes[6]);

      var svg = d3.select("#line-chart-"+id)
          .attr("width", width + margin.left + margin.right)
          .attr("height", height + margin.top + margin.bottom)
          .attr("class", "areachart")
        .append("g")
          .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
      
      svg.append("path")
          .datum(dataCSV)
          .attr("class", "area")
          .attr("d", area);

      svg.append("g")
          .attr("class", "grid")
          .call(yAxis)

      
    }

    function pieChart(id, data_value, labels) {
      var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
      };
      var w = 300,                        
      h = 300,                            
      r = 100,                            
      color = ['#fba69c', '#d2d2d2'];     
      dataCSV = [{"label": data_value+"%", "value": data_value}, 
                {"label":  100 - data_value+"%", "value": 100 - data_value}]
      var vis = d3.select('#chart-area-'+ id)
        .data([dataCSV])                   
            .attr("width", w)           
            .attr("height", h)
        .append("svg:g")                
            .attr("transform", "translate(" + r + "," + r + ")")

      var arc = d3.svg.arc()
          .outerRadius(r);

      var pie = d3.layout.pie()
          .value(function(d) { return d.value; });    

      var arcs = vis.selectAll("g.slice")     
        .data(pie)                          
        .enter()                            
            .append("svg:g")                
                .attr("class", "slice");    

        arcs.append("svg:path")
                .attr("fill", function(d, i) { return color[i]; } ) 
                .attr("d", arc);                                    
        arcs.append("svg:text")                                     
                .attr("transform", function(d) {                   
                d.innerRadius = 0;
                d.outerRadius = r;
                return "translate(" + arc.centroid(d) + ")";        
            })
            .attr("text-anchor", "middle")                         
            .text(function(d, i) { return dataCSV[i].label; })
            .style("fill", function(d, i) { if(i==0) return color[1]; else return color[0]; } )
            .style("font-size", "13px")
            .style("font-weight", "bold");
      // var config = {
      //   type: 'pie',
      //   data: {
      //     datasets: [{
      //       data: [
      //         data_value,
      //         100 - data_value,
      //       ],
      //       backgroundColor: [
      //         '#fba69c'
      //       ],
      //       label: 'Dataset 1'
      //     }],
          
      //   },
      //   options: {
      //     responsive: false,
      //     pieceLabel: {
      //       render: 'percentage',
      //       fontColor: ['white', '#fba69c'],
      //       precision: 2
      //     },
      //     tooltips: false
      //   }
      // };

      // var ctx = document.getElementById('chart-area-'+ id).getContext('2d');
      // window.myPie = new Chart(ctx, config);
    }
  </script>
  <script src="{{asset('js/swiper.min.js')}}"></script>
  <script>
     var swiper = new Swiper('#swiper-tab', {
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
       onSlideChangeEnd: function (swiper) {
          console.log('slide change end - after');
          console.log(swiper);
          console.log(swiper.activeIndex);
          //after Event use it for your purpose
          if (swiper.activeIndex == 1) {
              //First Slide is active
              console.log('First slide active')
          }
      }
    });
  </script>
@endsection
