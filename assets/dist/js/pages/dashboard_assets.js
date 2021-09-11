$(document).ready(function(){
    // Donut Chart
    $.ajax({
        url     : chart_url,
        //type    : 'GET',
        //data    : {filter_keyword : $("input[name='postSearch']").val(), filter_order : $("#contact-order").val()},
        datatype    : 'json',
        success     : function(result){
          if(result.user == 'o'){
            barChart(result.monthlySP)
            barChart(result.monthlyRE)
            $('#nav-o-chart .nav-link').on("click", function(){
              $("#chart-title span").html('Grafik '+ $(this).attr("data-name") +' per Bulan')
            })
          } else if (result.user == 'admp') {

          } else if (result.user == 'k') {

          } else if (result.user == 'g') {
            doughnatChart(result)
          } else {

          }
        }
    })
})

/** Chart Doughnat */
function doughnatChart(d){
  var donutChartCanvas = $(d.canvas).get(0).getContext('2d')
  var donutData        = {
    labels: d.label,
    datasets: [
      {
        data: d.product,
        backgroundColor : d.color,
      }
    ]
  }
  var donutOptions     = {
    maintainAspectRatio : false,
    responsive : true,
  }
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  var donutChart = new Chart(donutChartCanvas, {
    type: d.chart_type,
    data: donutData,
    options: donutOptions      
  })
}

/** Chart Line */
function barChart(d){
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode      = 'index'
  var intersect = true

  var $barChart = $(d.canvas)
  var barChart  = new Chart($barChart, {
    type   : d.type,
    data   : {
      labels  : d.labels,
      datasets: d.data
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: d.legend
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }
              return 'Rp' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })
}