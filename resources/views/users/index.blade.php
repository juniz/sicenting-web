@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Daftar pengguna</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableUsers" class="table table-striped table-inverse" style="width: 100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->password }}</td>
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
        } );
    </script>
@endpush