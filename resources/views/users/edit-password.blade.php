@extends('adminlte::page')

@section('title', 'Ubah Password')

@section('content_header')
<h1>Ubah Password</h1>
@stop

@section('content')
@include('flash-message')
<div class="card">
    <div class="card-body">
        <form action="{{ url('/users-password', $user->id) }}" method="POST">
            @csrf
            <x-adminlte-input name="password" label="Password" />
            <x-adminlte-input name="password_confirmation" label="Konfirmasi Password" />
            <x-adminlte-button class="btn-flat" type="submit" label="Simpan" theme="success" icon="fas fa-lg fa-save" />
        </form>
    </div>
</div>
@stop

@push('js')
<script>
</script>
@endpush