@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Profile User</h1>
@stop

@section('content')
    @include('flash-message')
    <div class="row">
        <div class="col-md-4">
            <x-adminlte-profile-widget name="{{ $user->name ?? '' }}" desc="{{ $user->email ?? '' }}" theme="lightblue"
            img="{{$user->avatar}}" layout-type="classic">
            <x-adminlte-profile-row-item icon="fas fa-fw fa-user-friends" title="Berat badan kurang" text="{{$bb}}"
                url="#" badge="teal"/>
            <x-adminlte-profile-row-item icon="fas fa-fw fa-user-friends fa-flip-horizontal" title="Pendek (Stunting)"
                text="{{$tb}}" url="#" badge="lightblue"/>
            <x-adminlte-profile-row-item icon="fas fa-fw fa-sticky-note" title="Gizi kurang" text="{{$bbtb}}"
                url="#" badge="navy"/>
            </x-adminlte-profile-widget>
        </div>
        <div class="col-md-8">
            <x-adminlte-card title="Ganti Password">
                <livewire:profile.data-diri />
            </x-adminlte-card>
        </div>
    </div>
@stop

@push('js')
<script>
</script>
@endpush