<div>
    <div wire:ignore.self id="update-balita" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Update Balita</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='simpan'>
                        @include('flash-message')
                        <div class="form-group">
                            <label for="nik">No. KK</label>
                            <input id="nik" wire:model.defer='nik' class="form-control" type="text" name="">
                            @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Balita</label>
                            <input wire:model.defer='nama' id="nama" class="form-control" type="text" name="">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="jns_kelamin">Jenis Kelamin</label>
                            <select wire:model.defer='jns_kelamin' name="jns_kelamin" class="form-control"
                                id="jns_kelamin">
                                <option value="">Silahkan Pilih Jenis Kelamin</option>
                                <option value="L">Laki - Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tglLahir">Tgl Lahir</label>
                            <input wire:model.defer='tgl_lahir' id="tglLahir" class="form-control" type="date" name="">
                            @error('tgl_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="namaOrtu">Nama Ortu</label>
                            <input wire:model.defer='nama_ortu' id="namaOrtu" class="form-control" type="text" name="">
                        </div>
                        <div wire:ignore class="form-group">
                            <label for="provinsi">Provinsi</label>
                            <select id="provinsi-update" class="form-control" name="provinsi">
                                <option value="">Silahkan Pilih Provinsi</option>
                                @foreach($provinsi as $p)
                                <option value="{{$p->id}}">{{$p->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div wire:ignore class="form-group">
                            <label for="kabupaten">Kabupaten</label>
                            <select id="kabupaten-update" class="form-control" name="kabupaten">
                                <option value="">Silahkan pilih kabupaten</option>
                            </select>
                        </div>
                        <div wire:ignore class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <select id="kecamatan-update" class="form-control" name="kecamatan">
                                <option value="">Silahkan pilih kecamatan</option>
                            </select>
                        </div>
                        <div wire:ignore class="form-group">
                            <label for="kelurahan">Kelurahan</label>
                            <select id="kelurahan-update" class="form-control" name="kelurahan">
                                <option value="">Silahkan pilih kelurahan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rt">RT</label>
                            <input wire:model.defer='rt' id="rt" class="form-control" type="text" name="">
                            @error('rt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="rw">RW</label>
                            <input wire:model.defer='rw' id="rw" class="form-control" type="text" name="">
                            @error('rw') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea wire:model.defer='alamat' id="alamat" class="form-control" name=""
                                rows="2"></textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>
                </div>
                {{-- <div class="modal-footer">
                </div> --}}
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    window.addEventListener('openModalUpdateBalita', event => {
        $('#update-balita').modal('show');
    });
    window.addEventListener('closeModalUpdateBalita', event => {
        $('#update-balita').modal('hide');
    });

    $('#provinsi-update').select2({
            placeholder: 'Silahkan Pilih Provinsi',
            theme: 'bootstrap4',
            allowClear: true,
            width: '100%',
            dropdownParent: $("#update-balita")
        });

        $('#kabupaten-update').select2({
            placeholder: 'Silahkan Pilih Kabupaten / Kota',
            theme: 'bootstrap4',
            allowClear: true,
            width: '100%',
            dropdownParent: $("#update-balita")
        });

        $('#kecamatan-update').select2({
            placeholder: 'Silahkan Pilih Kecamatan',
            theme: 'bootstrap4',
            allowClear: true,
            width: '100%',
            dropdownParent: $("#update-balita")
        });

        $('#kelurahan-update').select2({
            placeholder: 'Silahkan Pilih Kelurahan',
            theme: 'bootstrap4',
            allowClear: true,
            width: '100%',
            dropdownParent: $("#update-balita")
        });

        $('#provinsi-update').on('change', function(){
            var id = $(this).val();
            @this.set('valProvinsi', id);
            $.ajax({
                url: '/api/kabupaten/'+id,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    $('#kabupaten-update').empty();
                    $.each(data, function(key, value){
                        $('#kabupaten-update').append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            });
        });

        $('#kabupaten-update').on('change', function(){
            var id = $(this).val();
            @this.set('kabupaten', id);
            $.ajax({
                url: '/api/kecamatan/'+id,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    $('#kecamatan-update').empty();
                    $.each(data, function(key, value){
                        $('#kecamatan-update').append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            });
        });

        $('#kecamatan-update').on('change', function(){
            var id = $(this).val();
            @this.set('kecamatan', id);
            $.ajax({
                url: '/api/kelurahan/'+id,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    $('#kelurahan-update').empty();
                    $.each(data, function(key, value){
                        $('#kelurahan-update').append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            });
        });

        $('#kelurahan-update').on('change', function(){
            var id = $(this).val();
            @this.set('kelurahan', id);
        });
</script>
@endpush