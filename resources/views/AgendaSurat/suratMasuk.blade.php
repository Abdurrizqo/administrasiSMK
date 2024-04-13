@extends('layouts.layout')
@section('content')
    <div class="w-full p-10 flex-1 bg-white">
        <div class="flex w-full mb-10 justify-between gap-y-4 items-center flex-wrap">
            <h1 class="text-2xl font-bold">Agenda Surat Masuk</h1>
            <livewire:form-agenda-surat-masuk />

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

        <div class="flex justify-between w-full">
            <form class="flex gap-4" method="GET">
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

        <div class="overflow-x-auto mt-12 rounded-lg border">
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
                        <th class="text-center">Disposisi</th>
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
                            <td><a href="#" class="material-icons text-gray-800 btn-click md-36">
                                    description
                                </a></td>
                            <td><livewire:form-disposisi-surat :idAgendaSurat="$item->idAgendaSurat" /></td>
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
