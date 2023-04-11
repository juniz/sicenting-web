@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')
@include('flash-message')
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
                <x-adminlte-input name="email" label="Email" value="{{ $user->email }}"/>
                <x-adminlte-input name="password" label="Password"/>
                <x-adminlte-input name="password_confirmation" label="Konfirmasi Password"/>
                <x-adminlte-select2 name="unit" label="Pilih Unit" data-placeholder="Pilih Unit .....">
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ $user->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->nama }}</option>
                    @endforeach
                </x-adminlte-select2>
                @php
                    $config = [
                        "placeholder" => "Pilih role...",
                        "allowClear" => true,
                    ];
                @endphp
                <x-adminlte-select2 label="Role" id="role" name="role[]" :config="$config" igroup-size="sm" multiple>
                    @foreach($user->roles as $role)
                        <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                    @endforeach
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </x-adminlte-select2>
                <x-adminlte-button class="btn-flat" type="submit" label="Simpan" theme="success" icon="fas fa-lg fa-save"/>
            </form>
        </div>
    </div>
@stop

@push('js')
    <script>
    </script>
@endpush