<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @vite('resources/css/app.css')
    <title>SIAS</title>
</head>

<body class="relative bg-gray-100">

    <div id="pegawaiModal" class="modal hidden fixed z-30 inset-0 overflow-y-auto top-10">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <div class="bg-white px-4 pb-4 h-96 overflow-auto relative">

                    <form id="searchPegawai" class="sticky top-0 bg-white p-2">
                        <input type="text" autofocus
                            class="w-full rounded-full border border-gray-300 px-3 py-2 outline-none focus:border-gray-500">
                    </form>

                    <div id="modal-content-pegawai">
                        <div id="spinner-pegawai" class="hidden spinner"></div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm"
                        id="closeModal-pegawai">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="navbar h-20 border-b bg-white text-neutral flex justify-between fixed top-0 z-20">
        <a href="/{{ $backNavigate }}"
            class="flex justify-center items-center gap-2 rounded-full bg-white border shadow-md py-[6px] px-5 btn-click">
            <span class="material-icons md-24">
                home
            </span>
            <p class="text-sm poppins-medium">Home</p>
        </a>
        <div class=" flex gap-6 justify-between items-center">
            <div class="dropdown dropdown-end">
                @auth
                    <p class="text-lg poppins-semibold">
                        <span class="text-gray-400">Halo,</span>
                        @if (session('namaProfile'))
                            {{ session('namaProfile') }}
                        @endif
                    </p>
                @endauth
            </div>

            <div class="dropdown dropdown-end">
                <button class="btn-click text-neutral rounded-md px-4 py-2">
                    @auth
                        <div style="background-image: url('{{ Storage::url(Auth::user()->photoProfile) }}');"
                            class="w-[3.2rem] h-[3.2rem] rounded-full bg-gray-200 bg-center bg-cover"></div>
                    @endauth
                </button>
                <div tabindex="0"
                    class="dropdown-content z-[1] p-4 shadow border bg-base-100 rounded-box w-52 flex flex-col">
                    <a class="poppins-medium btn-click text-neutral hover:text-white hover:bg-gray-700 p-3 rounded-md"
                        href="/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="min-h-[100vh] pt-24 px-8 pb-10">

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-8 text-white">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if (session('success'))
            <div role="alert" class="alert alert-success mb-8 text-white">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <span
            class="text-sm border border-gray-300 inline-block breadcrumbs bg-white px-8 py-3 poppins-medium rounded-full mb-12">
            <ul>
                <li><a href="/rencana-kegiatan">Daftar Rencana Kegiatan</a></li>
                <li><a href="#">Tambah Rencana Kegiatan</li></a>
            </ul>
        </span>

        <div class="flex justify-center items-center">
            <div class="bg-white p-3 rounded-md border shadow w-[34rem]">
                <h1 class="text-center font-medium text-lg">RANCANGAN KEGIATAN SEKOLAH</h1>

                <form enctype="multipart/form-data" method="POST" class="mt-4" id="createRencanaForm">
                    @csrf
                    <label class="form-control w-full mb-4">
                        <div class="label">
                            <span class="label-text">Nama Kegiatan</span>
                        </div>
                        <input name="namaKegiatan" type="text" placeholder="nama kegiatan"
                            class="input poppins-regular input-bordered w-full" />
                        @error('namaKegiatan')
                            <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full mb-4">
                        <div class="label">
                            <span class="label-text">Tanggal Mulai Kegiatan</span>
                        </div>
                        <input name="tanggalMulaiKegiatan" type="date"
                            class="input poppins-regular input-bordered w-full" />
                        @error('tanggalMulaiKegiatan')
                            <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full mb-4">
                        <div class="label">
                            <span class="label-text">Ketua Pelaksana</span>
                        </div>
                        <input type="hidden" readonly value="{{ $dataKetua->idPegawai }}" name="ketuaPelaksana">
                        <input readonly value="{{ $dataKetua->namaPegawai }}" type="text"
                            class="input poppins-regular input-bordered w-full" />
                        @error('ketuaPelaksana')
                            <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full mb-4">
                        <div class="label">
                            <span class="label-text">Wakil Ketua Pelaksana</span>
                        </div>
                        <input id="wakilKetuaForm" readonly name="wakilKetuaPelaksana" type="text"
                            class="input poppins-regular input-bordered w-full" />
                        @error('wakilKetuaPelaksana')
                            <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full mb-4">
                        <div class="label">
                            <span class="label-text">Sekretaris</span>
                        </div>
                        <input id="sekretarisForm" readonly name="sekretaris" type="text"
                            class="input poppins-regular input-bordered w-full" />
                        @error('sekretaris')
                            <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full mb-4">
                        <div class="label">
                            <span class="label-text">Bendahara</span>
                        </div>
                        <input id="bendaharaForm" readonly name="bendahara" type="text"
                            class="input poppins-regular input-bordered w-full" />
                        @error('bendahara')
                            <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full mb-4">
                        <div class="label">
                            <span class="label-text">Proposal</span>
                        </div>
                        <input type="file" class="file-input file-input-bordered w-full" name="dokumenProposal" />
                        @error('dokumenProposal')
                            <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="label cursor-pointer flex gap-3 justify-start items-center btn-click">
                        <input type="checkbox" class="checkbox" id="checkboxConfirm" />
                        <span class="label-text text-red-500">Pastikan seluruh data telah terisi dengan benar, data
                            yang telah disimpan tidak dapat diubah atau dihapus</span>
                    </label>

                    <div class="mt-10 w-full flex justify-end col-span-2">
                        <button id="submitButton" disabled class="btn w-40 poppins-medium">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    @vite('resources/js/pegawaiModal.js')
    <script>
        $('#checkboxConfirm').on('change', function() {
            if ($(this).is(':checked')) {
                $('#submitButton')
                    .prop('disabled', false)
                    .removeClass('bg-gray-500')
                    .addClass('btn-neutral');
            } else {
                $('#submitButton')
                    .prop('disabled', true)
                    .removeClass('btn-neutral')
                    .addClass('bg-gray-500');
            }
        });

        $('#createRencanaForm').on('submit', function(e) {
            if ($('#myCheckbox').is(':checked')) {
                e.preventDefault();
            }
        });
    </script>
</body>

</html>
