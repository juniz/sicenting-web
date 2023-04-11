@extends('adminlte::page')

@section('title', 'Laporan Pengukuran Balita Kabupaten Nganjuk')

@section('content_header')
    <h1>Laporan Pengukuran Balita Kabupaten Nganjuk</h1>
@stop

@section('content')
    @include('flash-message')
    <x-adminlte-card >
        <x-slot name="toolsSlot">
            <form action="{{ route('report') }}" method="GET">
                <x-adminlte-date-range name="tanggal" enable-default-ranges="Today">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </x-slot>
                    <x-slot name="appendSlot">
                        <x-adminlte-button id='filterButton' theme="outline-info" label="Cari" type="submit" icon="fas fa-lg fa-filter"/>
                    </x-slot>
                </x-adminlte-date-range>
            </form>
        </x-slot>
        <x-adminlte-datatable id="reportTable" :heads="$heads" head-theme="dark" striped hoverable bordered compressed with-buttons>
            @foreach($datas as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->jns_kelamin }}</td>
                <td>{{ Carbon\Carbon::parse($data->tgl_lahir)->format('Y-m-d') }}</td>
                <td>{{ $data->usia }} bulan</td>
                <td>{{ Carbon\Carbon::parse($data->created_at)->format('Y-m-d') }}</td>
                <td>{{ $data->berat }}</td>
                <td>{{ $data->tinggi }}</td>
                <td>{{ $data->lila }}</td>
                <td>{{ $data->bb_u }}</td>
                <td>{{ $data->zs_bbu }}</td>
                <td>{{ $data->tb_u }}</td>
                <td>{{ $data->zs_tbu }}</td>
                <td>{{ $data->bb_tb }}</td>
                <td>{{ $data->zs_bbtb }}</td>
            </tr>
            @endforeach
        </x-adminlte-datatable>
    </x-adminlte-card>
@stop

@push('js')
<script>
    // $('#filterButton').on('click', function(e){
    //     // e.preventdefault();
    //     var drCustomRanges = $('#drCustomRanges').val();
    //     var drCustomRangesSplit = drCustomRanges.split(' - ');
    //     var startDate = drCustomRangesSplit[0];
    //     var endDate = drCustomRangesSplit[1];
    //     location.reload("{{ route('report', ['start' => "+startDate+", 'end' => "+endDate+"]) }}");
        
    // });
</script>
@endpush