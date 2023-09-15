@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="d-flex flex-row justify-content-between">
    <div>
        <h1>Dashboard Stunting</h1>
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
    <div class="col-md-12">
        <x-adminlte-card title="Grafik Indikasi Rawan Stunting">
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
<x-adminlte-modal id="modalStunting" title="Data Jumlah Balita Per User" size="lg" v-centered static-backdrop
    scrollable>
    <div class="chart">
        <canvas id="barUserChart" style="min-height: 250px; height: 250px; max-height: 100%; max-width: 100%;"></canvas>
    </div>
    {{-- <x-slot name="footerSlot">
        <x-adminlte-button class="mr-auto" theme="success" label="Accept" />
        <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
    </x-slot> --}}
</x-adminlte-modal>

@stop

@push('js')
<script>
    $(function(){
        // let tahun = new Date().getFullYear();
        let badanChart = document.getElementById('barBadanChart').getContext('2d');
        let barChart = document.getElementById('barChart').getContext('2d');
        let giziChart = document.getElementById('barGiziChart').getContext('2d');

        $.ajax({
            url: "{{url('dashboard-stunting-kab')}}",
            type: "GET",
            success: function (data) {
                console.log(data);
                let chart = new Chart(barChart, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                        legend: {
                            display: true
                        },
                        tooltips: {
                            enabled: true,
                        },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }
        })

        $.ajax({
            url: "{{url('dashboard-gizi-kab')}}",
            type: "GET",
            success: function (data) {
                // console.log(data);
                let chart = new Chart(giziChart, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                        legend: {
                            display: true
                        },
                        tooltips: {
                            enabled: true,
                        },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }
        })

        $.ajax({
            url: "{{url('dashboard-badan-kab')}}",
            type: "GET",
            success: function (data) {
                // console.log(data);
                let chart = new Chart(badanChart, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                        legend: {
                            display: true
                        },
                        tooltips: {
                            enabled: true,
                        },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }
        })

    })
</script>
@endpush