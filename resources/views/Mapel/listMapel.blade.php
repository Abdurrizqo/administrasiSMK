<dialog id="modal_add_mapel" class="modal">
    <div class="modal-box">
        <h1 class="text-center text-lg font-medium mb-8"> Tambah Mata Pelajaran Baru</h1>
        <form onsubmit="return validationEditAum()" method="POST" class="w-full flex flex-col gap-3">
            @csrf
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Nama Mata Pelajaran<span class="text-red-400">*</span></span>
                </div>
                <input name="namaMataPelajaran" id="namaMataPelajaran" type="text"
                    class="input input-bordered w-full" />
                <p id="errorNamaMataPelajaran" class="text-xs text-red-400"></p>
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

<dialog id="modalEdit" class="modal">
    <div class="modal-box">
        <h1 class="text-center text-lg font-medium mb-8" id="titleModal2"></h1>
        <form onsubmit="return validationEditAum()" method="POST" action="mapel/edit"
            class="w-full flex flex-col gap-3">
            @csrf
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Nama Mata Pelajaran<span class="text-red-400">*</span></span>
                </div>
                <input name="idMataPelajaran" id="idMapel" type="hidden" class="input input-bordered w-full" />
                <input name="namaMataPelajaran" id="namaMapel" type="text" class="input input-bordered w-full" />
                <p id="errornamaMapel" class="text-xs text-red-400"></p>
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
    <div class="w-full">
        <div class="flex w-full mb-10 justify-between gap-y-4 items-center flex-wrap">
            <h1 class="text-xl lg:text-2xl poppins-bold">Data Mata Pelajaran</h1>

            <button onclick="modal_add_mapel.showModal(); 
            modalAddMapel()"
                class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular">Tambah Mata
                Pelajaran</button>
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
            <form class="flex gap-4" method="GET">
                <input type="text" placeholder="Cari Mata Pelajaran" name="search"
                    class="border p-3 rounded-full min-w-72 max-w-96 outline-none" />
                <button type="submit" class="btn-outline btn border border-neutral rounded-full w-20">Cari</button>
            </form>
            @error('search')
                <p class="text-xs text-red-400">*{{ $message }}</p>
            @enderror
        </div>

        <div class="overflow-x-auto mt-12 rounded-lg border bg-white p-4 text-xs md:text-sm lg:text-base">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Mata Pelajaran</th>
                        <th class="text-center">Kontrol</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mapel as $index => $item)
                        <tr>
                            <th class="text-center">{{ ++$index }}</th>
                            <td>{{ $item['namaMataPelajaran'] }}</td>
                            <td class="flex gap-8 justify-center">
                                <button
                                    onclick="modalEdit.showModal(); 
                                modalEditMapel('{{ $item['namaMataPelajaran'] }}','{{ $item['idMataPelajaran'] }}')"
                                    class="btn-edit btn-clcik">
                                    Edit
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
