@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <x-adminlte-card title="Grafik" >
            <div class="chart">
                <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </x-adminlte-card>
    </div>
    <div class="col-md-6">
        <x-adminlte-card title="Pie Chart" >
            <div class="chart">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </x-adminlte-card>
    </div>
</div>
<x-adminlte-card title="Map" >
    <div class="containerMap">
        <div class="map" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;">Alternative content</div>
    </div>
</x-adminlte-card>
@stop

@push('js')
<script>
    $(function(){
        var areaChartData = {
            labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [
                {
                label               : 'Digital Goods',
                backgroundColor     : 'rgba(60,141,188,0.9)',
                borderColor         : 'rgba(60,141,188,0.8)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : [28, 48, 40, 19, 86, 27, 90]
                },
                {
                label               : 'Electronics',
                backgroundColor     : 'rgba(210, 214, 222, 1)',
                borderColor         : 'rgba(210, 214, 222, 1)',
                pointRadius         : false,
                pointColor          : 'rgba(210, 214, 222, 1)',
                pointStrokeColor    : '#c1c7d1',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data                : [65, 59, 80, 81, 56, 55, 40]
                },
            ]
        }

        var donutData        = {
            labels: [
                'Chrome',
                'IE',
                'FireFox',
                'Safari',
                'Opera',
                'Navigator',
            ],
            datasets: [
                {
                data: [700,500,400,600,300,100],
                backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                }
            ]
        }

        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false
        }

        new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
        })

        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        var pieData        = donutData;
        var pieOptions     = {
        maintainAspectRatio : false,
        responsive : true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
        })

        $(".containerMap").mapael({
        map : {
            name : "world_countries"
        },
        legend : {
            area : {
                title : "Population by country",
                slices : [
                {
                    max : 10000000,
                    attrs : {
                    fill : "#a4e100"
                    },
                    label : "Less than 10M"
                },
                {
                    min : 10000000,
                    max : 50000000,
                    attrs : {
                    fill : "#ffdd00"
                    },
                    label : "Between 10M and 50M"
                },
                {
                    min : 50000000,
                    attrs : {
                    fill : "#ff3333"
                    },
                    label : "More than 50M"
                }
                ]
            }
        },
        
    });
    })
</script>
@endpush