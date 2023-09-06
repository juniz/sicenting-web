<div wire:ignore.self id="tambah-balita" class="modal fade" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Tambah Balita</h5>
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
                        <select wire:model.defer='jns_kelamin' name="jns_kelamin" class="form-control" id="jns_kelamin">
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
                        <select id="provinsi" class="form-control" name="provinsi">
                        </select>
                    </div>
                    <div wire:ignore class="form-group">
                        <label for="kabupaten">Kabupaten</label>
                        <select id="kabupaten" class="form-control" name="kabupaten">
                            <option value="">Silahkan pilih kabupaten</option>
                        </select>
                    </div>
                    <div wire:ignore class="form-group">
                        <label for="kecamatan">Kecamatan</label>
                        <select id="kecamatan" class="form-control" name="kecamatan">
                            <option value="">Silahkan pilih kecamatan</option>
                        </select>
                    </div>
                    <div wire:ignore class="form-group">
                        <label for="kelurahan">Kelurahan</label>
                        <select id="kelurahan" class="form-control" name="kelurahan">
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

@push('js')
<script>
    //     $.fn.modal.Constructor.prototype.enforceFocus = function () {
//       var that = this;
//       $(document).on('focusin.modal', function (e) {
//          if ($(e.target).hasClass('select2-input')) {
//             return true;
//          }

//          if (that.$element[0] !== e.target && !that.$element.has(e.target).length) {
//             that.$element.focus();
//          }
//       });
//    };
    $(document).on("select2:open", () => {
        document.querySelector(".select2-container--open .select2-search__field").focus()
    })

    $('#tambah-balita').on('hide.bs.modal', function(e){
        Livewire.emit('resetAll');
        $('#provinsi').val(null).trigger('change');
        $('#kabupaten').val(null).trigger('change');
        $('#kecamatan').val(null).trigger('change');
        $('#kelurahan').val(null).trigger('change');
    });

    window.addEventListener('openModalTambahBalita', event => {
        $('#tambah-balita').modal({backdrop: 'static', keyboard: false},'show');
    });
    window.addEventListener('closeModalTambahBalita', event => {
        $('#tambah-balita').modal('hide');
    });

    $('#provinsi').select2({
        placeholder: 'Silahkan Pilih Provinsi',
        theme: 'bootstrap4',
        allowClear: true,
        width: '100%',
        // dropdownParent: $("#tambah-balita"),
        ajax: {
            url: '/api/provinsi',
            dataType: 'json',
            delay: 250,
            processResults: function(data){
                return {
                    results: $.map(data, function(item){
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true,
        },
        minimumInputLength: 3
    });

    $('#kabupaten').select2({
        placeholder: 'Silahkan Pilih Kabupaten / Kota',
        theme: 'bootstrap4',
        allowClear: true,
        width: '100%',
        // dropdownParent: $("#tambah-balita"),
        ajax: {
            url: '/api/kabupaten',
            dataType: 'json',
            delay: 250,
            data: function(params){
                return {
                    provinsi: $('#provinsi').val(),
                    q: params.term
                }
            },
            processResults: function(data){
                return {
                    results: $.map(data, function(item){
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true,
        },
        minimumInputLength: 3
    });

    $('#kecamatan').select2({
        placeholder: 'Silahkan Pilih Kecamatan',
        theme: 'bootstrap4',
        allowClear: true,
        width: '100%',
        // dropdownParent: $("#tambah-balita"),
        ajax: {
            url: '/api/kecamatan',
            dataType: 'json',
            delay: 250,
            data: function(params){
                return {
                    kabupaten: $('#kabupaten').val(),
                    q: params.term
                }
            },
            processResults: function(data){
                return {
                    results: $.map(data, function(item){
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true,
        },
        minimumInputLength: 3
    });

    $('#kelurahan').select2({
        placeholder: 'Silahkan Pilih Kelurahan',
        theme: 'bootstrap4',
        allowClear: true,
        width: '100%',
        // dropdownParent: $("#tambah-balita"),
        ajax: {
            url: '/api/kelurahan',
            dataType: 'json',
            delay: 250,
            data: function(params){
                return {
                    kecamatan: $('#kecamatan').val(),
                    q: params.term
                }
            },
            processResults: function(data){
                return {
                    results: $.map(data, function(item){
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true,
        },
        minimumInputLength: 3
    });

    $('#provinsi').on('change', function(){
        var id = $(this).val();
        @this.set('valProvinsi', id);
        $('#kabupaten').empty();
        $('#kecamatan').empty();
        $('#kelurahan').empty();
        // $.ajax({
        //     url: '/api/kabupaten/'+id,
        //     type: 'GET',
        //     dataType: 'json',
        //     success: function(data){
        //         $('#kabupaten').append('<option value="">Silahkan pilih kabupaten</option>');
        //         $.each(data, function(key, value){
        //             $('#kabupaten').append('<option value="'+value.id+'">'+value.name+'</option>');
        //         });
        //     }
        // });
    });

    $('#kabupaten').on('change', function(){
        var id = $(this).val();
        @this.set('kabupaten', id);
        $('#kecamatan').empty();
        $('#kelurahan').empty();
        // $.ajax({
        //     url: '/api/kecamatan/'+id,
        //     type: 'GET',
        //     dataType: 'json',
        //     success: function(data){
        //         $('#kecamatan').append('<option value="">Silahkan pilih kecamatan</option>');
        //         $.each(data, function(key, value){
        //             $('#kecamatan').append('<option value="'+value.id+'">'+value.name+'</option>');
        //         });
        //     }
        // });
    });

    $('#kecamatan').on('change', function(){
        var id = $(this).val();
        @this.set('kecamatan', id);
        $('#kelurahan').empty();
        // $.ajax({
        //     url: '/api/kelurahan/'+id,
        //     type: 'GET',
        //     dataType: 'json',
        //     success: function(data){
        //         $('#kelurahan').append('<option value="">Silahkan pilih kelurahan</option>');
        //         $.each(data, function(key, value){
        //             $('#kelurahan').append('<option value="'+value.id+'">'+value.name+'</option>');
        //         });
        //     }
        // });
    });

    $('#kelurahan').on('change', function(){
        var id = $(this).val();
        @this.set('kelurahan', id);
    });
</script>
@endpush