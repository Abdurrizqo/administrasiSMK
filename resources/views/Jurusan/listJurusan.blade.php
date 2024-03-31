<dialog id="my_modal_3" class="modal">
    <div class="modal-box">
        <h1 class="text-center text-lg font-medium mb-2" id="titleModalGantiStatus"></h1>
        <div class="modal-action flex justify-center">
            <form method="dialog" class="flex justify-center gap-8">
                <button class="btn-active btn-detail">Batal</button>
                <a id="linkGantiStatus"
                    class="btn-active"></a>
            </form>
        </div>
    </div>
</dialog>

<dialog id="my_modal_2" class="modal">
    <div class="modal-box">
        <h1 class="text-center text-lg font-medium mb-8" id="titleModal"></h1>
        <form method="POST" action="jurusan/edit"
            class="w-full flex flex-col gap-3">
            @csrf
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Nama Jurusan<span class="text-red-400">*</span></span>
                </div>
                <input name="idJurusan" id="idJurusan" type="hidden" class="input input-bordered w-full" />
                <input name="namaJurusan" id="namaJurusan" type="text" class="input input-bordered w-full" />
                <p id="errorNamaJurusan" class="text-xs text-red-400"></p>
            </label>
            <div class="mt-10 w-full flex justify-end">
                <button class="btn btn-neutral w-40" type="submit">Simpan</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

@extends('layouts.layout')
@section('content')
    <div class="w-full bg-white p-10">
        <div class="mb-10">
            <h1 class="text-2xl font-bold">Data Program Keahlian</h1>
        </div>

        @if (session('success'))
            <div role="alert" class="alert alert-success mb-8 text-white font-medium">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-8 text-white font-medium">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="w-full">
            <form class="flex gap-4" method="POST">
                @csrf
                <input type="text" placeholder="Tambah Nama Jurusan" name="namaJurusan"
                    class="border px-3 rounded-full min-w-96 outline-none" />
                <button type="submit" class="btn-outline btn border border-neutral rounded-full w-28">Simpan</button>
            </form>
            @error('namaJurusan')
                <p class="text-xs text-red-400">*{{ $message }}</p>
            @enderror
        </div>

        <div class="overflow-x-auto mt-12 rounded-lg border">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Jurusan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Kontrol</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jurusan as $index => $item)
                        <tr>
                            <th>{{ ++$index }}</th>
                            <td>{{ $item['namaJurusan'] }}</td>
                            <td class="text-center">
                                @if ($item['isActive'])
                                    <p class="text-green-400 poppins-medium">Aktif</p>
                                @else
                                    <p class="text-red-400 poppins-medium">Non Aktif</p>
                                @endif
                            </td>
                            <td class="flex gap-16 justify-center">
                                <button
                                    onclick="my_modal_2.showModal(); 
                                    modalEditJurusan('{{ $item['namaJurusan'] }}', '{{ $item['idJurusan'] }}')"
                                    class="btn-edit btn-click">
                                    Edit
                                </button>

                                <button
                                    @if ($item['isActive']) class="btn-delete btn-click" @else class="btn-detail btn-click" @endif
                                    onclick="my_modal_3.showModal(); 
                                modalGantiStatus(
                                'Apakah Anda Yakin Menonaktifkan Jurusan {{ $item['namaJurusan'] }}', 
                                '{{ $item['isActive'] }}',
                                'jurusan/non-aktif/{{ $item['idJurusan'] }}'
                                )">
                                    @if ($item['isActive'])
                                        <p>Non Aktifkan</p>
                                    @else
                                        <p>Aktifkan</p>
                                    @endif
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <script src="{{ asset('js/index.js') }}"></script>
    </div>
@endsection
