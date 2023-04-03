<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Input Form</h3>
            <div class="card-tools">
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form wire:submit.prevent="simpan">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input wire:model.defer='nama' type="text" class="form-control @error('nama') is-invalid @enderror" >
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Jenis kelamin</label>
                <div class="col-sm-10">
                    <select class="form-control @error('jnsKelamin') is-invalid @enderror" wire:model.defer='jnsKelamin' name="jns_kelamin">
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
                    <input type="date" wire:model.defer='tglLahir' class="form-control @error('tglLahir') is-invalid @enderror" >
                    @error('tglLahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama Orang Tua</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model.defer='namaOrtu'>
                    @error('namaOrtu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Provinsi</label>
                <div class="col-sm-10">
                    <select class="form-control @error('selectProv') is-invalid @enderror" wire:model='selectProv' name="provinsi">
                        <option value="">Pilih Provinsi</option>
                        @foreach($provinsi as $prov)
                            <option wire:click="updatedSelectProv({{$prov["id"]}})" value="{{$prov['id']}}">{{$prov['name']}}</option>
                        @endforeach
                    </select>
                    @error('selectProv') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            @if(!empty($selectProv))
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kabupaten / Kota</label>
                    <div class="col-sm-10">
                        <select class="form-control @error('selectKab') is-invalid @enderror"" wire:model='selectKab'>
                            <option value="">Pilih Kabupaten / Kota</option>
                            @foreach($kabupaten as $kab)
                                <option wire:click="updatedSelectKab('{{$kab["id"]}}')" value="{{$kab['id']}}">{{$kab['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
            @if(!empty($selectKab))
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kecamatan</label>
                    <div class="col-sm-10">
                        <select class="form-control @error('selectKec') is-invalid @enderror" wire:model='selectKec'>
                            <option value="">Pilih Kecamatan</option>
                            @foreach($kecamatan as $kec)
                                <option wire:click="updatedSelectKec('{{$kec["id"]}}')" value="{{$kec['id']}}">{{$kec['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
            @if(!empty($selectKec))
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kelurahan</label>
                    <div class="col-sm-10">
                        <select class="form-control @error('selectKel') is-invalid @enderror" wire:model='selectKel'>
                            <option value="">Pilih Kelurahan</option>
                            @foreach($kelurahan as $kel)
                                <option wire:click="updatedSelectKel('{{$kel["id"]}}')" value="{{$kel['id']}}">{{$kel['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">RT</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('rt') is-invalid @enderror" wire:model.defer='rt'>
                    @error('rt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">RW</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('rw') is-invalid @enderror" wire:model.defer='rw'>
                    @error('rw') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <textarea cols="3" class="form-control @error('alamat') is-invalid @enderror" wire:model.defer='alamat'></textarea>
                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
        <!-- /.card-footer -->
    </div>
</div>

@push('js')
    <script>
        window.addEventListener('swal:balita', function(e) {
            Swal.fire(e.detail);
        });
    </script>
@endpush