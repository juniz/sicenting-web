<div>
    <div class="d-flex flex-row-reverse mb-3">
        <button data-toggle="modal" data-target="#modal-tambah-kegiatan" name="tambah" id="tambah"
            class="btn btn-sm btn-dark" role="button">Tambah</button>
        <div class="col-md-3">
            <input id="search" wire:model.debounce.500ms='search' class="form-control" type="text" name="search"
                placeholder="Cari .....">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kegiatan</th>
                    <th>User</th>
                    <th>Tanggal</th>
                    <th>Photo</th>
                    <th>Aksi</th>
                </tr>
            <tbody>
                @forelse($kegiatans as $kegiatan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kegiatan->nama_kegiatan }}</td>
                    <td>{{ $kegiatan->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($kegiatan->created_at)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ asset('storage/kegiatan/'.$kegiatan->photo) }}" data-toggle="lightbox">
                            <img src="{{ asset('storage/kegiatan/'.$kegiatan->photo) }}" alt="" width="100px"
                                height="100px">
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-expanded="false">Menu</button>
                        <div class="dropdown-menu">
                            {{-- <button class="dropdown-item"
                                wire:click='$emit("openEditModal", {{$kegiatan->id}})'>Ubah</button> --}}
                            <button class="dropdown-item" wire:click='confirmDelete("{{$kegiatan->id}}")'>Hapus</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Data kosong</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex flex-row">
            <div class="mx-auto">
                {{$kegiatans->links()}}
            </div>
        </div>
    </div>
</div>

@section('plugins.EkkoLightbox', true)

@push('js')
<script>
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>
@endpush