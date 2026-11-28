
@extends('layouts.base')

@section('role-label', 'Penghuni')

@section('page-title', 'Dashboard Penghuni')

@section('page-subtitle', 'Selamat datang di KosHaven')

@section('sidebar')
    {{-- Tambahkan menu navigasi Penghuni di sini --}}
    @yield('penghuni-menu')
@endsection
