@extends('layouts.app')
@section('content')
  <div class="container">
    @include('layouts.partials.main-chart-partial')

    @foreach($trend_analysis as $key => $analysis)
      @include('layouts.partials.trend-analysis-chart-partial')
    @endforeach
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
      var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
      };

      var ctx = document.getElementById("line-chart-"+id).getContext('2d');
      // var ctx = canvas.getContext("2d");
      dataSet =[];
      label = '';
      if(data_value.length > 1) {
        for (var i = 0; i < data_value.length; i++) {
          currSet = {
            label: data_value[i].title,
            borderColor: colors[i],
            borderWidth: 2,
            fill: false,
            data: data_value[i].values
          };
          dataSet.push(currSet);
          label = data_value[0].periods;
        };
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
            text: 'Chart.js Drsw Line on Chart'
          },
          tooltips: {
            mode: 'index',
            intersect: true
          },
        }
      });
    }

    function pieChart(id, data_value, labels) {
      var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
      };

      var config = {
        type: 'pie',
        data: {
          datasets: [{
            data: [
              data_value,
              100 - data_value,
            ],
            backgroundColor: [
              'rgb(29, 192, 255)'
            ],
            label: 'Dataset 1'
          }],
          labels: [
            labels[0],
            labels[1],
          ]
        },
        options: {
          responsive: true,
          pieceLabel: {
            render: 'percentage',
            fontColor: ['white', 'rgba(54, 162, 235, 0.8)'],
            precision: 2
          }
        }
      };

      var ctx = document.getElementById('chart-area-'+ id).getContext('2d');
      window.myPie = new Chart(ctx, config);
    }
  </script>
@endsection
