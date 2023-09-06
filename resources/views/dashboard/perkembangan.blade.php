@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="d-flex flex-row justify-content-between">
    <div>
        <h1>Dashboard Perkembangan</h1>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        <x-adminlte-info-box theme='secondary' title="Jumlah Balita" text="{{$jmlBalita}}" icon="fas fa-lg fa-users" />
    </div>
    <div class="col-md-3">
        <x-adminlte-info-box theme='success' title="Jumlah Balita Normal"
            text="{{$jmlBalita - $jmlBalitaIndikasiStunting}}" icon="fas fa-lg fa-baby-carriage" />
    </div>
    <div class="col-md-3">
        <x-adminlte-info-box theme='warning' title="Jumlah Indikasi Rawan Stunting"
            text="{{$jmlBalitaIndikasiStunting - $jmlBalitaStunting}}" icon="fas fa-lg fa-exclamation-triangle" />
    </div>
    <div class="col-md-3">
        <a href="{{ url('balita-stunting') }}">
            <x-adminlte-info-box theme='danger' title="Jumlah Stunting" text="{{$jmlBalitaStunting}}"
                icon="fas fa-lg fa-baby" />
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <x-adminlte-card title="Grafik Perkembangan Stunting Per Tahun">
            <x-slot name="toolsSlot">
                <select id="select-tahun" class="custom-select w-auto form-control-border bg-light">
                    @foreach($tahun as $tahun)
                    <option value="{{$tahun}}">{{$tahun}}</option>
                    @endforeach
                </select>
            </x-slot>
            <div class="chart">
                <canvas id="lineChart"
                    style="min-height: 250px; height: 250px; max-height: 500px; max-width: 100%;"></canvas>
            </div>
        </x-adminlte-card>
    </div>
    <div class="col-md-4">
        <x-adminlte-card title="Grafik Berdasarkan Jenis Pengguna">
            <div class="chart">
                <canvas id="barChart"
                    style="min-height: 250px; height: 480px; max-height: 500px; max-width: 100%;"></canvas>
            </div>
        </x-adminlte-card>
    </div>
</div>
<x-adminlte-modal id="modalUser" title="Capaian Pengguna Menurut Jenis" size="lg" v-centered static-backdrop scrollable>
    <div class="chart">
        <canvas id="userJnsChart" style="min-height: 250px; height: 250px; max-height: 100%; max-width: 100%;"></canvas>
    </div>
</x-adminlte-modal>

@stop

@push('js')
<script>
    $(function(){
        let tahun = new Date().getFullYear();
        let lineChart = document.getElementById('lineChart').getContext('2d');
        let barChart = document.getElementById('barChart').getContext('2d');
        let userChart = document.getElementById('userJnsChart').getContext('2d');
        $.ajax({
            url: "{{url('dashboard-perkembangan-stunting')}}",
            type: "GET",
            data: {
                tahun: tahun
            },
            success: function (data) {
                let chart = new Chart(lineChart, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Grafik Perkembangan Stunting Per Tahun'
                            }
                        }
                    }
                });
            }
        })

        $.ajax({
            url: "{{url('dashboard-jenis-user')}}",
            type: "GET",
            success: function (data) {
                let chart = new Chart(barChart, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Grafik Perkembangan Stunting Per Tahun'
                            }
                        },
                        onClick: function(evt, element) {
                            let activePoints = chart.getElementAtEvent(evt);
                            let jns = activePoints[0]._model.label;
                            // $('#modalUser').modal('show');
                            $.ajax({
                                url: "{{url('dashboard-user')}}",
                                type: "GET",
                                data: {
                                    jenis: jns
                                },
                                success: function (data) {
                                    let chart = new Chart(userChart, {
                                        type: 'horizontalBar',
                                        data: {
                                            labels: data.labels,
                                            datasets: data.datasets
                                        },
                                        options: {
                                            responsive: true,
                                            plugins: {
                                                legend: {
                                                    position: 'top',
                                                },
                                                title: {
                                                    display: true,
                                                    text: 'Grafik Perkembangan Stunting Per Tahun'
                                                }
                                            }
                                        }
                                    });
                                    $('#modalUser').modal('show');
                                }
                            })
                        }
                    }
                });
            }
        })

        $('#select-tahun').on('change', function(){
            let tahun = $(this).val();
            $.ajax({
                url: "{{url('dashboard-perkembangan-stunting')}}",
                type: "GET",
                data: {
                    tahun: tahun
                },
                success: function (data) {
                    let chart = new Chart(lineChart, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: data.datasets
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Grafik Perkembangan Stunting Per Tahun'
                                }
                            }
                        }
                    });
                }
            })
        })
    })
</script>
@endpush