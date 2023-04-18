@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Tambah Balita</h1>
@stop

@section('content')
    @include('flash-message')
    {{-- <livewire:balita /> --}}
    <x-adminlte-card>
        <form action="{{ url('/balita') }}" method="POST">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" >
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Jenis kelamin</label>
                <div class="col-sm-10">
                    <select class="form-control @error('jnsKelamin') is-invalid @enderror" name="jnsKelamin">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    @error('jnsKelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal lahir</label>
                <div class="col-sm-10">
                    <input type="date" name='tglLahir' class="form-control @error('tglLahir') is-invalid @enderror" >
                    @error('tglLahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama Orang Tua</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='namaOrtu'>
                    @error('namaOrtu') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Provinsi</label>
                <div class="col-sm-10">
                    <select name="provinsi" class="form-control @error('provinsi') is-invalid @enderror" id="provinsi">
                        <option value="">Silahkan Pilih Provinsi</option>
                        @foreach($provinsi as $prov)
                            <option value="{{$prov->id}}">{{$prov->name}}</option>
                        @endforeach
                    </select>
                    @error('provinsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Kabupaten / Kota</label>
                <div class="col-sm-10">
                    <select class="form-control @error('kabupaten') is-invalid @enderror" name="kabupaten" id="kabupaten">
                        <option value="">Pilih Kabupaten / Kota</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Kecamatan</label>
                <div class="col-sm-10">
                    <select name="kecamatan" id="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror">
                        <option value="">Pilih Kecamatan</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Kelurahan</label>
                <div class="col-sm-10">
                    <select name="kelurahan" id="kelurahan" class="form-control @error('kelurahan') is-invalid @enderror">
                        <option value="">Pilih Kelurahan</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">RT</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('rt') is-invalid @enderror" name='rt'>
                    @error('rt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">RW</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('rw') is-invalid @enderror" name='rw'>
                    @error('rw') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <textarea cols="3" class="form-control @error('alamat') is-invalid @enderror" name='alamat'></textarea>
                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
    <script>
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
@stop