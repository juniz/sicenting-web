@extends('adminlte::page')

@section('title', 'Kanal Stunting')

@section('content_header')
<h1>Kanal Stunting</h1>
@stop

@section('content')
@include('flash-message')
<livewire:teams.table />
<livewire:teams.create />
<livewire:teams.update />
@stop

@push('js')
<script>
</script>
@endpush