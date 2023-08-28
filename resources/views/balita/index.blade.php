@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Balita</h1>
@stop

@section('content')
@include('flash-message')
<livewire:balita.table />
<livewire:balita.create :provinsi="$provinsi" />
<livewire:balita.update :provinsi="$provinsi" />
@stop

@push('js')
<script>
</script>
@endpush