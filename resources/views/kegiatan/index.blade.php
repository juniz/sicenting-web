@extends('adminlte::page')

@section('title', 'Daftar Giat')

@section('content_header')
<h1>Daftar Giat</h1>
@stop

@section('content')
@include('flash-message')
<div class="card">
    <div class="card-header">
        <form method="GET" action="{{ url('/giat/cetak') }}">
            <div class="d-flex flex-row-reverse">
                <div class="col-md-3">
                    <x-adminlte-date-range name="tanggal" enable-default-ranges="Today">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                        <x-slot name="appendSlot">
                            <x-adminlte-button id='filterButton' theme="outline-info" label="Cetak" type="submit"
                                icon="fas fa-lg fa-print" />
                        </x-slot>
                    </x-adminlte-date-range>
                </div>
                <div class="col-md-3">
                    <x-adminlte-select2 name="user">
                        <option>Pilih user.....</option>
                        @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <livewire:kegiatan.table />
    </div>
</div>
<livewire:kegiatan.create />
@stop

@push('js')
<script>
</script>
@endpush