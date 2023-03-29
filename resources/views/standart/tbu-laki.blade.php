@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Input Standart Tinggi Badan Berdasarkan Umur Anak Laki-Laki</h1>
@stop

@section('content')
    {{-- <livewire:standart.input-tbu-laki /> --}}
    <x-adminlte-card title="Data" >
        <x-adminlte-datatable id="tableTBULaki" :heads="$heads" head-theme="dark"
    striped hoverable bordered compressed>
            @foreach($tbu_laki as $bbu)
                <tr>
                    <td>{{ $bbu->usia }}</td>
                    <td>{{ $bbu->min3sd }}</td>
                    <td>{{ $bbu->min2sd }}</td>
                    <td>{{ $bbu->min1sd }}</td>
                    <td>{{ $bbu->median }}</td>
                    <td>{{ $bbu->plus1sd }}</td>
                    <td>{{ $bbu->plus2sd }}</td>
                    <td>{{ $bbu->plus3sd }}</td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop