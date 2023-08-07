@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="d-flex flex-row justify-content-between">
    <div>
        <h1>Dashboard</h1>
    </div>
    {{-- <div>
        <div class="row">
            <div class="col">
                <x-adminlte-select2 class="w-100" data-placeholder='Pilih provinsi' name="sel2Basic">
                    <option />
                    <option>Option 11111111111</option>
                    <option>Option 2</option>
                    <option>Option 3</option>
                </x-adminlte-select2>
            </div>
            <div class="col">
                <x-adminlte-select2 class="w-100" data-placeholder='Pilih provinsi' name="sel2Basi">
                    <option />
                    <option>Option 11111111111</option>
                    <option>Option 2</option>
                    <option>Option 3</option>
                </x-adminlte-select2>
            </div>
        </div>
    </div> --}}
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-adminlte-card title="Grafik Stunting">
            <div class="chart">
                <canvas id="barChart"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </x-adminlte-card>
    </div>
    <div class="col-md-12">
        <x-adminlte-card title="Grafik Status Gizi">
            <div class="chart">
                <canvas id="barGiziChart"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </x-adminlte-card>
    </div>
    <div class="col-md-12">
        <x-adminlte-card title="Grafik Status Berat Badan">
            <div class="chart">
                <canvas id="barBadanChart"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </x-adminlte-card>
    </div>
</div>
<x-adminlte-modal id="modalStunting" title="Data Jumlah Stunting" size="lg" v-centered static-backdrop scrollable>
    <div id="stunting-body"></div>
    <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto" theme="success" label="Accept" />
        <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>

@stop

