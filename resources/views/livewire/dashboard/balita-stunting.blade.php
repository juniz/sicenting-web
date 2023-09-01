<div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-row justify-content-end mb-3">
                <div class="col-md-2">
                    <input id="search" wire:model.debounce.500ms='search' class="form-control" type="text" name="search"
                        placeholder="Cari balita .....">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <td>No. KK</td>
                            <td>Nama</td>
                            <td>Jns Kelamin</td>
                            <td>Tgl Lahir</td>
                            <td>Nama Ortu</td>
                            <td>TB/U</td>
                            <td>BB/U</td>
                            <td>TB/BB</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($balitas as $balita)
                        <tr>
                            <td>{{$balita->nik}}</td>
                            <td>{{$balita->nama}}</td>
                            <td>{{$balita->jns_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan'}}</td>
                            <td>{{$balita->tgl_lahir}}</td>
                            <td>{{$balita->nama_ortu}}</td>
                            <td class="@if(Str::contains(strtolower($balita->tb_u), 'pendek')) text-danger @endif">
                                {{$balita->tb_u}}
                            </td>
                            <td class="@if(Str::contains(strtolower($balita->bb_u), 'kurang')) text-danger @endif">
                                {{$balita->bb_u}}
                            </td>
                            <td
                                class="@if(Str::contains(strtolower($balita->bb_tb), ['kurang', 'lebih', 'obesitas'])) text-danger @endif">
                                {{$balita->bb_tb}}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center">Data tidak ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex flex-row">
                    <div class="mx-auto">
                        {{$balitas->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>