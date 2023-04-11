@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1>Edit Data Roles</h1>
@stop

@section('content')
    @include('flash-message')
    <x-adminlte-card >
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                    <input name="name" value="{{ $role->name }}" type="text" class="form-control @error('name') is-invalid @enderror" >
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Permission</label>
                <div class="col-sm-9">
                {{-- With multiple slots, and plugin config parameter --}}
                @php
                    $config = [
                        "placeholder" => "Pilih permision...",
                        "allowClear" => true,
                    ];
                @endphp
                <x-adminlte-select2 id="permissions" name="permissions[]" igroup-size="md" :config="$config" multiple>
                    @foreach($role->permissions as $p)
                        <option value="{{ $p->id }}" selected>{{ $p->name }}</option>
                    @endforeach
                    @foreach($permissions as $permission)
                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                    @endforeach
                </x-adminlte-select2>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Perbaharui</button>
            </div>
        </form>
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop