@extends('layouts.layout')
@section('content')
    <div class="w-full poppins-regular p-10 bg-gray-100">
        <span class="text-sm border border-gray-300 inline-block breadcrumbs bg-white px-8 py-3 poppins-medium rounded-full">
            <ul>
                <li><a href="/dashboard/kelas">Data Kelas</a></li>
                <li><a class="capitalize" href="#">Mata Pelajaran Kelas Semester {{ $semester }}</li></a>
            </ul>
        </span>

        <livewire:tambah-mapel-kelas :idKelas="$idKelas" :semester="$semester" />
    </div>
@endsection
