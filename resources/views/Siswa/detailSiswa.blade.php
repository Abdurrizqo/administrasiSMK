@extends('layouts.layout')
@section('content')
    <div class="w-full flex-1 bg-gray-200/60 p-10">
        <div class="w-full rounded-md border shadow p-6 bg-white">
            <div class="flex justify-center flex-col items-center">
                <div class="w-28 h-28 rounded-full bg-gray-300 relative">
                    <button class="material-icons absolute bottom-0 right-0">
                        add_circle
                    </button>
                </div>

                <h1 class="text-lg font-semibold text-center mt-6">{{ $siswa->namaSiswa }}</h1>
            </div>

            <div class="divider"></div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 w-full">
                <div class="flex-1">
                    <h1 class="text-xl font-bold text-center mb-8">Biodata Siswa</h1>

                    <div class="flex w-full flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">NISN</h1>
                        <p class="text-gray-500">{{ $siswa->nisn }}</p>
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">NIS</h1>
                        <p class="text-gray-500">{{ $siswa->nis }}</p>
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">Jurusan</h1>
                        <p class="text-gray-500">{{ $siswa->jurusan->namaJurusan }}</p>
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">Tahun Masuk</h1>
                        <p class="text-gray-500">{{ $siswa->tahunMasuk }}</p>
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">Tahun Lulus</h1>
                        @if ($siswa->tahunLulus)
                            <p class="text-gray-500">{{ $siswa->tahunLulus }}</p>
                        @else
                            <p class="text-gray-500">-</p>
                        @endif
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">Status</h1>
                        @if ($siswa->status === 'aktif')
                            <p class="text-white uppercase badge p-2 badge-success">{{ $siswa->status }}</p>
                        @elseif($siswa->status === 'lulus')
                            <p class="text-white uppercase badge p-2 badge-error">{{ $siswa->status }}</p>
                        @endif
                    </div>

                </div>

                <div class="flex-1">
                    <h1 class="text-xl font-bold text-center mb-8">Biodata Wali Siswa</h1>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">Nama Wali</h1>
                        <p class="text-gray-500">{{ $siswa->namaWali }}</p>
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">NIK</h1>
                        <p class="text-gray-500">{{ $siswa->nikWali }}</p>
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">Hubungan Keluarga</h1>
                        <p class="text-gray-500">{{ $siswa->hubunganKeluarga }}</p>
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">Alamat</h1>
                        <p class="text-gray-500">{{ $siswa->alamat }}</p>
                    </div>

                </div>
            </div>
        </div>

        <div class="w-full rounded-md border shadow p-6 mt-10 bg-white">
            <h1 class="font-bold text-lg">Informasi Alumni</h1>
        </div>

        <div class="w-full rounded-md border shadow p-6 my-10 bg-white">
            <h1 class="font-bold text-lg">Riwayat Kelas</h1>

            <div class="w-full flex flex-wrap gap-12 mt-5">
                @foreach ($kelas as $item)
                    <a href="{{$item->idSiswa}}/raport/{{$item->idKelas}}" class="rounded-lg border bg-white w-80">
                        <div class="w-full rounded-t-lg bg-neutral text-white p-3"></div>
                        <div class="p-3">
                            <h1 class="poppinns-medium text-lg">{{ $item->namaKelas }}</h1>
                            <p class="text-gray-400">{{ $item->tahunAjaran }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
