@extends('adminlte::page')

@section('title', 'Balita')

@section('content_header')
    <h1>Detail Balita</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <livewire:balita.detail :balita='$balita'>
        </div>
        <div class="col-md-6">
            <livewire:balita.input-pemeriksaan :balita='$balita'>
        </div>
    </div>
    <livewire:balita.riwayat :balita='$balita'>
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop