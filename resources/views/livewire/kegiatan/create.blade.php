<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="modal-tambah-kegiatan" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('flash-message')
                    <form wire:submit.prevent='simpan' method="post">
                        <div class="form-group">
                            <label for="name">Nama Kegiatan</label>
                            <textarea rows="2" wire:model.defer='nama_kegiatan' id="name" class="form-control"
                                type="text" name="">
                            </textarea>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input wire:model.defer='photo' id="photo" class="form-control-file" type="file" name="">
                        </div>
                        @if($photo)
                        <div class="mb-3">
                            <img src="{{$photo->temporaryUrl()}}" width="100%" height="300px" alt="">
                        </div>
                        @endif
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
    window.addEventListener('closeModal', e => {
        $('#modal-tambah-kegiatan').modal('hide');
    })
</script>
@endpush