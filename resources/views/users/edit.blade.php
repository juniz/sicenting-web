@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
            </div>
            @endif
            <form action="{{ url('/users/edit', $user->id) }}" method="POST">
                @csrf
                <x-adminlte-input name="name" label="Nama" value="{{ $user->name }}"/>
                <x-adminlte-input name="username" label="Username" value="{{ $user->username }}"/>
                <x-adminlte-input name="password" label="Password"/>
                <x-adminlte-button class="btn-flat" type="submit" label="Simpan" theme="success" icon="fas fa-lg fa-save"/>
            </form>
        </div>
    </div>
@stop

@push('js')
    <script>
    </script>
@endpush