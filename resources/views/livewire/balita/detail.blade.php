<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Balita</h3>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    Nama
                </div>
                <div class="col-md-6">
                    <b>: {{ $balita->nama }}</b>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    Tgl Lahir
                </div>
                <div class="col-md-6">
                    <b>: {{ $balita->tgl_lahir }}</b>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    Jenis Kelamin
                </div>
                <div class="col-md-6">
                    <b>: {{ $balita->jns_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</b>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    Umur
                </div>
                <div class="col-md-6">
                    <b>: {{ $umur }}</b>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    Nama Orang Tua
                </div>
                <div class="col-md-6">
                    <b>: {{ $balita->nama_ortu }}</b>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    Alamat
                </div>
                <div class="col-md-6 mb-3">
                    <b>: {{ $balita->alamat }}</b>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                <a name="tambahBalita" id="tambahBalita" class="btn btn-primary" href="{{ url('/balita/tambah') }}" role="button">Tambah</a>
            </div>
        </div>
    </div>
</div>
