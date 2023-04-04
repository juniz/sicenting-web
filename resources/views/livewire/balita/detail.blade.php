<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Balita</h3>
            <div class="card-tools">
                <a name="tambahBalita" id="tambahBalita" class="btn btn-primary" href="{{ url('/balita/tambah') }}" role="button">Tambah</a>
            </div>
        </div>
        <div class="card-body">
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
            @if(!empty($hasil))
                <div class="d-flex justify-content-center">
                    <h4> Hasil </h4>
                </div>
                <div class="col-md-12">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="@if(str_contains($hasil->bb_u, 'kurang')) text-danger @else text-dark @endif ">{{ $hasil->bb_u }}</td>
                                <td> : {{ $this->hasilBBU($hasil->bb_u) }} </td>
                            </tr>
                            <tr>
                                <td class="@if(str_contains($hasil->tb_u, 'pendek') || str_contains($hasil->tb_u, 'Pendek')) text-danger @else text-dark @endif ">{{ $hasil->tb_u }}</td>
                                <td> : {{ $this->hasilTBU($hasil->tb_u) }} </td>
                            </tr>
                            <tr>
                                <td class="@if(str_contains($hasil->bb_tb, 'buruk') || str_contains($hasil->bb_tb, 'Buruk')) text-danger @else text-dark @endif ">{{ $hasil->bb_tb }}</td>
                                <td> : {{ $this->hasilBBTB($hasil->bb_tb) }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        {{-- <div class="card-footer">
            <div class="d-flex justify-content-end">
                <a name="tambahBalita" id="tambahBalita" class="btn btn-primary" href="{{ url('/balita/tambah') }}" role="button">Tambah</a>
            </div>
        </div> --}}
    </div>
</div>
