<dialog id="my_modal_3" class="modal">
    <div class="modal-box">
        <form onsubmit="return validationAddLogo()" method="POST" enctype="multipart/form-data"
            action="dashboard/tambah-logo" class="flex justify-center items-center flex-col gap-6">
            @csrf
            <img id="previewImage" src="#" alt="Preview" style="display: none;" class="w-52 h-52">

            <div>
                <input type="file" accept="image/*" id="fileInput" name="logo"
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

@extends('layouts.layout')
@section('content')
    <div class="w-full bg-gray-100">
        @if (session('success'))
            <div role="alert" class="alert alert-success mb-8 text-white font-medium">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex w-full mb-10 justify-between gap-y-4 items-center flex-wrap">
            <h1 class="text-xl lg:text-2xl poppins-bold w-[28rem]">PROFIL SEKOLAH</h1>

            <div class="flex items-center justify-between w-[24rem]">
                <a class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular"
                    href="dashboard/edit-profile-sekolah">Edit Profile Sekolah</a>
                @isset($profile)
                    <a class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular"
                        href="dashboard/atur-akreditas-sekolah">Atur Data Akreditas</a>
                @endempty
            </div>
        </div>

        <div class="flex rounded-lg border bg-white p-5 gap-10">
            @empty($profile)
                <div class="flex-1 text-center lg:text-xl font-semibold text-neutral uppercase">
                    <h1>Profile Sekolah Belum Dilengkapi</h1>
                </div>
            @endempty

            @isset($profile)
                <div class="w-40 lg:w-52 bg-white">
                    @isset($profile['logo'])
                        <div class="w-full h-40 lg:h-52 rounded">
                            <img src="{{ Storage::url($profile['logo']) }}" alt="logo" class="w-full h-full">
                        </div>

                        <div class="flex justify-center mt-8">
                            <button class="rounded-full text-white py-2 px-8 bg-neutral btn-click text-sm"
                                onclick="my_modal_3.showModal()">Ganti Logo</button>
                        </div>
                    @else
                        <div class="w-full bg-gray-300 h-40 lg:h-52 rounded">
                        </div>

                        <div class="flex justify-center mt-8">
                            <button class="rounded-full text-white py-2 px-8 bg-neutral text-sm"
                                onclick="my_modal_3.showModal()">Tambah
                                Logo</button>
                        </div>
                    @endisset
                </div>

                <div class="flex-1">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="w-[16rem]">
                                    <p class="poppins-medium whitespace-nowrap">Nama Sekolah</p>
                                </td>
                                <td>
                                    <p class="text-left">{{ $profile['namaSekolah'] }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[16rem]">
                                    <p class="poppins-medium whitespace-nowrap">NPSN</p>
                                </td>
                                <td>
                                    <p class="text-left">{{ $profile['npsn'] }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[16rem]">
                                    <p class="poppins-medium whitespace-nowrap">NSS</p>
                                </td>
                                <td>
                                    <p class="text-left">{{ $profile['nss'] }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[16rem]">
                                    <p class="poppins-medium whitespace-nowrap">Tahun Berdiri</p>
                                </td>
                                <td>
                                    <p class="text-left">{{ $profile['tahunBerdiri'] }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[16rem]">
                                    <p class="poppins-medium whitespace-nowrap">Kepala Sekolah</p>
                                </td>
                                <td>
                                    <p class="text-left">{{ $profile['namaKepalaSekolah'] }} -
                                        {{ $profile['nipKepalaSekolah'] }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[16rem]">
                                    <p class="poppins-medium whitespace-nowrap">Alamat</p>
                                </td>
                                <td>
                                    <p class="text-left">{{ $profile['alamat'] }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="divider"></div>

                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="w-[16rem]">
                                    <p class="poppins-medium whitespace-nowrap">Tahun Akreditas</p>
                                </td>
                                <td>
                                    <p class="text-left">
                                        @if ($akreditasi)
                                            {{ $akreditasi['tahunAkreditasi'] }}
                                        @else
                                            Belum Diatur
                                        @endif
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[16rem]">
                                    <p class="poppins-medium whitespace-nowrap">Nilai Akreditas</p>
                                </td>
                                <td>
                                    <p class="text-left">
                                        @if ($akreditasi)
                                            {{ $akreditasi['nilaiAkreditasi'] }}
                                        @else
                                            Belum Diatur
                                        @endif
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[16rem]">
                                    <p class="poppins-medium whitespace-nowrap">Akreditas</p>
                                </td>
                                <td>
                                    <p class="text-left">
                                        @if ($akreditasi)
                                            {{ $akreditasi['sebutan'] }}
                                        @else
                                            Belum Diatur
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex-1 my-10">
                        <p class="text-red-400 text-sm">*Secara default sistem menetukan jenis semester berdasarkan bulan.
                            Bulan Januari sampai dengan
                            bulan Juni merupakan semester <span class="font-bold">GENAP</span>, dan bulan Juli sampai dengan
                            Desember merupakan semester
                            <span class="font-bold">GANJIL</span>. Jika terdapat ketidak sesuaian maka dapat dilakukan
                            pengaturan di menu Edit Profile
                            Sekolah
                        </p>
                    </div>
                </div>
            @endisset


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

        function validationAddLogo() {
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
    </script>
@endsection
