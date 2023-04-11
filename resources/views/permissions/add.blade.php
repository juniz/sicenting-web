@extends('adminlte::page')

@section('title', 'Permissions')

@section('content_header')
    <h1>Edit Permissons</h1>
@stop

@section('content')
    @include('flash-message')
    <x-adminlte-card >
        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                    <input name="name" value="{{ old('name') }}" type="text" class="form-control @error('name') is-invalid @enderror" >
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop