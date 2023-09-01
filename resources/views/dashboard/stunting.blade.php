@extends('adminlte::page')

@section('title', 'Balita Stunting')

@section('content_header')
<h1>Balita Stunting</h1>
@stop

@section('content')
@include('flash-message')
<livewire:dashboard.balita-stunting />
@stop

@push('js')
<script>
</script>
@endpush