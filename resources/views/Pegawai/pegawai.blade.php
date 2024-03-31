<dialog id="my_modal_2" class="modal">
    <div class="modal-box">
        <h1 class="text-center text-lg font-medium mb-8" id="titleModal"></h1>
        <form id="addUserForm" onsubmit="return validationAddUser()" method="POST" action="pegawai/tambah-user"
            class="w-full flex flex-col gap-3">
            @csrf
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">NIPY</span>
                </div>
                <input required id="hideIdPegawai" name="idPegawai" type="hidden" />
                <input required id="nipy" type="text" disabled class="input input-bordered w-full" />
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Status</span>
                </div>
                <input required id="hideStatus" name="status" type="hidden" />
                <input required id="status" type="text" disabled class="input input-bordered w-full" />
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Username</span>
                </div>
                <input required name="username" id="username" type="text" placeholder="username"
                    class="input input-bordered w-full" />
                <p id="errorUsername" class="text-xs text-red-400"></p>

            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Password</span>
                </div>
                <input required name="password" id="password" type="password" placeholder="password"
                    class="input input-bordered w-full" />
                <p id="errorPassword" class="text-xs text-red-400"></p>
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

<dialog id="my_modal_3" class="modal">
    <div class="modal-box">
        <h1 class="text-center text-lg font-medium mb-2" id="titleModalDelete"></h1>
        <p class="text-red-400 font-light text-center mb-8">semua data terkait dengan pegawai tersebut akan dihapus</p>
        <div class="modal-action flex justify-center">
            <form method="dialog" class="flex justify-center gap-8">
                <button class="btn btn-outline w-40">Close</button>
                <a id="linkDeletePegawai" class="btn btn-error w-40 text-white">Hapus</a>
            </form>
        </div>
    </div>
</dialog>

@extends('layouts.layout')
@section('content')
    <div class=" bg-white p-10">
        <div class="flex w-full mb-10 justify-between gap-y-4 items-center flex-wrap">
            <h1 class="text-2xl font-bold w-[26rem]">Data Pegawai Sekolah</h1>
            <a class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular"
                href="pegawai/tambah-pegawai">Tambah Pegawai</a>
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

        <div class="flex justify-between w-full">
            <form class="flex gap-4"method="GET">
                <input type="text" placeholder="Cari Pegawai" name="search"
                    class="border px-3 rounded-full min-w-96 outline-none" />
                <button type="submit" class="btn-outline btn border border-neutral rounded-full w-28">Cari</button>
            </form>

        </div>

        <div class="overflow-x-auto mt-12 rounded-lg border">
            <table class="table table-zebra table-auto">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">NIPY</th>
                        <th class="text-center">Nama Pegawai</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Kontrol</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pegawai as $index => $item)
                        <tr>
                            <th class="text-center">{{ ++$index }}</th>
                            <td class="text-center">{{ $item['nipy'] }}</td>
                            <td class="whitespace-nowrap">{{ $item['namaPegawai'] }}</td>
                            <td class="text-center">{{ $item['status'] }}</td>
                            <td class="text-center">
                                @if ($item['user'])
                                    {{ $item['user']['username'] }}
                                @endif
                            </td>
                            <td class="flex flex-wrap gap-x-8 gap-y-3 justify-center">
                                <a href="pegawai/edit/{{ $item['idPegawai'] }}" class="btn-edit">Edit</a>
                                <button class="btn-detail"
                                    onclick="my_modal_2.showModal(); modalAddUser('{{ $item['namaPegawai'] }}','{{ $item['nipy'] }}','{{ $item['status'] }}','{{ $item['idPegawai'] }}')">
                                    @if ($item['user'])
                                        Edit Akun
                                    @else
                                        Tambah Akun
                                    @endif
                                </button>
                                <button class="btn-delete"
                                    onclick="my_modal_3.showModal(); modalDeletePegawai('{{ $item['namaPegawai'] }}','{{ $item['nipy'] }}')">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-10 flex justify-center">
            {{ $pegawai->links() }}
        </div>
    </div>

    <script src="{{ asset('js/index.js') }}"></script>
@endsection
