@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Data Roles</h1>
@stop

@section('content')
    @include('flash-message')
    <x-adminlte-card >
        <x-slot name="toolsSlot">
            <a name="add" id="add" class="btn btn-sm btn-primary" href="{{ url('/roles/add') }}" role="button">Tambah</a>
        </x-slot>
        <x-adminlte-datatable id="tableBBULaki" :heads="$heads" head-theme="dark" striped hoverable bordered compressed>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @foreach ($role->permissions as $permission)
                            <span class="badge badge-primary">{{ $permission->name }}</span>
                        @endforeach
                    </td>
                    <td>{{ $role->created_at }}</td>
                    <td>{{ $role->updated_at }}</td>
                    <td>
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
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