@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Server tidak tersedia, silahkan coba beberapa saat lagi'))