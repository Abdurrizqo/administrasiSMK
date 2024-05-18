<dialog id="modalDeleteSertifikat" class="modal">
    <div class="modal-box">
        <h1 class="text-center text-lg font-medium mb-2">Hapus Sertifikat ?</h1>
        <div class="modal-action flex justify-center">
            <form method="dialog" class="flex justify-center gap-8">
                <button class="btn btn-outline w-40">Close</button>
                <a id="linkDeleteSertifikat" class="btn btn-error w-40 text-white">Hapus</a>
            </form>
        </div>
    </div>
</dialog>

<dialog id="modalDeleteCatatan" class="modal">
    <div class="modal-box">
        <h1 class="text-center text-lg font-medium mb-2">Hapus Catatan ?</h1>
        <div class="modal-action flex justify-center">
            <form method="dialog" class="flex justify-center gap-8">
                <button class="btn btn-outline w-40">Close</button>
                <a id="linkDeleteCatatan" class="btn btn-error w-40 text-white">Hapus</a>
            </form>
        </div>
    </div>
</dialog>

@extends('layouts.layout')
@section('content')
    <div class="w-full">

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-8 text-white font-medium">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if (session('success'))
            <div role="alert" class="alert alert-success mb-8 text-white font-medium">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <span
            class="text-sm border border-gray-300 inline-block breadcrumbs bg-white px-8 py-3 poppins-medium rounded-full">
            <ul>
                <li><a href="/dashboard/pegawai">Data Pegawai</a></li>
                <li><a href="#">Detail Pegawai</li></a>
            </ul>
        </span>

        <div class="w-full flex gap-8 flex-wrap mb-10 mt-8">
            <div class="flex-1 rounded-md border shadow p-6 bg-white">
                <h1 class="font-bold text-lg mb-6">Catatan Pegawai</h1>

                <form method="POST" class="flex gap-3 flex-col">
                    @csrf
                    <div class="w-full">
                        <textarea name="keterangan" class="border w-full p-3 rounded-lg outline-none h-20" placeholder="Keterangan"></textarea>
                        @error('keterangan')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-10 items-center">
                        <label class="form-control min-w-48 max-w-52">
                            <select required name="kategori" class="select select-bordered flex-1">
                                <option>Kategori</option>
                                <option value="CAPAIAN">Capaian</option>
                                <option value="PELANGGARAN">Pelanggaran</option>
                            </select>
                            @error('kategori')
                                <p class="text-xs text-red-400">*{{ $message }}</p>
                            @enderror
                        </label>

                        <button type="submit" class="btn-detail btn-click">Simpan</button>
                    </div>
                </form>

                <div class="divider"></div>

                <div class="flex flex-col gap-3">
                    @foreach ($catatan as $item)
                        <div class="border-b border-gray-400 pb-2 px-2 mb-2 flex items-center">
                            <div class="flex-1">
                                <p class="text-sm text-gray-400">{{ $item->created_at }}</p>

                                <p class="mb-3">{{ $item->keterangan }}</p>
                                <p
                                    class="text-sm
                    @if ($item->kategori === 'CAPAIAN') text-green-500
                    @else
                    text-red-500 @endif">
                                    {{ $item->kategori }}
                                </p>
                            </div>

                            <button onclick="modalDeleteCatatan.showModal(); deleteCatatan('{{ $item->idCatatanPegawai }}')"
                                class="btn-click">
                                <span class="material-icons text-red-500 md-24">
                                    delete
                                </span>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex-1 rounded-md border shadow p-6 bg-white">
                <h1 class="font-bold text-lg mb-6">Sertifikat Pegawai</h1>

                <form method="POST" action="/dashboard/pegawai/{{ $idPegawai }}/sertifikat"
                    enctype="multipart/form-data" class="flex gap-3 flex-col">
                    @csrf
                    <label class="form-control w-full">
                        <input required name="judul" type="text" placeholder="Judul Prestasi"
                            class="input input-bordered w-full" />
                        @error('judul')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <div class="flex gap-8">
                        <label class="form-control flex-1">
                            <input name="sertifikat" type="file" class="file-input file-input-bordered w-full" />
                            @error('sertifikat')
                                <p class="text-xs text-red-400">*{{ $message }}</p>
                            @enderror
                        </label>

                        <button type="submit" class="btn-detail btn-click">Simpan</button>
                    </div>
                </form>

                <div class="divider"></div>

                <div class="flex flex-col gap-3">
                    @foreach ($sertifikat as $item)
                        <div class="border-b border-gray-400 pb-2 px-2 mb-2 flex gap-3 items-center">
                            <div class="flex-1">
                                <p class="text-sm text-gray-400">{{ $item->created_at }}</p>
                                <p class="mb-2">{{ $item->judul }}</p>
                                <a target="_blank" href="/storage/{{ $item->sertifikat }}"
                                    class="text-green-500 py-[2px] text-sm btn-click">
                                    Download
                                </a>
                            </div>

                            <button
                                onclick="modalDeleteSertifikat.showModal(); deleteSertifikat('{{ $item->idSertifikatGuru }}')"
                                class="btn-click">
                                <span class="material-icons text-red-500 md-24">
                                    delete
                                </span>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteCatatan(dataIdCatatan) {
            const linkDelete = document.getElementById("linkDeleteCatatan");
            linkDelete.setAttribute("href", `/dashboard/pegawai/${dataIdCatatan}/delete/catatan`);
        }

        function deleteSertifikat(dataIdSertifikat) {
            const linkDelete = document.getElementById("linkDeleteSertifikat");
            linkDelete.setAttribute("href", `/dashboard/pegawai/${dataIdSertifikat}/delete/sertifikat`);
        }
    </script>
@endsection
