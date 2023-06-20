<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Balita</h3>
            <div class="card-tools">
                @can('add balita')
                    <a name="tambahBalita" id="tambahBalita" class="btn btn-sm btn-primary" href="{{ url('/balita/tambah') }}" role="button">Tambah</a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3">
                            Nama
                        </div>
                        <div class="col-md-9">
                            <b>: {{ $balita->nama }}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            Tgl Lahir
                        </div>
                        <div class="col-md-9">
                            <b>: {{ $balita->tgl_lahir }}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            Jenis Kelamin
                        </div>
                        <div class="col-md-9">
                            <b>: {{ $balita->jns_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            Umur
                        </div>
                        <div class="col-md-9">
                            <b>: {{ $umur }}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            Nama Orang Tua
                        </div>
                        <div class="col-md-9">
                            <b>: {{ $balita->nama_ortu }}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            Alamat
                        </div>
                        <div class="col-md-9 mb-3">
                            <b>: {{ $balita->alamat }}</b>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <livewire:balita.input-pemeriksaan :balita='$balita'>
                </div>
            </div>
            @if(!empty($hasil))
            <div class="callout callout-info">
                <h5>Hasil Perhitungan</h5>
                <p>Hasil perhitungan berdasarkan data yang diinputkan</p>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="@if(str_contains($hasil->bb_u, 'kurang')) text-danger @else text-dark @endif ">{{ $hasil->bb_u }}</td>
                                    <td> 
                                        : {{ $this->hasilBBU($hasil->bb_u) }} 
                                        @if(str_contains($hasil->bb_u, 'kurang'))
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#konsulGiziModal">
                                                Lanjut Konsul Ahli Gizi
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="@if(str_contains($hasil->tb_u, 'pendek') || str_contains($hasil->tb_u, 'Pendek')) text-danger @else text-dark @endif ">{{ $hasil->tb_u }}</td>
                                    <td> 
                                        : {{ $this->hasilTBU($hasil->tb_u) }}
                                        @if(str_contains($hasil->tb_u, 'pendek') || str_contains($hasil->tb_u, 'Pendek'))
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#konsulModal">
                                            Lanjut Konsul Tim Stunting
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="@if(str_contains($hasil->bb_tb, 'buruk') || str_contains($hasil->bb_tb, 'Buruk') || str_contains($hasil->bb_tb, 'kurang')) text-danger @else text-dark @endif ">{{ $hasil->bb_tb }}</td>
                                    <td> : {{ $this->hasilBBTB($hasil->bb_tb) }} </td>
                                    @if(str_contains($hasil->bb_tb, 'buruk') || str_contains($hasil->bb_tb, 'Buruk'))
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#konsulGiziModall">
                                            Pemberian Makanan Tambahan (PMT)         
                                        </button>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <form wire:submit.prevent='kirimCatatanKonsul'>
                            <div class="form-group m-4">
                            <label for="">Keterangan Hasil Konsul</label>
                            <textarea class="form-control" wire:model.defer='catatanKonsul' name="catatan_konsul" id="catatan_konsul" rows="3"></textarea>
                            @error('catatan_konsul') <span class="text-danger">{{ $message }}</span> @enderror
                            <div class="d-flex flex-row justify-content-end pt-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
                {{-- <div class="d-flex justify-content-center">
                    <h4> Hasil </h4>
                </div> --}}
            @endif
        </div>
        {{-- <div class="card-footer">
            <div class="d-flex justify-content-end">
                <a name="tambahBalita" id="tambahBalita" class="btn btn-primary" href="{{ url('/balita/tambah') }}" role="button">Tambah</a>
            </div>
        </div> --}}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="konsulModal" tabindex="-1" role="dialog" aria-labelledby="konsulModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saranModalLabel">Rumah Sakit Bhayangkara</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach($rsJajaran as $sp)
                            <li>

                                {{ $sp->nama }}
                                <a 
                                    type="button" 
                                    href="https://api.whatsapp.com/send?phone={{ $sp->telp ?? '' }}&text=Halo%20dok%2C%20saya%20ingin%20konsultasi%20tentang%20pertumbuhan%20anak%0ANama%20:%20{{ $balita->nama ?? '' }}%0AUmur%20:%20{{ $umur ?? '' }}%0ABerat%20Badan%20:%20{{ $hasil->berat ?? '' }}%0ATinggi%20Badan%20:%20{{ $hasil->tinggi ?? '' }}%0ADengan%20hasil:%0ATinggi%20badan%20berdasarkan%20umur%20{{ $hasil->tb_u ?? '' }}%0A%0ATerima%20kasih%20dok%0A%0A" 
                                    target="_blank" 
                                    class="btn btn-success btn-sm m-2">
                                    Kirim Pesan
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="konsulGiziModal" tabindex="-1" role="dialog" aria-labelledby="konsulGiziModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saranModalLabel">Konsul Ahli Gizi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach($gizi as $g)
                            <li>
                                {{ $g->nama }}
                                <a 
                                    type="button" 
                                    href="https://api.whatsapp.com/send?phone={{ $g->telp ?? '' }}&text=Halo%20saya%20ingin%20konsultasi%20tentang%20pertumbuhan%20anak%0ANama%20:%20{{ $balita->nama ?? '' }}%0AUmur%20:%20{{ $umur ?? '' }}%0ABerat%20Badan%20:%20{{ $hasil->berat ?? '' }}%0ATinggi%20Badan%20:%20{{ $hasil->tinggi ?? '' }}%0ADengan%20hasil:%0ATinggi%20badan%20berdasarkan%20umur%20{{ $hasil->tb_u ?? '' }}%0A%0ATerima%20kasih%0A%0A" 
                                    target="_blank" 
                                    class="btn btn-success btn-sm">
                                    Kirim Pesan
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

</div>
