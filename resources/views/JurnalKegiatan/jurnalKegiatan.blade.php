@extends('layouts.layout')
@section('content')
    <div class="w-full">
        <div class="flex w-full mb-10 justify-between gap-y-4 items-center flex-wrap">
            <h1 class="text-2xl font-bold">Jurnal Kegiatan</h1>

            <div class="flex gap-4 items-center">
                <a href="/dashboard/jurnal-kegiatan/tulis-jurnal"
                    class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular">Tulis Jurnal</a>
                <a target="_blank"
                    href="/dashboard/jurnal-kegiatan/export-jurnal?tanggalMulai={{ $tanggalMulai }}&tanggalAkhir={{ $tanggalAkhir }}"
                    class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular">Export Jurnal</a>
            </div>

        </div>

        @if (session('success'))
            <div role="alert" class="alert alert-success mb-8 text-white">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-8 text-white">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="w-full">
            <form class="flex flex-wrap items-center gap-4">
                <input type="date" value="{{ $tanggalMulai }}"
                    class="border p-3 rounded-full min-w-60 max-w-72 outline-none" name="tanggalMulai" />
                <input type="date" value="{{ $tanggalAkhir }}"
                    class="border p-3 rounded-full min-w-60 max-w-72 outline-none" name="tanggalAkhir" />

                <button class="btn-outline border border-neutral rounded-full w-24 py-2">Cari</button>
            </form>
        </div>

        <div class="mt-12 rounded-lg border bg-white p-4 text-xs md:text-sm lg:text-base">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Penulis</th>
                        <th class="text-center">Materi Kegiatan</th>
                        <th class="text-center">Hasil</th>
                        <th class="text-center">Hambatan</th>
                        <th class="text-center">Solusi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jurnalKegiatan as $index => $item)
                        <tr class="h-20">
                            <th class="text-center">{{ ++$index }}</th>
                            <td>{{ $item['tanggalDibuat'] }}</td>
                            <td>{{ $item['namaPegawai'] }}</td>
                            <td>{{ $item['materiKegiatan'] }}</td>
                            <td>{{ $item['Hasil'] }}</td>
                            <td>{{ $item['Hambatan'] }}</td>
                            <td>{{ $item['Solusi'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
