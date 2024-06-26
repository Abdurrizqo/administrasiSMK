@extends('layouts.layout')
@section('content')
    <dialog id="exportModal" class="modal">
        <div class="modal-box">
            <h1 class="text-center text-lg poppins-medium">EXPORT REKAP SURAT MASUK</h1>

            <div class="flex gap-4 items-center mt-10 mb-12">
                <input required type="date" id="tanggalAwal" class="input input-bordered w-52" />
                <p class="text-lg poppins-medium">-</p>
                <input required type="date" id="tanggalAkhir" class="input input-bordered w-52" />
            </div>

            <form method="dialog" class="flex justify-end gap-4">
                <button
                    class="btn-click text-center w-24 px-3 py-2 border rounded-lg border-gray-800 text-gray-800 bg-white">Close</button>
                <a target="_blank"
                    class="btn-click text-center w-24 px-3 py-2 border rounded-lg border-gray-800 text-white bg-gray-800">Export</a>
            </form>
        </div>
    </dialog>

    <div class="w-full">
        <div class="flex w-full mb-10 justify-between gap-y-4 items-center flex-wrap">
            <h1 class="text-2xl font-bold min-w-[32rem]">Agenda Surat Masuk</h1>

            <div class="flex items-center gap-4">
                <button onclick="exportModal.showModal();"
                    class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular">
                    Excel Rekap Surat
                </button>
                <livewire:form-agenda-surat-masuk />
            </div>
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
            <table class="table table-zebra table-auto">
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
                            <td><a target="_blank"
                                    href="{{ route('dokumenFile.download', ['filename' => basename($item->dokumenSurat)]) }}"
                                    class="material-icons text-gray-800 btn-click md-36">
                                    description
                                </a></td>
                            <td>
                                @if ($item->hasDisposisi)
                                    <p class="text-center poppins-medium text-gray-500">Telah Di Disposisikan</p>
                                @else
                                    <livewire:form-disposisi-surat :idAgendaSurat="$item->idAgendaSurat" />
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-10 flex justify-center">
            {{ $listAgenda->links() }}
        </div>
    </div>

    <script>
        const tanggalAwalInput = document.getElementById("tanggalAwal");
        const tanggalAkhirInput = document.getElementById("tanggalAkhir");

        const exportLink = document.querySelector(".modal-box a");

        tanggalAwalInput.addEventListener("change", updateExportLink);
        tanggalAkhirInput.addEventListener("change", updateExportLink);

        function updateExportLink() {
            const tanggalAwal = tanggalAwalInput.value;
            const tanggalAkhir = tanggalAkhirInput.value;

            if (tanggalAwal && tanggalAkhir) {
                exportLink.classList.remove("disabled");
                exportLink.href = `agenda-surat-masuk/export?tanggalAwal=${tanggalAwal}&tanggalAkhir=${tanggalAkhir}`;
            } else {
                exportLink.classList.add("disabled");
                exportLink.removeAttribute("href");
            }
        }
    </script>
@endsection
