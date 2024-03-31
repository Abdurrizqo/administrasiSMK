@extends('layouts.layout')
@section('content')
    <div class="w-full poppins-regular p-10 bg-gray-100">
        <span class="text-sm border border-gray-300 inline-block breadcrumbs bg-white px-8 py-3 poppins-medium rounded-full">
            <ul>
                <li><a href="/dashboard/kelas">Data Kelas</a></li>
                <li><a class="capitalize" href="#">Tambah Siswa Ke Kelas</li></a>
            </ul>
        </span>

        <div class="border rounded-md bg-white p-10 mt-10">
            <h1 class="text-lg poppins-semibold">{{ $kelas['namaKelas'] }}</h1>
            <p class="poppins-light text-gray-400">{{ $kelas['tahunAjaran'] }}</p>
        </div>

        <livewire:tambah-siswa-kelas :idKelas="$idKelas" />
    </div>
@endsection
