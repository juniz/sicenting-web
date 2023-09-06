<div>
    <div wire:ignore.self id="update-balita" class="modal fade" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
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
</script>
@endpush