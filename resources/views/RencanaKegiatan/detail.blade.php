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

    <div class="navbar h-20 border-b bg-white text-neutral flex justify-between fixed top-0 z-20">
        <a href="{{$backNavigate}}"
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
                <button class="btn-click border text-neutral rounded-md px-4 py-2 hover:bg-neutral hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="w-5 h-5 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                        </path>
                    </svg>
                </button>
                <div tabindex="0"
                    class="dropdown-content mt-3 z-[1] p-4 shadow border bg-base-100 rounded-box w-52 flex flex-col">
                    <a class="poppins-medium btn-click text-neutral hover:text-white hover:bg-gray-700 p-3 rounded-md"
                        href="/{{$backNavigate}}/ganti-password">Ganti Password</a>
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
                <li><a href="#">Detail Kegiatan</li></a>
            </ul>
        </span>

        <div class="grid grid-cols-2 gap-3 mb-12">
            <div>
                <div class="bg-white p-3 rounded-md border shadow-sm">
                    <p class="text-gray-400 poppins-light text-sm mb-2 text-end">{{ $rencanaKegiatan->created_at }}</p>

                    <h1 class="poppins-semibold text-xl">{{ $rencanaKegiatan->namaKegiatan }}
                    </h1>

                    <div class="mt-3 text-sm">
                        <p class="poppins-medium">Rencana Tanggal Pelaksanaan</p>
                        <p class="text-gray-400 poppins-light">{{ $rencanaKegiatan->tanggalMulaiKegiatan }}</p>
                    </div>

                    <div class="mt-3 text-sm">
                        <p class="poppins-medium">Tanggal Selesai Kegiatan</p>
                        <p class="text-gray-400 poppins-light">
                            {{ $rencanaKegiatan->tanggalSelesaiKegiatan ? $rencanaKegiatan->tanggalSelesaiKegiatan : '-' }}
                        </p>
                    </div>

                    <div class="mt-3 text-sm">
                        <p class="poppins-medium">Ketua Pelaksana</p>
                        <p class="text-gray-400 poppins-light">{{ $rencanaKegiatan->namaPegawai }}</p>
                    </div>

                    <div class="mt-3 text-sm">
                        <p class="poppins-medium">Wakil Ketua Pelaksana</p>
                        <p class="text-gray-400 poppins-light">{{ $rencanaKegiatan->wakilKetua }}</p>
                    </div>

                    <div class="mt-3 text-sm">
                        <p class="poppins-medium">Sekretaris</p>
                        <p class="text-gray-400 poppins-light">{{ $rencanaKegiatan->sekretaris }}</p>
                    </div>

                    <div class="mt-3 text-sm">
                        <p class="poppins-medium">Bendahara</p>
                        <p class="text-gray-400 poppins-light">{{ $rencanaKegiatan->bendahara }}</p>
                    </div>

                    <div class="mt-3 text-sm">
                        <p class="poppins-medium">Proposal Kegiatan</p>
                        <a target="_blank" href="/storage/{{ $rencanaKegiatan->dokumenProposal }}"
                            class="text-gray-400 poppins-light poppins-semibold hover:underline hover:underline-offset-2">Download</a>
                    </div>

                    <div class="mt-3 text-sm">
                        <p class="poppins-medium">Laporan Hasil Kegiatan</p>
                        @if ($rencanaKegiatan->dokumenLaporanHasil)
                            <a target="_blank" href="/storage/{{ $rencanaKegiatan->dokumenLaporanHasil }}"
                                class="text-gray-400 poppins-light poppins-semibold hover:underline hover:underline-offset-2">Download</a>
                        @else
                            <p class="text-gray-400 poppins-light poppins-semibold">-</p>
                        @endif
                    </div>

                    <div class="mt-3 text-sm">
                        <p class="poppins-medium">Status</p>
                        @if ($rencanaKegiatan->isFinish)
                            <p class="text-green-400 poppins-light">Selesai</p>
                        @else
                            <p class="text-red-400 poppins-light">Belum Selesai</p>
                        @endif
                    </div>
                </div>
            </div>

            <div>

                @if (!$rencanaKegiatan->isFinish)
                    <form method="POST" class="bg-white p-3 rounded-md border shadow-sm" id="finishRencanaForm"
                        enctype="multipart/form-data">
                        @csrf

                        <label class="form-control w-full mb-4">
                            <div class="label">
                                <span class="label-text">Tanggal Selesai Kegiatan</span>
                            </div>
                            <input name="tanggalSelesaiKegiatan" type="date"
                                class="input poppins-regular input-bordered w-full" />
                            @error('tanggalSelesaiKegiatan')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full mb-4">
                            <div class="label">
                                <span class="label-text">Laporan Hasil</span>
                            </div>
                            <input type="file" class="file-input file-input-bordered w-full"
                                name="dokumenLaporanHasil" />
                            @error('dokumenLaporanHasil')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="label cursor-pointer flex gap-3 justify-start items-center btn-click">
                            <input id="checkboxConfirm" type="checkbox" class="checkbox" id="checkboxConfirm" />
                            <span class="label-text text-red-500">Pastikan dokumen telah terisi dengan baik, setelah
                                melakukan submit maka kegiatan dinyatakan selesai dan tidak dapat diubah maupun
                                dihapus</span>
                        </label>

                        <div class="mt-10 w-full flex justify-end col-span-2">
                            <button id="submitButton" disabled class="btn w-40 poppins-medium">Simpan</button>
                        </div>

                    </form>
                @else
                    <div class="bg-white p-3 rounded-md border shadow-sm h-40 flex items-center justify-center">
                        <h1 class="text-gray-500 poppins-semibold text-xl">Kegiatan Telah Diselesaikan</h1>
                    </div>
                @endif

            </div>
        </div>

    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
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

        $('#finishRencanaForm').on('submit', function(e) {
            if ($('#myCheckbox').is(':checked')) {
                e.preventDefault();
            }
        });
    </script>
</body>

</html>
