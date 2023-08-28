<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="modal-edit-team" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('flash-message')
                    <form wire:submit.prevent='simpan' method="post">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input wire:model.defer='name' id="name" class="form-control" type="text" name="">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="telp">No. Telp</label>
                            <input wire:model.defer='telp' id="telp" class="form-control" type="number" name="">
                            @error('telp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <select wire:model.defer='jenis' id="jenis" class="form-control" name="">
                                <option>Pilih jenis....</option>
                                <option value="Dokter Spesialis">Dokter Spesialis</option>
                                <option value="Ahli Gizi">Ahli Gizi</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    window.addEventListener('openEditModal', e => {
        $('#modal-edit-team').modal('show');
    })
    window.addEventListener('closeEditModal', e => {
        $('#modal-edit-team').modal('hide');
    })
</script>
@endpush