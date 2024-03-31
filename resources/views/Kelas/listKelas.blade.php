{{-- Modal Delete --}}
<dialog id="my_modal_3" class="modal">
    <div class="modal-box">
        <h1 class="text-center text-lg font-medium mb-2" id="titleModalDelete"></h1>
        <p class="text-red-400 font-light text-center mb-8">semua data terkait dengan Kelas tersebut akan dihapus</p>
        <div class="modal-action flex justify-center">
            <form method="dialog" class="flex justify-center gap-8">
                <button class="btn btn-outline w-40">Close</button>
                <a id="linkDeleteJurnal" class="btn btn-error w-40 text-white">Hapus</a>
            </form>
        </div>
    </div>
</dialog>
{{-- Modal Delete --}}

{{-- Modal Add --}}
<dialog id="addKelasModal" class="modal">
    <div class="modal-box">
        <h1 class="text-center text-lg poppins-bold mb-8">Tambah Kelas Baru</h1>
        <form method="POST" class="mt-6 w-full flex flex-col gap-3">
            @csrf
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Tahun Ajaran</span>
                </div>
                <select name="tahunAjaran" class="select select-bordered flex-1">
                    @foreach ($tahunAjaranAdd as $item)
                        <option @if (old('tahunAjaranAdd') === $item)  @endif value="{{ $item }}">
                            {{ $item }}</option>
                    @endforeach
                </select>
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Nama Kelas</span>
                </div>

                <input name="namaKelas" value="{{ old('namaKelas') }}" type="text" placeholder="kelas"
                    class="input input-bordered w-full" />
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Wali Kelas</span>
                </div>
                <select required name="waliKelas" class="select select-bordered flex-1">
                    @foreach ($guru as $item)
                        <option @if (old('waliKelas') === $item['idPegawai']) selected @endif value="{{ $item['idPegawai'] }}">
                            {{ $item['namaPegawai'] }}</option>
                    @endforeach
                </select>
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
{{-- Modal Add --}}

{{-- Modal Edit --}}
<dialog id="editKelasModal" class="modal">
    <div class="modal-box">
        <h1 class="text-center text-lg font-medium mb-8" id="titleModalEdit"></h1>
        <form method="POST" action="kelas/edit" class="mt-6 w-full flex flex-col gap-3">
            @csrf
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Tahun Ajaran</span>
                </div>
                <select name="tahunAjaran" class="select select-bordered flex-1">
                    @foreach ($tahunAjaranAdd as $item)
                        <option value="{{ $item }}" class="selectTahunAjaran">
                            {{ $item }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Nama Kelas</span>
                </div>

                <input id="formNamaKelas" name="namaKelas" type="text" placeholder="kelas"
                    class="input input-bordered w-full" />
                <input id="formIdKelas" name="idKelas" type="hidden" class="input input-bordered w-full" />
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Wali Kelas</span>
                </div>
                <select required name="waliKelas" class="select select-bordered flex-1">
                    @foreach ($guru as $item)
                        <option value="{{ $item['idPegawai'] }}" class="selectNamaPegawai">
                            {{ $item['namaPegawai'] }}
                        </option>
                    @endforeach
                </select>
            </label>

            <div class="mt-10 w-full flex justify-end">
                <button class="btn btn-neutral w-40" type="submit">Edit</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
{{-- Modal Edit --}}

@extends('layouts.layout')
@section('content')
    <div class="w-full bg-white p-10">
        <div class="flex w-full mb-10 justify-between gap-y-4 items-center flex-wrap">
            <h1 class="text-2xl font-bold">Data Kelas</h1>
            <button onclick="addKelasModal.showModal()"
                class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular">Tambah
                Kelas Baru
            </button>
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

        <div class="flex justify-between w-full">
            <form class="flex gap-4">
                <input type="text" placeholder="Cari Berdasarkan Kelas"
                    class="border px-3 rounded-full min-w-72 outline-none" name="search" />
                <select class="select select-bordered min-w-60" name="tahunAjar">
                    <option value="">Semua</option>
                    @foreach ($tahunAjarSearch as $item)
                        <option value="{{ $item['tahunAjaran'] }}">
                            {{ $item['tahunAjaran'] }}
                        </option>
                    @endforeach
                </select>
                <button class="btn-outline border border-neutral rounded-full w-32">Cari</button>
            </form>
        </div>

        <div class="mt-12 rounded-lg border">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tahun Ajaran</th>
                        <th class="text-center">Wali Kelas</th>
                        <th class="text-center">Nama Kelas</th>
                        <th class="text-center">Sinkron</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelas as $index => $item)
                        <tr oncontextmenu="showContextMenu(event, '{{ $item['tahunAjaran'] }}','{{ $item['namaKelas'] }}','{{ $item['idKelas'] }}','{{ $item['idPegawai'] }}')"
                            class="cursor-pointer hover:bg-gray-200 h-20">
                            <th class="text-center">{{ ++$index }}</th>
                            <td class="text-center">{{ $item['tahunAjaran'] }}</td>
                            <td class="">{{ $item['namaPegawai'] }}</td>
                            <td class="">{{ $item['namaKelas'] }}</td>
                            <td class="text-center">
                                @if ($item['isSync'] === 1)
                                    <p class="text-green-400">Sinkron</p>
                                @else
                                    <p class="text-red-400">Belum Tersinkron</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-10 flex justify-center">
            {{ $kelas->links() }}
        </div>

    </div>

    <div id="contextMenu" class="bg-white hidden p-4 min-w-72 border shadow-md rounded-xl absolute">
        <h1 id="titleContext" class="text-lg poppins-semibold text-center border-b border-neutral mb-4">Menu 'Coba'</h1>
        <div class="flex flex-col gap-1 justify-start">
            <a id="linkTambahSiswa" class="hover:bg-gray-100 p-2 rounded-md">Tambahkan Siswa</a>
            <a id="linkGanjil" class="hover:bg-gray-100 p-2 rounded-md">Semester Ganjil</a>
            <a id="linkGenap" class="hover:bg-gray-100 p-2 rounded-md">Semester Genap</a>
            <button onclick="editKelasModal.showModal()" id="btnEditKelas"
                class="flex justify-start items-center gap-3 hover:bg-gray-100 p-2 rounded-md">
                <span class="material-icons md-18 text-gray-700">
                    edit
                </span>
                Edit
            </button>
            <button onclick="my_modal_3.showModal()" id="btnDeleteKelas"
                class="flex justify-start items-center gap-3 hover:bg-gray-100 p-2 rounded-md">
                <span class="material-icons md-18 text-red-400">
                    delete
                </span>
                Delete
            </button>
        </div>
    </div>

    <script src="{{ asset('js/index.js') }}"></script>
@endsection
