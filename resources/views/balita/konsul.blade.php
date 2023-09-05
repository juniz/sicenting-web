@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Balita Konsul</h1>
@stop

@section('content')
@include('flash-message')
<livewire:balita.table-konsul />
@stop

@push('js')
<script>
</script>
@endpush