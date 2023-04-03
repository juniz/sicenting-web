@extends('adminlte::page')

@section('title', 'Tambah User')

@section('content_header')
    <h1>Tambah User</h1>
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
            <form action="{{ url('/users') }}" method="POST">
                @csrf
                <x-adminlte-input name="name" label="Nama" value="{{ old('name') }}"/>
                <x-adminlte-input name="username" label="Username" value="{{ old('username') }}"/>
                <x-adminlte-select2 name="unit" label="Pilih Unit">
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                    @endforeach
                </x-adminlte-select2>
                <x-adminlte-select2 name="role" label="Pilih Role">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </x-adminlte-select2>
                <x-adminlte-input name="password" label="Password" type="password"/>
                <x-adminlte-input name="password_confirmation" label="Konfirmasi Password" type="password"/>
                <x-adminlte-button class="btn-flat" type="submit" label="Simpan" theme="success" icon="fas fa-lg fa-save"/>
            </form>
        </div>
    </div>
@stop

@push('js')
    <script>
    </script>
@endpush