@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Daftar Units</h1>
@stop

@section('content')
    <livewire:units.tambah />
    <livewire:units.table />
@stop