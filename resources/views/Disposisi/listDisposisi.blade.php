@extends('layouts.layout')
@section('content')
    <div class="w-full">
        <div class="flex w-full mb-10 justify-between gap-y-4 items-center flex-wrap">
            <h1 class="text-2xl font-bold">Disposisi Surat</h1>
        </div>

        <div class="w-full">
            <form class="flex flex-wrap gap-4" method="GET">
                <div class="flex gap-4 items-center">
                    <input required type="date" name="tanggalAwal" class="input input-bordered w-52" />
                    <p class="text-lg poppins-medium">-</p>
                    <input required type="date" name="tanggalAkhir" class="input input-bordered w-52" />
                </div>

                <div class="flex items-center">
                    <button type="submit" class="btn-click bg-gray-800 text-white px-12 py-2 rounded-lg">Filter</button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto mt-12 rounded-lg border w-full bg-white p-4 text-xs md:text-sm lg:text-base">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal Disposisi</th>
                        <th class="text-center">Judul Disposisi</th>
                        <th class="text-center">Tujuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listDisposisi as $index => $item)
                        <tr>
                            <th class="text-center">{{ ++$index }}</th>
                            <td class="text-center">{{ $item->tanggalDisposisi }}</td>
                            <td>{{ $item->judulDisposisi }}</td>
                            <td>{{ $item->namaPegawai }}</td>
                            <td><a href="disposisi-surat/{{ $item->idDisposisi }}">Balasan</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



        <div class="mt-10 flex justify-center">
            {{ $listDisposisi->links() }}
        </div>
    </div>
@endsection
