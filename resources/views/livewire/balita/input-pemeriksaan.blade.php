<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Input Pemeriksaan</h3>
            <div class="card-tools">
            </div>
        </div>
        <form wire:submit.prevent='simpan'>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Tanggal</label>
                    <div class="col-sm-6">
                        <input wire:model.defer='tanggal' type="date" class="form-control @error('tanggal') is-invalid @enderror" >
                        @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Tinggi badan</label>
                    <div class="col-sm-6">
                        <input wire:model.defer='tinggi' type="text" class="form-control @error('tinggi') is-invalid @enderror" >
                        @error('tinggi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Berat badan</label>
                    <div class="col-sm-6">
                        <input wire:model.defer='berat' type="text" class="form-control @error('berat') is-invalid @enderror" >
                        @error('berat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <div wire:loading.delay>
                        <div class="spinner-grow text-success" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-warning" role="status">
                        <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('js')
    <script>
        window.addEventListener('swal:balita',function(e){
            Swal.fire(e.detail);
        });
    </script>
@endpush
