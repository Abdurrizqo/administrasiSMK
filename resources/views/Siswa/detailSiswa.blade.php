<dialog id="my_modal_3" class="modal">
    <div class="modal-box">
        <form onsubmit="return validationAddFotoSiswa()" method="POST" enctype="multipart/form-data"
            action="/dashboard/siswa/{{ $siswa->idSiswa }}/add-foto"
            class="flex justify-center items-center flex-col gap-6">
            @csrf
            <img id="previewImage" src="#" alt="Preview" style="display: none;" class="w-52 h-52 rounded-full">

            <div>
                <input type="file" accept="image/*" id="fileInput" name="fotoSiswa"
                    class="file-input file-input-bordered w-full" />

                <p id="errorMessage" class="text-xs text-red-400 text-center"></p>
            </div>

            <button class="btn btn-neutral w-40" type="submit">Simpan</button>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<dialog id="modalGantiStatus" class="modal">
    <div class="modal-box">
        <form method="POST" enctype="multipart/form-data" id="formGantiStatus"
            action="/dashboard/siswa/{{ $siswa->idSiswa }}/ganti-status"
            class="flex justify-center items-center flex-col gap-6 w-full">
            @csrf
            <div class="w-full">
                <select required name="status" id="status" class="select select-bordered w-full">
                    <option value="aktif">Aktif</option>
                    <option value="lulus">Lulus</option>
                    <option value="pindah">Pindah</option>
                </select>
                <p id="errorMessageStatus" class="text-xs text-red-400"></p>
            </div>

            <div id="fileInputContainer" style="display: none;" class="w-full">
                <div class="label">
                    <span class="label-text font-semibold">Ijazah</span>
                </div>
                <input type="file" accept=".pdf" id="fileInputIjazah" name="ijazah"
                    class="file-input file-input-bordered w-full" />
                <p id="errorMessageIjazah" class="text-xs text-red-400"></p>
            </div>

            <div class="flex justify-end w-full">
                <button class="btn-click bg-gray-800 text-white px-8 py-2 rounded-lg" type="submit">Simpan</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

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
        @if (session('errorAdd'))
            <div role="alert" class="alert alert-error mb-8 text-white">
                <span>{{ session('errorAdd') }}</span>
            </div>
        @endif

        @if (session('successAdd'))
            <div role="alert" class="alert alert-success mb-8 text-white">
                <span>{{ session('successAdd') }}</span>
            </div>
        @endif

        <div class="w-full rounded-md border shadow p-6 bg-white">
            <div class="flex justify-center flex-col items-center">
                <div class="w-28 h-28 rounded-full bg-gray-300 relative"
                    style="background-image: url('{{ Storage::url($siswa->fotoSiswa) }}'); background-size: cover; background-position: center;">
                    <button class="material-icons absolute bottom-0 right-0" onclick="my_modal_3.showModal()">
                        add_circle
                    </button>
                </div>

                <div class="flex flex-col gap-2 justify-center items-center mt-6">
                    <div class="flex gap-2 justify-start items-center">
                        <h1 class="text-lg font-semibold text-center">{{ $siswa->namaSiswa }}</h1>
                        <a href="{{ $siswa->idSiswa }}/edit" class="material-icons md-18">
                            edit
                        </a>
                    </div>

                    @isset($siswa->ijazahLulus)
                        <a target="_blank" href="/dashboard/siswa/ijazah/download/{{ basename($siswa->ijazahLulus) }}"
                            class="bg-emerald-500 poppins-medium text-white px-6 py-1 rounded-full text-xs">Download Ijazah</a>
                    @endisset
                </div>
            </div>

            <div class="divider"></div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 w-full">
                <div class="flex-1">
                    <h1 class="text-xl font-bold text-center mb-8">Biodata Siswa</h1>

                    <div class="flex w-full flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">NISN</h1>
                        <p class="text-gray-500">{{ $siswa->nisn }}</p>
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">NIS</h1>
                        <p class="text-gray-500">{{ $siswa->nis }}</p>
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">Jurusan</h1>
                        <p class="text-gray-500">{{ $siswa->jurusan->namaJurusan }}</p>
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">Tahun Masuk</h1>
                        <p class="text-gray-500">{{ $siswa->tahunMasuk }}</p>
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">Status</h1>
                        @if ($siswa->status === 'aktif')
                            <div class="flex items-center gap-3">
                                <p class="text-white uppercase badge p-2 badge-success">{{ $siswa->status }}</p>
                                <button class="material-icons md-24 btn-click" onclick="modalGantiStatus.showModal()">
                                    loop
                                </button>
                            </div>
                        @elseif($siswa->status === 'lulus')
                            <div class="flex items-center gap-3">
                                <p class="text-white uppercase badge p-2 badge-info">{{ $siswa->status }}</p>
                                <button class="material-icons md-24 btn-click" onclick="modalGantiStatus.showModal()">
                                    loop
                                </button>
                            </div>
                        @elseif($siswa->status === 'pindah')
                            <div class="flex items-center gap-3">
                                <p class="text-white uppercase badge p-2 badge-warning">{{ $siswa->status }}</p>
                                <button class="material-icons md-24 btn-click" onclick="modalGantiStatus.showModal()">
                                    loop
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">Tahun Lulus</h1>
                        @if ($siswa->tahunLulus)
                            <p class="text-gray-500">{{ $siswa->tahunLulus }}</p>
                        @else
                            <p class="text-gray-500">-</p>
                        @endif
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">Tahun Pindah</h1>
                        @if ($siswa->tahunPindah)
                            <p class="text-gray-500">{{ $siswa->tahunPindah }}</p>
                        @else
                            <p class="text-gray-500">-</p>
                        @endif
                    </div>

                </div>

                <div class="flex-1">
                    <h1 class="text-xl font-bold text-center mb-8">Biodata Wali Siswa</h1>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">Nama Wali</h1>
                        <p class="text-gray-500">{{ $siswa->namaWali }}</p>
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">NIK</h1>
                        <p class="text-gray-500">{{ $siswa->nikWali }}</p>
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">Hubungan Keluarga</h1>
                        <p class="text-gray-500">{{ $siswa->hubunganKeluarga }}</p>
                    </div>

                    <div class="flex flex-wrap justify-between pb-3 border-b px-3 mb-5">
                        <h1 class="font-bold">Alamat</h1>
                        <p class="text-gray-500">{{ $siswa->alamat }}</p>
                    </div>

                </div>
            </div>
        </div>

        <div class="w-full rounded-md border shadow p-6 my-10 bg-white">
            <h1 class="font-bold text-lg">Riwayat Kelas</h1>

            <div class="w-full flex flex-wrap gap-12 mt-5">
                @foreach ($kelas as $item)
                    <a href="{{ $item->idSiswa }}/raport/{{ $item->idKelas }}" class="rounded-lg border bg-white w-80">
                        <div class="w-full rounded-t-lg bg-neutral text-white p-3"></div>
                        <div class="p-3">
                            <h1 class="poppinns-medium text-lg">{{ $item->namaKelas }}</h1>
                            <p class="text-gray-400">{{ $item->tahunAjaran }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="w-full flex gap-10 flex-wrap mb-10">
            <div class="flex-1 rounded-md border shadow p-6 bg-white">
                <h1 class="font-bold text-lg mb-6">Catatan Siswa</h1>

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

                            <button onclick="modalDeleteCatatan.showModal(); deleteCatatan('{{ $item->idCatatanSiswa }}')"
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
                <h1 class="font-bold text-lg mb-6">Sertifikat siswa</h1>

                <form method="POST" action="/dashboard/siswa/detail/{{ $siswa->idSiswa }}/sertifikat"
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
                                onclick="modalDeleteSertifikat.showModal(); deleteSertifikat('{{ $item->idSertifikatSiswa }}')"
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
        const fileInput = document.getElementById('fileInput');
        const previewImage = document.getElementById('previewImage');
        const errorMessage = document.getElementById('errorMessage');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        function validationAddFotoSiswa() {
            if (!fileInput.files || !fileInput.files[0]) {
                errorMessage.textContent = 'Pilih sebuah file gambar';
                return false;
            }

            const file = fileInput.files[0];
            const maxSize = 4 * 1024 * 1024;
            if (file.size > maxSize) {
                errorMessage.textContent = 'File terlalu besar (maksimum 4 MB)';
                errorMessage.style.display = 'block';
                return false;
            }

            errorMessage.textContent = "";
            return true;
        }

        document.getElementById('status').addEventListener('change', function() {
            var status = this.value;
            var fileInputContainer = document.getElementById('fileInputContainer');

            if (status === 'lulus') {
                fileInputContainer.style.display = 'block';
            } else {
                fileInputContainer.style.display = 'none';
            }
        });

        var formGantiStatus = document.getElementById('formGantiStatus');
        formGantiStatus.addEventListener('submit', function(event) {
            var status = document.getElementById('status').value;
            var fileInput = document.getElementById('fileInputIjazah');
            var errorMessageIjazah = document.getElementById('errorMessageIjazah');
            var errorMessageStatus = document.getElementById('errorMessageStatus');

            if (status === '') {
                event.preventDefault();
                errorMessageStatus.textContent = 'Pilih status antara pindah dan lulus';
                return;
            }

            if (status === 'lulus' && fileInput.files.length === 0) {
                event.preventDefault();
                errorMessageIjazah.textContent = 'Pilih file Ijazah.';
                return;
            }

            if (status === 'lulus') {
                var file = fileInput.files[0];
                var maxSize = 3 * 1024 * 1024;
                if (file.size > maxSize) {
                    event.preventDefault();
                    errorMessageIjazah.textContent = 'Ukuran file terlalu besar (maksimal 3MB).';
                    return;
                }
                if (!file.type.match('application/pdf')) {
                    event.preventDefault();
                    errorMessageIjazah.textContent = 'File harus berupa PDF.';
                    return;
                }
            }
        });

        function deleteCatatan(dataIdCatatan) {
            const linkDelete = document.getElementById("linkDeleteCatatan");
            linkDelete.setAttribute("href", `/dashboard/siswa/${dataIdCatatan}/delete/catatan`);
        }

        function deleteSertifikat(dataIdSertifikat) {
            const linkDelete = document.getElementById("linkDeleteSertifikat");
            linkDelete.setAttribute("href", `/dashboard/siswa/${dataIdSertifikat}/delete/sertifikat`);
        }
    </script>
@endsection
