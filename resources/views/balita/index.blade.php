@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Balita</h1>
@stop

@section('content')
@include('flash-message')
<x-adminlte-card title="Data balita">
    @can('add balita')
    <x-slot name="toolsSlot">
        <a name="tambah" id="tambah" class="btn btn-sm btn-dark" href="{{ url('/balita/tambah') }}"
            role="button">Tambah</a>
        {{--
        <x-adminlte-button label="Tambah" theme='dark' data-toggle="modal" data-target="#tambahBalitaModal" /> --}}
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
                    @can('view pemeriksaan')
                    <a class="btn btn-xs btn-default text-success mx-1 shadow" title="Details"
                        href="{{ url('/balita', $item->id) }}">
                        <i class="fa fa-lg fa-fw fa-eye"></i> Pengukuran
                    </a>
                    @endcan
                    @can('delete balita')
                    <form id="formDelete" action="{{ url('/balita', $item->id) }}" method="POST">
                        @csrf
                        @method("DELETE")
                        <button id="deleteButton" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i> Hapus
                        </button>
                    </form>
                    @endcan
                </div>
            </td>
        </tr>
        @endforeach
    </x-adminlte-datatable>
</x-adminlte-card>

{{-- Modal --}}
<x-adminlte-modal id="tambahBalitaModal" title="Tambah Balita">
    <form method="POST" id="submit-balita">
        @csrf
        <x-adminlte-input name="nama" label="Nama Balita" />
        <x-adminlte-select2 name="jnsKelamin" label="Jenis Kelamin Balita" data-placeholder="Pilih jenis kelamin ....">
            <option />
            <option value="L">Laki-Laki</option>
            <option value="P">Perempuan</option>
        </x-adminlte-select2>
        @php
        $config = ['format' => 'YYYY-MM-DD'];
        @endphp
        <x-adminlte-input-date name="tglLahir" label='Tanggal lahir' :config="$config"
            placeholder="Pilih tanggal lahir...">
            {{-- <x-slot name="prependSlot">
                <div class="input-group-text bg-gradient-info">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </x-slot> --}}
        </x-adminlte-input-date>
        <x-adminlte-input name="namaOrtu" label="Nama Orang Tua" />
        <div class="form-group">
            <label>Provinsi</label>
            <select name="provinsi" class="form-control @error('provinsi') is-invalid @enderror" id="provinsi">
                <option value="">Silahkan Pilih Provinsi</option>
                @foreach($provinsi as $prov)
                <option value="{{$prov->id}}">{{$prov->name}}</option>
                @endforeach
            </select>
            @error('provinsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Kabupaten / Kota</label>
            <select class="form-control @error('kabupaten') is-invalid @enderror" name="kabupaten" id="kabupaten">
                <option value="">Pilih Kabupaten / Kota</option>
            </select>
        </div>
        <div class="form-group row">
            <label>Kecamatan</label>
            <select name="kecamatan" id="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror">
                <option value="">Pilih Kecamatan</option>
            </select>
        </div>
        <div class="form-group row">
            <label>Kelurahan</label>
            <select name="kelurahan" id="kelurahan" class="form-control @error('kelurahan') is-invalid @enderror">
                <option value="">Pilih Kelurahan</option>
            </select>
        </div>
        <x-adminlte-input name="rt" label="RT" />
        <x-adminlte-input name="rw" label="RW" />
        <div class="form-group">
            <label>Alamat</label>
            <textarea cols="3" class="form-control @error('alamat') is-invalid @enderror" name='alamat'></textarea>
            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-block">Simpan</button>
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="danger" label="Tutup" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>
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
    
    $('document').ready(function(){
        $('#provinsi').select2({
            placeholder: 'Silahkan Pilih Provinsi',
            theme: 'bootstrap4',
            allowClear: true,
            width: '100%',
        });

        $('#kabupaten').select2({
            placeholder: 'Silahkan Pilih Kabupaten / Kota',
            theme: 'bootstrap4',
            allowClear: true,
            width: '100%',
        });

        $('#kecamatan').select2({
            placeholder: 'Silahkan Pilih Kecamatan',
            theme: 'bootstrap4',
            allowClear: true,
            width: '100%',
        });

        $('#kelurahan').select2({
            placeholder: 'Silahkan Pilih Kelurahan',
            theme: 'bootstrap4',
            allowClear: true,
            width: '100%',
        });

        $('#provinsi').on('change', function(){
            var id = $(this).val();
            $.ajax({
                url: '/api/kabupaten/'+id,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    $('#kabupaten').empty();
                    $.each(data, function(key, value){
                        $('#kabupaten').append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            });
        });

        $('#kabupaten').on('change', function(){
            var id = $(this).val();
            $.ajax({
                url: '/api/kecamatan/'+id,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    $('#kecamatan').empty();
                    $.each(data, function(key, value){
                        $('#kecamatan').append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            });
        });

        $('#kecamatan').on('change', function(){
            var id = $(this).val();
            $.ajax({
                url: '/api/kelurahan/'+id,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    $('#kelurahan').empty();
                    $.each(data, function(key, value){
                        $('#kelurahan').append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            });
        });
    })
</script>
@endpush