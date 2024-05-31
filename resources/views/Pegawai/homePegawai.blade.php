@extends('layouts.layoutPegawai')
@section('content')
    <div class="flex h-[100vh] gap-5 pt-28 px-8 pb-10">
        <div class="min-w-[20rem] max-w-[20rem] flex flex-col gap-3">
            <div class="border rounded-lg bg-white p-4 h-[10rem] flex flex-col items-center justify-center">
                @if ($waliKelas)
                    <h1 class="text-lg poppins-bold text-center">Kelas {{ $waliKelas->namaKelas }}</h1>
                    <h1 class="text-lg poppins-regular text-gray-400 text-center mt-3">{{ $profileSekolah->tahunAjaran }} -
                        {{ $profileSekolah->semester }}</h1>
                    <a target="_blank" href="home/rekap-nilai-kelas"
                        class="btn-click text-center mt-5 py-1 w-full border rounded-lg border-gray-800 text-white bg-gray-800">Ledger</a>
                @else
                    <h1 class="text-lg poppins-bold text-center text-gray-500">Tidak Terdaftar Sebagai Wali Kelas</h1>
                @endif
            </div>

            <div class="border rounded-lg bg-white p-4 flex-grow overflow-auto">
                <h1 class="mb-5 text-xl poppins-bold">Daftar Kelas</h1>

                @foreach ($kelasDiampu as $item)
                    <a href="home/kelas/{{ $item->idKelasMapel }}" class="p-3 rounded-md border shadow mb-4 block">
                        <h3 class="text-lg poppins-medium">{{ $item->namaKelas }}</h3>
                        <p class="text-gray-500">{{ $item->namaMataPelajaran }}</p>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="flex-grow flex flex-col gap-6">
            <div class="flex-grow h-full bg-white rounded-lg border p-4 overflow-auto">
                <h1 class="mb-5 text-xl poppins-bold">Daftar Siswa</h1>

                <div class="flex flex-wrap gap-5 justify-center items-start">
                    @if ($siswa)
                        @foreach ($siswa as $item)
                            <a href="home/siswa/{{ $waliKelas->idKelas }}/{{ $item->idSiswa }}"
                                class="border shadow mb-4 rounded-xl w-[20rem] btn-click">
                                <div class="w-full bg-gray-700 px-3 py-2 text-white rounded-t-xl flex justify-end">
                                </div>

                                <div class="px-8 py-4 flex justify-end items-center">
                                    <div class="flex-1">
                                        <h1 class="poppins-semibold text-lg">{{ $item->namaSiswa }}</h1>
                                        <p class="poppins-light text-gray-400">NIS : {{ $item->nis }}</p>
                                        <p class="poppins-light text-gray-400">NISN : {{ $item->nisn }}</p>
                                    </div>
                                </div>

                            </a>
                        @endforeach
                    @else
                        <div></div>
                    @endif
                </div>
            </div>
        </div>

        <div class="w-[20rem] flex flex-col gap-6">
            <div class="border rounded-lg bg-white p-4">
                <a href="/rencana-kegiatan" class="bg-gray-800 text-white w-full py-2 inline-block text-center rounded btn-click hover:bg-gray-900">Rencana Kegiata Sekolah</a>
            </div>

            <div class="border rounded-lg bg-white p-4 h-full flex-1">
                <h1 class="mb-5 text-xl poppins-bold">Disposisi</h1>

                @foreach ($disposisi as $item)
                    <a href="home/disposisi/{{ $item->idDisposisi }}" class="border-b border-neutral block pb-3 px-2">
                        <h1 class="poppins-medium w-full truncate">{{ $item->judulDisposisi }}</h1>
                        <p class="popping-light text-gray-400">{{ $item->tanggalDisposisi }}</p>
                    </a>
                @endforeach

            </div>
        </div>
    </div>
@endsection
