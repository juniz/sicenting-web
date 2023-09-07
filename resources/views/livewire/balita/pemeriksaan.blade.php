<div wire:ignore.self id="pemeriksaan-balita" class="modal fade" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Pemeriksaan Balita</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent='simpan'>
                    @include('flash-message')
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input wire:model.defer='tanggal' type="date"
                            class="form-control @error('tanggal') is-invalid @enderror">
                        @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Tinggi badan</label>
                        <input wire:model.defer='tinggi' type="text"
                            class="form-control @error('tinggi') is-invalid @enderror">
                        @error('tinggi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Berat badan</label>
                        <input wire:model.defer='berat' type="text"
                            class="form-control @error('berat') is-invalid @enderror">
                        @error('berat') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
    window.addEventListener('openModalPemeriksaan', e => {
        $('#pemeriksaan-balita').modal('show');
    })
</script>
@endpush