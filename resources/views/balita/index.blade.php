@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Balita</h1>
@stop

@section('content')
    <x-adminlte-card title="Data balita">
        @can('edit pemeriksaan')
        <x-slot name="toolsSlot">
            <a name="tambah" id="tambah" class="btn btn-sm btn-primary" href="{{ url('/balita/tambah') }}" role="button">Tambah</a>
        </x-slot>
        @endcan
    
        @php
            $heads = ['Nama', 'Jns Kelamin', 'Tgl Lahir', 'Nama Orang Tua', 'Alamat', 'Aksi'];
        @endphp
        <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="dark" striped hoverable bordered>
            @foreach ($balita as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jns_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                    <td>{{ $item->tgl_lahir }}</td>
                    <td>{{ $item->nama_ortu }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>
                        <div class="d-flex">
                            {{-- <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button> --}}
                            <a class="btn btn-xs btn-default text-success mx-1 shadow" title="Details" href="{{ url('/balita', $item->id) }}">
                                <i class="fa fa-lg fa-fw fa-eye"></i> Pengukuran
                            </a>
                            <form id="formDelete" action="{{ url('/balita', $item->id) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button id="deleteButton" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                    <i class="fa fa-lg fa-fw fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </x-adminlte-card>
@stop

@push('js')
    <script>
        $('#deleteButton').on('click', function(e){
            e.preventDefault();
            Swal.fire({
                title : 'Apakah anda yakin menghapus data ?',
                text : 'Data yang sudah dihapus tidak dapat dikembalikan',
                icon : 'warning',
                showCancelButton : true,
                confirmButtonColor : '#3085d6',
                cancelButtonColor : '#d33',
                confirmButtonText : 'Ya, hapus data'
            }).then((result) => {
                if(result.value){
                    $('#formDelete').submit();
                }
            });
        });
    </script>
@endpush