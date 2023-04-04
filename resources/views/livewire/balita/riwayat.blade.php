<div>
    <div class="card">
        <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Riwayat</h3>
            <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Pemeriksaan</a></li>
                <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Grafik TB/U</a></li>
                <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Grafik BB/U</a></li>
                <li class="nav-item"><a class="nav-link" href="#tab_4" data-toggle="tab">Grafik BB/TB</a></li>
            </ul>
        </div>
        <div class="card-body">
        <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <table id="tablePemeriksaan" class="table table-striped table-responsive" style="width: 100%">
                <thead class="thead-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Berat</th>
                        <th>Tinggi</th>
                        <th>Usia</th>
                        <th>BB/U</th>
                        <th>Z-Score BB/U</th>
                        <th>TB/U</th>
                        <th>Z-Score TB/U</th>
                        <th>BB/TB</th>
                        <th>Z-Score BB/TB</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($pemeriksaan as $p)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($p['tgl_pengukuran'])->format('d-m-Y') }}</td>
                            <td>{{ $p['berat'] }}</td>
                            <td>{{ $p['tinggi'] }}</td>
                            <td>{{ $p['usia'] }} bulan</td>
                            <td class="@if(str_contains($p['bb_u'], 'kurang')) text-danger @else text-dark @endif ">{{ $p['bb_u'] }}</td>
                            <td>{{ $p['zs_bbu'] }}</td>
                            <td class="@if(str_contains($p['tb_u'], 'pendek') || str_contains($p['tb_u'], 'Pendek')) text-danger @else text-dark @endif ">{{ $p['tb_u'] }}</td>
                            <td>{{ $p['zs_tbu'] }}</td>
                            <td class="@if(str_contains($p['bb_tb'], 'kurang')) text-danger @else text-dark @endif ">{{ $p['bb_tb'] }}</td>
                            <td>{{ $p['zs_bbtb'] }}</td>
                            <td>
                                <div class="btn-group">
                                    <button wire:click="hasilPemeriksaan('{{ $p['id'] }}')" type="button" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="konfirmasiHapus('{{ $p['id'] }}')" type="button" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
        
        <div class="tab-pane" id="tab_2">
            <div style="width: 100%;height: 500px">
                <canvas id="chartTBU"></canvas>
            </div>        
        </div>
        
        <div class="tab-pane" id="tab_3">
            <div style="width: 100%;height: 500px">
                <canvas id="chartBBU"></canvas>
            </div>       
        </div>

        <div class="tab-pane" id="tab_4">
            <div style="width: 100%;height: 500px">
                <canvas id="chartBBTB"></canvas>
            </div>       
        </div>
        
        </div>
        
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="saranModal" tabindex="-1" role="dialog" aria-labelledby="saranModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saranModalLabel">Saran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(!empty($hasil))
                    <div class="row">
                        <div class="col-md-6">
                            <a class="@if(str_contains($hasil['bbu'], 'kurang')) text-danger @else text-dark @endif ">{{ $hasil['bbu'] }}</a>
                        </div>
                        <div class="col-md-6">
                            {{ $hasil['hasil_bbu'] }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a class="@if(str_contains($hasil['tbu'], 'pendek') || str_contains($hasil['tbu'], 'Pendek')) text-danger @else text-dark @endif ">{{ $hasil['tbu'] }}</a>
                        </div>
                        <div class="col-md-6">
                            {{ $hasil['hasil_tbu'] }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a class="@if(str_contains($hasil['bbtb'], 'buruk') || str_contains($hasil['bbtb'], 'kurang')) text-danger @else text-dark @endif ">{{ $hasil['bbtb'] }}</a>
                        </div>
                        <div class="col-md-6">
                            {{ $hasil['hasil_bbtb'] }}
                        </div>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('component.initialized', (component) => {})
        Livewire.hook('element.initialized', (el, component) => {})
        Livewire.hook('element.updating', (fromEl, toEl, component) => {
            if (fromEl.id == 'tablePemeriksaan') {
                $('#tablePemeriksaan').DataTable().destroy();
            }
        })
        Livewire.hook('element.updated', (el, component) => {
            if (el.id == 'tablePemeriksaan') {
                $('#tablePemeriksaan').DataTable({
                    'order' : [
                        [0, 'desc']
                    ]
                });
            }
            var ctx = document.getElementById("chartTBU").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: JSON.parse("{{ $usia }}"),
                    datasets: [
                        {
                            label: 'Median',
                            data: JSON.parse("{{ $tbuMedian }}"),
                            pointRadius: 0,
                            fill: false,
                            borderColor: 'rgb(0, 255, 0)',
                            tension: 0.1
                        },
                        {
                            label: '+2 sd',
                            data: JSON.parse("{{ $tbuPlus2Sd }}"),
                            pointRadius: 0,
                            fill: false,
                            borderColor: 'rgb(255, 255, 0)',
                            tension: 0.1
                        },
                        {
                            label: '+3 sd',
                            data: JSON.parse("{{ $tbuPlus3Sd }}"),
                            pointRadius: 0,
                            fill: false,
                            borderColor: 'rgb(255, 0, 0)',
                            tension: 0.1
                        },
                        {
                            label: '-2 sd',
                            data: JSON.parse("{{ $tbuMin2Sd }}"),
                            pointRadius: 0,
                            fill: false,
                            borderColor: 'rgb(255, 255, 0)',
                            tension: 0.1
                        },
                        {
                            label: '-3 sd',
                            data: JSON.parse("{{ $tbuMin3Sd }}"),
                            pointRadius: 0,
                            fill: false,
                            borderColor: 'rgb(255, 0, 0)',
                            tension: 0.1
                        },
                        {
                            label: 'Tinggi Badan',
                            data: JSON.parse("{{ $tbu }}"),
                            fill: false,
                            borderColor: 'rgb(0, 0, 0)',
                            tension: 0.1
                        }
                    ]
                },
                options:{
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            var ctxBBU = document.getElementById("chartBBU").getContext('2d');
            var myChart = new Chart(ctxBBU, {
                type: 'line',
                data: {
                    labels: JSON.parse("{{ $usia }}"),
                    datasets: [
                        {
                            label: 'Median',
                            data: JSON.parse("{{ $bbuMedian }}"),
                            pointRadius: 0,
                            fill: false,
                            borderColor: 'rgb(0, 255, 0)',
                            tension: 0.1
                        },
                        {
                            label: '+2 sd',
                            data: JSON.parse("{{ $bbuPlus2Sd }}"),
                            pointRadius: 0,
                            fill: false,
                            borderColor: 'rgb(255, 255, 0)',
                            tension: 0.1
                        },
                        {
                            label: '+3 sd',
                            data: JSON.parse("{{ $bbuPlus3Sd }}"),
                            pointRadius: 0,
                            fill: false,
                            borderColor: 'rgb(255, 0, 0)',
                            tension: 0.1
                        },
                        {
                            label: '-2 sd',
                            data: JSON.parse("{{ $bbuMin2Sd }}"),
                            pointRadius: 0,
                            fill: false,
                            borderColor: 'rgb(255, 255, 0)',
                            tension: 0.1
                        },
                        {
                            label: '-3 sd',
                            data: JSON.parse("{{ $bbuMin3Sd }}"),
                            pointRadius: 0,
                            fill: false,
                            borderColor: 'rgb(255, 0, 0)',
                            tension: 0.1
                        },
                        {
                            label: 'Berat Badan',
                            data: JSON.parse("{{ $bbu }}"),
                            fill: false,
                            borderColor: 'rgb(0, 0, 0)',
                            tension: 0.1
                        }
                    ]
                },
                options:{
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            var ctxBBTB = document.getElementById("chartBBTB").getContext('2d');
            var myChart = new Chart(ctxBBTB, {
                type: 'line',
                data: {
                    labels: JSON.parse("{{ $tb }}"),
                    datasets: [
                        {
                            label: 'Median',
                            data: JSON.parse("{{ $bbtbMedian }}"),
                            pointRadius: 0,
                            fill: false,
                            borderColor: 'rgb(0, 255, 0)',
                            tension: 0.1
                        },
                        {
                            label: '+2 sd',
                            data: JSON.parse("{{ $bbtbPlus2Sd }}"),
                            pointRadius: 0,
                            fill: false,
                            borderColor: 'rgb(255, 255, 0)',
                            tension: 0.1
                        },
                        {
                            label: '+3 sd',
                            data: JSON.parse("{{ $bbtbPlus3Sd }}"),
                            pointRadius: 0,
                            fill: false,
                            borderColor: 'rgb(255, 0, 0)',
                            tension: 0.1
                        },
                        {
                            label: '-2 sd',
                            data: JSON.parse("{{ $bbtbMin2Sd }}"),
                            pointRadius: 0,
                            fill: false,
                            borderColor: 'rgb(255, 255, 0)',
                            tension: 0.1
                        },
                        {
                            label: '-3 sd',
                            data: JSON.parse("{{ $bbtbMin3Sd }}"),
                            pointRadius: 0,
                            fill: false,
                            borderColor: 'rgb(255, 0, 0)',
                            tension: 0.1
                        },
                        {
                            label: 'Berat Badan',
                            data: JSON.parse("{{ $tbu }}"),
                            fill: false,
                            borderColor: 'rgb(0, 0, 0)',
                            tension: 0.1
                        }
                    ]
                },
                options:{
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        })
        Livewire.hook('element.removed', (el, component) => {})
        Livewire.hook('message.sent', (message, component) => {})
        Livewire.hook('message.failed', (message, component) => {})
        Livewire.hook('message.received', (message, component) => {})
        Livewire.hook('message.processed', (message, component) => {})
    });


    $(function () {
        $('#tablePemeriksaan').DataTable();

        window.addEventListener('modal:saran',function(e){
            $('#saranModal').modal('show');
        });

        window.addEventListener('swal:toast',function(e){
            Swal.fire(e.detail);
        });

        window.addEventListener('swal:confirm',function(e){
                Swal.fire({
                    title: e.detail.title,
                    text: e.detail.text,
                    icon: e.detail.icon,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: e.detail.confirmButtonText,
                    cancelButtonText: e.detail.cancelButtonText,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.livewire.emit(e.detail.function, e.detail.params[0]);
                    }
                });
            });
    });

    var ctx = document.getElementById("chartTBU").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: JSON.parse("{{ $usia }}"),
            datasets: [
                {
                    label: 'Tinggi Badan',
                    data: JSON.parse("{{ $tbu }}"),
                    fill: false,
                    borderColor: 'rgb(0, 0, 0)',
                    pointBackgroundColor: 'rgb(0, 0, 0)',
                    pointRadius: 5,
                    tension: 0.1,
                    pointHoverRadius: 8,
                },
                {
                    label: 'Median',
                    data: JSON.parse("{{ $tbuMedian }}"),
                    pointRadius: 0,
                    fill: false,
                    borderColor: 'rgb(0, 255, 0)',
                },
                {
                    label: '+2 sd',
                    data: JSON.parse("{{ $tbuPlus2Sd }}"),
                    pointRadius: 0,
                    fill: false,
                    borderColor: 'rgb(255, 255, 0)',
                },
                {
                    label: '+3 sd',
                    data: JSON.parse("{{ $tbuPlus3Sd }}"),
                    pointRadius: 0,
                    fill: false,
                    borderColor: 'rgb(255, 0, 0)',
                },
                {
                    label: '-2 sd',
                    data: JSON.parse("{{ $tbuMin2Sd }}"),
                    pointRadius: 0,
                    fill: false,
                    borderColor: 'rgb(255, 255, 0)',
                },
                {
                    label: '-3 sd',
                    data: JSON.parse("{{ $tbuMin3Sd }}"),
                    pointRadius: 0,
                    fill: false,
                    borderColor: 'rgb(255, 0, 0)',
                },
            ],
        },
        options:{
            responsive: true,
            maintainAspectRatio: false,
        }
    });

    var ctxBBU = document.getElementById("chartBBU").getContext('2d');
    var myChart = new Chart(ctxBBU, {
        type: 'line',
        data: {
            labels: JSON.parse("{{ $usia }}"),
            datasets: [
                {
                    label: 'Berat Badan',
                    data: JSON.parse("{{ $bbu }}"),
                    fill: false,
                    borderColor: 'rgb(0, 0, 0)',
                    pointBackgroundColor: 'rgb(0, 0, 0)',
                    pointRadius: 5,
                    tension: 0.1,
                    pointHoverRadius: 8,
                },
                {
                    label: 'Median',
                    data: JSON.parse("{{ $bbuMedian }}"),
                    pointRadius: 0,
                    fill: false,
                    borderColor: 'rgb(0, 255, 0)',
                    tension: 0.1
                },
                {
                    label: '+2 sd',
                    data: JSON.parse("{{ $bbuPlus2Sd }}"),
                    pointRadius: 0,
                    fill: false,
                    borderColor: 'rgb(255, 255, 0)',
                    tension: 0.1
                },
                {
                    label: '+3 sd',
                    data: JSON.parse("{{ $bbuPlus3Sd }}"),
                    pointRadius: 0,
                    fill: false,
                    borderColor: 'rgb(255, 0, 0)',
                    tension: 0.1
                },
                {
                    label: '-2 sd',
                    data: JSON.parse("{{ $bbuMin2Sd }}"),
                    pointRadius: 0,
                    fill: false,
                    borderColor: 'rgb(255, 255, 0)',
                    tension: 0.1
                },
                {
                    label: '-3 sd',
                    data: JSON.parse("{{ $bbuMin3Sd }}"),
                    pointRadius: 0,
                    fill: false,
                    borderColor: 'rgb(255, 0, 0)',
                    tension: 0.1
                },
            ]
        },
        options:{
            responsive: true,
            maintainAspectRatio: false,
        }
    });

    var ctxBBTB = document.getElementById("chartBBTB").getContext('2d');
    var myChart = new Chart(ctxBBTB, {
        type: 'line',
        data: {
            labels: JSON.parse("{{ $tb }}"),
            datasets: [
                {
                    label: 'Berat Badan',
                    data: JSON.parse("{{ $bbPemeriksaan }}"),
                    fill: false,
                    borderColor: 'rgb(0, 0, 0)',
                    pointBackgroundColor: 'rgb(0, 0, 0)',
                    pointRadius: 5,
                    tension: 0.1,
                    pointHoverRadius: 8,
                },
                {
                    label: 'Median',
                    data: JSON.parse("{{ $bbtbMedian }}"),
                    pointRadius: 0,
                    fill: false,
                    borderColor: 'rgb(0, 255, 0)',
                    tension: 0.1
                },
                {
                    label: '+2 sd',
                    data: JSON.parse("{{ $bbtbPlus2Sd }}"),
                    pointRadius: 0,
                    fill: false,
                    borderColor: 'rgb(255, 255, 0)',
                    tension: 0.1
                },
                {
                    label: '+3 sd',
                    data: JSON.parse("{{ $bbtbPlus3Sd }}"),
                    pointRadius: 0,
                    fill: false,
                    borderColor: 'rgb(255, 0, 0)',
                    tension: 0.1
                },
                {
                    label: '-2 sd',
                    data: JSON.parse("{{ $bbtbMin2Sd }}"),
                    pointRadius: 0,
                    fill: false,
                    borderColor: 'rgb(255, 255, 0)',
                    tension: 0.1
                },
                {
                    label: '-3 sd',
                    data: JSON.parse("{{ $bbtbMin3Sd }}"),
                    pointRadius: 0,
                    fill: false,
                    borderColor: 'rgb(255, 0, 0)',
                    tension: 0.1
                },
            ]
        },
        options:{
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
@endpush
