@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Daftar pengguna</h1>
@stop

@section('content')
@include('flash-message')
<div class="card">
    <div class="card-header">
        <div class="card-tools">
            <a name="tambah" id="tambah" class="btn btn-primary" href="{{ url('/users/tambah') }}" role="button">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tableUsers" class="table table-striped table-inverse" style="width: 100%">
                <thead class="thead-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Unit</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->unit->nama ?? '' }}</td>
                        <td>{{ $user->password }}</td>
                        <td>
                            @foreach($user->roles as $role)
                            <span class="badge badge-primary">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Button group">
                                @can('edit user')
                                <a name="edit" id="edit" class="btn btn-success" href="{{ url('/users', $user->id) }}"
                                    role="button">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a name="edit-password" id="edit-password" class="btn btn-secondary"
                                    href="{{ url('/users-password', $user->id) }}" role="button">
                                    <i class="fas fa-key"></i>
                                </a>
                                @endcan
                                @can('delete user')
                                <form action="{{url('users/'.$user->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@push('js')
<script>
    $(document).ready(function() {
        $('#tableUsers').DataTable({
            "responsive": true,
            "autoWidth": false,
        });


    });
</script>
@endpush