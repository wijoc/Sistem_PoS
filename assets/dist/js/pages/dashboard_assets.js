$(document).ready(function(){
    // Donut Chart
    $.ajax({
        url     : chart_url,
        //type    : 'GET',
        //data    : {filter_keyword : $("input[name='postSearch']").val(), filter_order : $("#contact-order").val()},
        datatype    : 'json',
        success     : function(result){
          if(result.chart_type == 'doughnut' || result.chart_type == 'pie'){
            doughnatChart(result)
          }
        }
    })
})

/** Chart Doughnat */
function doughnatChart(data){
  var pieChartCanvas = $(String(data.canvas)).get(0).getContext('2d')
  var pieData        = {
    labels: data.label,
    datasets: [
      {
        data: data.product,
        backgroundColor : data.color,
      }
    ]
  }
  var pieOptions = {
    legend: {
      display: true
    },
    maintainAspectRatio : false,
    responsive : true,
  }
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  var pieChart = new Chart(pieChartCanvas, {
    type: data.chart_type,
    data: pieData,
    options: pieOptions      
  })
}