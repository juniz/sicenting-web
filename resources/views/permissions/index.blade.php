@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Data Permissions</h1>
@stop

@section('content')
    @include('flash-message')
    <x-adminlte-card >
        <x-slot name="toolsSlot">
            <a name="add" id="add" class="btn btn-sm btn-primary" href="{{ url('/permissions/add') }}" role="button">Tambah</a>
        </x-slot>
        <x-adminlte-datatable id="tablePermission" :heads="$heads" head-theme="dark" striped hoverable bordered compressed>
            @foreach($permissions as $permission)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->created_at }}</td>
                    <td>{{ $permission->updated_at }}</td>
                    <td>
                        <a href="{{ url('/permissions', $permission->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop