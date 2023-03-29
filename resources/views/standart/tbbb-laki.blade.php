@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Input Standart Berat Badan Berdasarkan Umur Anak Peremuan</h1>
@stop

@section('content')
    <livewire:standart.tbbb-laki />
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop