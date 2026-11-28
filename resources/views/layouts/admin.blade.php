
@extends('layouts.base')

@section('role-label', 'Administrator')

@section('page-title', 'Dashboard Admin')

@section('page-subtitle', 'Kelola dan pantau seluruh aktivitas KosHaven')

@section('sidebar')
    {{-- Tambahkan menu navigasi Admin di sini --}}
    @yield('admin-menu')
@endsection
