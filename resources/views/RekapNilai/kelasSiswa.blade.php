@extends('layouts.layoutPegawai')
@section('content')
    <div class="min-h-[100vh] pt-28 px-8 pb-10 max-w-full">
        <span
            class="text-sm border border-gray-300 inline-block breadcrumbs bg-white px-8 py-3 poppins-medium rounded-full mb-10">
            <ul>
                <li><a href="/home">Home</a></li>
                <li><a href="#">Data siswa</li></a>
            </ul>
        </span>

        <div class="w-full bg-white border p-4 rounded-lg">
            <h1 class="poppins-semibold text-lg">{{ $kelasMapel->namaKelas }}</h1>
            <p class="text-gray-400 poppins-light">{{ $kelasMapel->namaMataPelajaran }}</p>
        </div>

        <livewire:input-nilai :idKelas="$kelasMapel->kelas" :idKelasMapel="$kelasMapel->idKelasMapel" :semester="$kelasMapel->semester" />

    </div>
@endsection
