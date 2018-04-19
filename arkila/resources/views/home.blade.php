@extends('layouts.master')
@section('title','Dashboard')
@section('content')
<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua">{{$numberOfOperators}}</span>
            <div class="info-box-content">
              <span class="info-box-text text-center" style="margin: 5px;">Operators</span>
              <span >
                <a type="button" href="{{route('operators.index')}}" class="btn btn-info center-block"><i class="fa fa-eye"></i> View operators</a>
                </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red">{{$numberOfVans}}</span>
            <div class="info-box-content">
              <span class="info-box-text text-center" style="margin: 5px;">Van units</span>
              <span>
                <a href="{{route('vans.index')}}" type="button" class="btn btn-danger center-block"><i class="fa fa-eye"></i> View units</a>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green">{{$numberOfReservations}}</span>

            <div class="info-box-content">
              <span class="info-box-text text-center" style="margin: 5px;">Reservations</span>
              <span>
                <a href="{{route('reservations.index')}}" type="button" class="btn btn-success center-block"><i class="fa fa-eye"></i> View requests</a>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow">{{$numberOfRentals}}</span>
            <div class="info-box-content">
              <span class="info-box-text text-center" style="margin: 5px;">Rentals</span>
              <span>
                  <a href="{{route('rental.index')}}" type="button" class="btn btn-warning center-block"><i class="fa fa-eye"></i> View requests</a>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>

      <!-- solid sales graph -->
      <div class="box box-solid bg-teal-gradient">
        <div class="box-header">
          <i class="fa fa-th"></i>

          <h3 class="box-title">Sales Graph</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <div class="box-body border-radius-none">
          <div class="chart" id="line-chart" style="height: 250px;"></div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-border">
          <div class="row">
            <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
              <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                     data-fgColor="#39CCCC">
              <div class="knob-label">Mail-Orders</div>
            </div>
            <!-- ./col -->
            <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
              <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                     data-fgColor="#39CCCC">
              <div class="knob-label">Online</div>
            </div>
            <!-- ./col -->
            <div class="col-xs-4 text-center">
              <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                     data-fgColor="#39CCCC">
              <div class="knob-label">In-Store</div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-footer -->
      </div>

      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Line Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">

              <div class="chart">
                <canvas id="areaChart" style="height:250px"></canvas>
              </div>
            </div>
            </div>
            <!-- /.box-body -->

          </div>
          <!-- /.box -->

@endsection
@section('scripts')
@parent

  <script>
    $(function() {
       // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Revenues',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
        {
          label               : 'Expenses',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label               : 'Rentals',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 33, 40, 119, 86, 27, 90]
        }
      ]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : false,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions)
       //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas          = $('#lineChart').get(0).getContext('2d')
    var lineChart                = new Chart(lineChartCanvas)
    var lineChartOptions         = areaChartOptions
    lineChartOptions.datasetFill = false
    lineChart.Line(areaChartData, lineChartOptions)
    })
  </script>
@endsection