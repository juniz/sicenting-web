<div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-row-reverse mb-3">
                <button data-toggle="modal" data-target="#modal-tambah-team" name="tambah" id="tambah"
                    class="btn btn-sm btn-dark" role="button">Tambah</button>
                <div class="col-md-3">
                    <input id="search" wire:model.debounce.500ms='search' class="form-control" type="text" name="search"
                        placeholder="Cari .....">
                </div>
            </div>
            <div class="table-resposive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>No. Telp</th>
                            <th>Jenis</th>
                            <th>Aksi</th>
                        </tr>
                    <tbody>
                        @forelse($teams as $team)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $team->name }}</td>
                            <td>{{ $team->telp }}</td>
                            <td>{{ $team->jenis }}</td>
                            <td>
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-expanded="false">Menu</button>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item"
                                        wire:click='$emit("openEditModal", {{$team->id}})'>Ubah</button>
                                    <button class="dropdown-item"
                                        wire:click='confirmDelete("{{$team->id}}")'>Hapus</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Data kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    window.addEventListener('openModal', function(e){
        // $('#modal-tambah-team').modal('show');
    });
    window.addEventListener('closeModal', function(e){
        $('#modal-tambah-team').modal('hide');
    }); 
</script>
@endpush