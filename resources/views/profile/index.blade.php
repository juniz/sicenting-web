@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Profile User</h1>
@stop

@section('content')
    @include('flash-message')
    <div class="row">
        <div class="col-md-4">
            <x-adminlte-profile-widget name="{{ $user->name ?? '' }}" desc="{{ $user->unit->nama ?? '' }}" theme="lightblue"
            img="https://picsum.photos/id/1/100" layout-type="classic">
            <x-adminlte-profile-row-item icon="fas fa-fw fa-user-friends" title="Berat badan kurang" text="{{$bb}}"
                url="#" badge="teal"/>
            <x-adminlte-profile-row-item icon="fas fa-fw fa-user-friends fa-flip-horizontal" title="Pendek (Stunting)"
                text="{{$tb}}" url="#" badge="lightblue"/>
            <x-adminlte-profile-row-item icon="fas fa-fw fa-sticky-note" title="Gizi kurang" text="{{$bbtb}}"
                url="#" badge="navy"/>
            </x-adminlte-profile-widget>
        </div>
        <div class="col-md-8">
            <x-adminlte-card title="Data Diri">
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-input name="name" label="Nama" placeholder="Nama" fgroup-class="col-md-12" value="{{ $user->name }}" disabled/>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="email" label="Email" placeholder="Email" fgroup-class="col-md-12" value="{{ $user->email }}" disabled/>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="unit" label="Unit" placeholder="Unit" fgroup-class="col-md-12" value="{{ $user->unit->nama ?? '' }}" disabled/>
                    </div>
                    <div class="col-md-6">
                        <x-adminlte-input name="role" label="Role" placeholder="Role" fgroup-class="col-md-12" value="{{ $user->roles->first()->name }}" disabled/>
                    </div>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop

@push('js')
<script>
</script>
@endpush