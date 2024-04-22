@extends('layouts.layout')
@section('content')
    <div class="w-full">
        <div class="flex w-full mb-10 justify-between gap-y-4 items-center flex-wrap">
            <h1 class="text-2xl font-bold w-[32rem]">Data Siswa</h1>
            <div class="flex justify-center items-center gap-4">
                <a class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular"
                    href="siswa/import-excel-siswa">Import Excel</a>
                <a class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular"
                    href="siswa/tambah-siswa">Tambah Siswa</a>
            </div>
        </div>

        @if (session('success'))
            <div role="alert" class="alert alert-success mb-8">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex justify-between w-full">
            <form class="flex gap-4"method="GET">
                <input type="text" placeholder="Cari Siswa" name="search"
                    class="border p-3 rounded-full min-w-72 max-w-96 outline-none" />
                <button type="submit" class="btn-outline btn border border-neutral rounded-full w-20">Cari</button>
            </form>
        </div>

        <div class="overflow-x-auto mt-12 rounded-lg border bg-white p-4 text-xs md:text-sm lg:text-base">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">NIS</th>
                        <th class="text-center">Nama Siswa</th>
                        <th class="text-center">Jurusan</th>
                        <th class="text-center">Kontrol</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listSiswa as $index => $item)
                        <tr>
                            <th class="text-center">{{ ++$index }}</th>
                            <td>{{ $item['nis'] }}</td>
                            <td class="whitespace-nowrap">{{ $item['namaSiswa'] }}</td>
                            <td class="whitespace-nowrap">{{ $item['jurusan']['namaJurusan'] }}</td>
                            <td class="flex justify-center">
                                <a href="siswa/detail/{{ $item['idSiswa'] }}" class="btn-detail">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-10 flex justify-center">
            {{ $listSiswa->links() }}
        </div>
    </div>
@endsection
