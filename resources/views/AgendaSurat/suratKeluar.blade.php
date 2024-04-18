@extends('layouts.layout')
@section('content')
    <div class="w-full">
        <div class="flex w-full mb-10 justify-between gap-y-4 items-center flex-wrap">
            <h1 class="text-2xl font-bold min-w-[32rem]">Agenda Surat Keluar</h1>
            <livewire:form-agenda-surat-keluar />
        </div>

        @if (session('success'))
            <div role="alert" class="alert alert-success mb-8 text-white">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-8 text-white">
                <span>{{ session('success') }}</span>
            </div>
        @endif

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
                        <th class="text-center">Tanggal Masuk</th>
                        <th class="text-center">Tanggal Surat</th>
                        <th class="text-center">Nomer Surat</th>
                        <th class="text-center">Asal Surat</th>
                        <th class="text-center">Perihal</th>
                        <th class="text-center">Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listAgenda as $index => $item)
                        <tr>
                            <th class="text-center">{{ ++$index }}</th>
                            <td>{{ $item->tanggalAgenda }}</td>
                            <td>{{ $item->tanggalSurat }}</td>
                            <td>{{ $item->nomerSurat }}</td>
                            <td>{{ $item->asalTujuanSurat }}</td>
                            <td>{{ $item->perihal }}</td>
                            <td><a target="_blank"
                                    href="{{ route('dokumenFile.download', ['filename' => basename($item->dokumenSurat)]) }}"
                                    class="material-icons text-gray-800 btn-click md-36">
                                    description
                                </a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



        <div class="mt-10 flex justify-center">
            {{ $listAgenda->links() }}
        </div>
    </div>
@endsection
