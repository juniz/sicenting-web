<!DOCTYPE html>
<html>

<head>
    <title>Laporan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 10pt;
        }
    </style>
    <center>
        <h6>Rekap Kegiatan</h6>
    </center>

    <table class='table table-sm table-bordered'>
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama Kegiatan</th>
                <th>Tanggal</th>
                <th>Photo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kegiatans as $kegiatan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kegiatan->nama_kegiatan }}</td>
                <td>{{ \Carbon\Carbon::parse($kegiatan->created_at)->format('d-m-Y H:m:s') }}</td>
                <td>
                    <img src="{{ storage_path('app/public/kegiatan/'.$kegiatan->photo) }}" alt="" width="80px"
                        height="50px">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>