
@extends('layouts.base')

@section('role-label', 'Petugas')

@section('page-title', 'Dashboard Petugas')

@section('page-subtitle', 'Kelola aktivitas operasional KosHaven')

@section('sidebar')
    {{-- Tambahkan menu navigasi Petugas di sini --}}
    @yield('petugas-menu')
@endsection