@push('js')
<script>
    $(function(){

        var label = "{{$kabupaten}}";
        var normal = "{{$jmlNormalKec}}";
        var sangatPendek = "{{$jmlSangatPendekKec}}";
        var kecamatan = label.replace(/&quot;/g, '"');
        var jmlNormalKec = normal.replace(/&quot;/g, '"');
        var jmlSangatPendekKec = sangatPendek.replace(/&quot;/g, '"');
        var areaChartData = {
            labels  : JSON.parse(kecamatan),
            datasets: [
                {
                    label               : 'Tinggi Pendek',
                    backgroundColor     : 'rgb(242, 38, 19)',
                    borderColor         : 'rgb(242, 38, 19)',
                    pointRadius         : false,
                    pointColor          : 'rgb(242, 38, 19)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgb(242, 38, 19)',
                    data                : JSON.parse(jmlSangatPendekKec)
                },
                {
                    label               : 'Tinggi Normal',
                    backgroundColor     : 'rgb(46, 204, 113)',
                    borderColor         : 'rgb(46, 204, 113)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgb(46, 204, 113)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgb(46, 204, 113)',
                    data                : JSON.parse(jmlNormalKec)
                },
            ],
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: true,
                },
                responsive: true,
                maintainAspectRatio: false,
                onClick: graphClickEvent
            }
        }

        var labelGiziKabupaten = "{{$jmlGiziKabupaten}}";
        var jmlGiziNormal = "{{$jmlGiziNormal}}";
        var jmlGiziBuruk = "{{$jmlGiziBuruk}}";
        var jmlObesitas = "{{$jmlObesitas}}";
        var giziKabupaten = labelGiziKabupaten.replace(/&quot;/g, '"');
        var jmlNormalKab = jmlGiziNormal.replace(/&quot;/g, '"');
        var jmlBurukKab = jmlGiziBuruk.replace(/&quot;/g, '"');
        var jmlObesitas = jmlObesitas.replace(/&quot;/g, '"');
        var areaChartGiziData = {
            labels  : JSON.parse(giziKabupaten),
            datasets: [
                {
                    label               : 'Obesitas',
                    backgroundColor     : 'rgb(52, 45, 113)',
                    borderColor         : 'rgb(52, 45, 113)',
                    pointRadius         : false,
                    pointColor          : 'rgb(52, 45, 113)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgb(52, 45, 113)',
                    data                : JSON.parse(jmlBurukKab)
                },
                {
                    label               : 'Gizi Buruk',
                    backgroundColor     : 'rgb(242, 38, 19)',
                    borderColor         : 'rgb(242, 38, 19)',
                    pointRadius         : false,
                    pointColor          : 'rgb(242, 38, 19)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgb(242, 38, 19)',
                    data                : JSON.parse(jmlBurukKab)
                },
                {
                    label               : 'Gizi Normal',
                    backgroundColor     : 'rgb(46, 204, 113)',
                    borderColor         : 'rgb(46, 204, 113)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgb(46, 204, 113)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgb(46, 204, 113)',
                    data                : JSON.parse(jmlNormalKab)
                },
            ],
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: true,
                },
                responsive: true,
                maintainAspectRatio: false,
                onClick: graphClickEvent
            }
        }

        var labelBadanKabupaten = "{{$badanKabupaten}}";
        var jmlBadanNormal = "{{$jmlBadanNormal}}";
        var jmlBadanKurang = "{{$jmlBadanKurang}}";
        var badanKabupaten = labelBadanKabupaten.replace(/&quot;/g, '"');
        var jmlBadanNormal = jmlBadanNormal.replace(/&quot;/g, '"');
        var jmlBadanKurang = jmlBadanKurang.replace(/&quot;/g, '"');
        var areaChartBadanData = {
            labels  : JSON.parse(badanKabupaten),
            datasets: [
                {
                    label               : 'Berat Badan Kurang',
                    backgroundColor     : 'rgb(242, 38, 19)',
                    borderColor         : 'rgb(242, 38, 19)',
                    pointRadius         : false,
                    pointColor          : 'rgb(242, 38, 19)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgb(242, 38, 19)',
                    data                : JSON.parse(jmlBadanKurang)
                },
                {
                    label               : 'Berat Badan Normal',
                    backgroundColor     : 'rgb(46, 204, 113)',
                    borderColor         : 'rgb(46, 204, 113)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgb(46, 204, 113)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgb(46, 204, 113)',
                    data                : JSON.parse(jmlBadanNormal)
                },
            ],
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: true,
                },
                responsive: true,
                maintainAspectRatio: false,
                onClick: graphClickEvent
            }
        }

        var labelKonsulKabupaten = "{{$konsulKabupaten}}";
        var jmlKonsul = "{{$jmlKonsul}}";
        var konsulKabupate = labelKonsulKabupaten.replace(/&quot;/g, '"');
        var jmlKonsul = jmlKonsul.replace(/&quot;/g, '"');
        var areaChartKonsulData = {
            labels  : JSON.parse(konsulKabupate),
            datasets: [
                {
                    label               : 'Jumlah Konsultasi',
                    backgroundColor     : 'rgb(242, 38, 19)',
                    borderColor         : 'rgb(242, 38, 19)',
                    pointRadius         : false,
                    pointColor          : 'rgb(242, 38, 19)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgb(242, 38, 19)',
                    data                : JSON.parse(jmlKonsul)
                },
            ],
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: true,
                },
                responsive: true,
                maintainAspectRatio: false,
                onClick: graphClickEvent
            }
        }

        function graphClickEvent(event, array){
            if(array[0]){
            alert('test')
            }
        }

        var donutData        = {
            labels: [
                'Pendek',
                'Sangat Pendek',
            ],
            datasets: [
                {
                data: ["{{$jmlPendek}}", "{{$jmlSangatPendek}}"],
                backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                }
            ]
        }

        var donutData1        = {
            labels: [
                'Gizi lebih',
                'Gizi normal',
                'Gizi kurang',
            ],
            datasets: [
                {
                data: ["{{$jmlGiziLebih}}", "{{$jmlGiziBaik}}", "{{$jmlGiziKurang}}"],
                backgroundColor : ['#00c0ef', '#3c8dbc', '#d2d6de'],
                }
            ]
        }

        //-------------
        //- BAR CHART STUNTING-
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var bar = new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                onClick: function(evt, element) {
                    var activePoints = bar.getElementAtEvent(evt);
                    let kabupaten = activePoints[0]._model.label;
                    let status = activePoints[0]._model.datasetLabel.replace(/ /g, "_");
                    let kab = kabupaten.replace(/ /g, "_");
                    let url = "{{url('dashboard')}}"+"?stts=reg&param="+kabupaten;
                    let stts = "{{$stts}}";
                    switch(stts){
                        case "reg":
                            window.location.href =  "{{url('dashboard')}}"+"?stts=dis&param="+kabupaten;
                            break;
                        default:
                            window.location.href = url;
                            break;
                    }
                    // $('#stunting-body').append('<p>'+kab+status+'</p>')
                    // $("#modalStunting").modal("show");
                }
            }
        })

        // -------------
        // - BAR CHART GIZI-
        // -------------
        var barChartCanvas = $('#barGiziChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartGiziData)
        var temp0 = areaChartGiziData.datasets[0]
        var temp1 = areaChartGiziData.datasets[1]
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

        // -------------
        // - BAR CHART BADAN-
        // -------------
        var barChartCanvas = $('#barBadanChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartBadanData)
        var temp0 = areaChartBadanData.datasets[0]
        var temp1 = areaChartBadanData.datasets[1]
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

        // -------------
        // - BAR CHART KONSUL-
        // -------------
        var barChartCanvas = $('#barKonsulChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartKonsulData)
        var temp0 = areaChartKonsulData.datasets[0]
        var temp1 = areaChartKonsulData.datasets[1]
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

        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas1 = $('#pieChart1').get(0).getContext('2d')
        var pieData1        = donutData1;
        var pieOptions1     = {
        maintainAspectRatio : false,
        responsive : true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(pieChartCanvas1, {
        type: 'pie',
        data: pieData1,
        options: pieOptions1
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