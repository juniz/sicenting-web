@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Anda tidak memiliki akses untuk halaman ini'))