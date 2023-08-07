<div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Form Input</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent='simpan'>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Nama Unit</label>
                    <div class="col-sm-6">
                        <input wire:model.defer='nama' type="text"
                            class="form-control @error('nama') is-invalid @enderror">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Provinsi</label>
                    <div class="col-sm-6">
                        <select wire:model.defer='provinsi_id' type="text"
                            class="form-control @error('provinsi_id') is-invalid @enderror">
                            <option value="">Silahkan Pilih Provinsi</option>
                            @foreach($provinsi as $prov)
                            <option value="{{$prov->id}}">{{$prov->name}}</option>
                            @endforeach
                        </select>
                        @error('provinsi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary ml-auto">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
    window.addEventListener('swal', function(event){
        Swal.fire(event.detail)
    })

    window.addEventListener('show-modal', event => {
        $('#unitModal').modal('show');
    })
    window.addEventListener('hide-modal', event => {
        $('#unitModal').modal('hide');
    })
</script>
@endpush