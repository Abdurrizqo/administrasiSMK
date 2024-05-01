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
        </div>

        <div class="flex rounded-lg border bg-white p-5 gap-10">
            @empty($profile)
                <div class="flex-1 text-center lg:text-xl font-semibold text-neutral uppercase">
                    <h1 class="mb-8">Profile Sekolah Belum Dilengkapi</h1>

                    <a class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular text-sm"
                        href="dashboard/edit-profile-sekolah">Edit Profile Sekolah</a>
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

                    <div id="containerProfileSekolah">
                        <div class="flex justify-end mb-6">
                            <a class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular text-sm"
                                href="dashboard/edit-profile-sekolah">Edit Profile Sekolah</a>
                        </div>

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
                                        <p class="poppins-medium whitespace-nowrap">Jenjang Pendidikan</p>
                                    </td>
                                    <td>
                                        <p class="text-left">{{ $profile['jenjangPendidikan'] }}</p>
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
                                        <p class="poppins-medium whitespace-nowrap">Lintang / Bujur</p>
                                    </td>
                                    <td>
                                        <p class="text-left">{{ $profile['lintang'] }} / {{ $profile['bujur'] }}</p>
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
                                <tr>
                                    <td class="w-[16rem]">
                                        <p class="poppins-medium whitespace-nowrap">No Telfon</p>
                                    </td>
                                    <td>
                                        <p class="text-left">{{ $profile['nomerTelfon'] }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-[16rem]">
                                        <p class="poppins-medium whitespace-nowrap">Email</p>
                                    </td>
                                    <td>
                                        <p class="text-left">{{ $profile['email'] }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-[16rem]">
                                        <p class="poppins-medium whitespace-nowrap">Website</p>
                                    </td>
                                    <td>
                                        <p class="text-left">{{ $profile['website'] }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="containerProfileTambahan" class="hidden">
                        <div class="flex justify-end mb-6">
                            <a class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular text-sm"
                                href="dashboard/edit-profile-tambahan">Edit Profile Tambahan</a>
                        </div>

                        @if ($pelengkapSekolah)
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="w-[16rem]">
                                            <p class="poppins-medium whitespace-nowrap">Nomer SK Pendirian</p>
                                        </td>
                                        <td>
                                            <p class="text-left">{{ $pelengkapSekolah['skPendirian'] }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-[16rem]">
                                            <p class="poppins-medium whitespace-nowrap">Tanggal SK Pendirian</p>
                                        </td>
                                        <td>
                                            <p class="text-left">{{ $pelengkapSekolah['tanggalSk'] }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-[16rem]">
                                            <p class="poppins-medium whitespace-nowrap">Nomer SK Izin</p>
                                        </td>
                                        <td>
                                            <p class="text-left">{{ $pelengkapSekolah['skIzin'] }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-[16rem]">
                                            <p class="poppins-medium whitespace-nowrap">Tanggal SK Izin</p>
                                        </td>
                                        <td>
                                            <p class="text-left">{{ $pelengkapSekolah['tanggalSkIzin'] }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-[16rem]">
                                            <p class="poppins-medium whitespace-nowrap">Nomer Rekening</p>
                                        </td>
                                        <td>
                                            <p class="text-left">{{ $pelengkapSekolah['noRekening'] }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-[16rem]">
                                            <p class="poppins-medium whitespace-nowrap">Rekening</p>
                                        </td>
                                        <td>
                                            <p class="text-left">{{ $pelengkapSekolah['rekening'] }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-[16rem]">
                                            <p class="poppins-medium whitespace-nowrap">Atas Nama Rekening</p>
                                        </td>
                                        <td>
                                            <p class="text-left">{{ $pelengkapSekolah['atasNamaRekening'] }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <div class="flex justify-center my-6">
                                <h1 class="text-center poppins-medium text-gray-400">Data Kelengkapan Sekolah Belum Di Isi</h1>
                            </div>
                        @endif



                    </div>

                    <div id="containerDataSiswa" class="hidden">
                        <table class="table">
                            @foreach ($totalSiswa as $item)
                                <tr>
                                    <td class="w-[16rem]">
                                        <p class="poppins-medium whitespace-nowrap">{{ $item->namaJurusan }}</p>
                                    </td>
                                    <td>
                                        <p class="text-left">{{ $item['total'] }}</p>
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <td class="w-[16rem]">
                                    <p class="poppins-medium whitespace-nowrap">Total Keseluruhan</p>
                                </td>
                                <td>
                                    <p class="text-left">{{ $totalKeseluruhan }}</p>
                                </td>
                            </tr>

                        </table>
                    </div>

                    <div id="containerVisiMisi" class="hidden">
                        <div class="flex justify-end mb-6">
                            <a class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular text-sm"
                                href="dashboard/edit-visi-misi">Edit Visi Misi</a>
                        </div>

                        @if ($visi && $misi)
                            <div class="w-full">
                                <div class="mb-12">
                                    <h1 class="text-center poppins-bold text-lg">VISI</h1>
                                    <p class="text-center">{{ $visi->konten }}</p>
                                </div>

                                <div>
                                    <h1 class="text-center poppins-bold text-lg">MISI</h1>
                                    @foreach ($misi as $index => $item)
                                        <div class="flex items-start gap-3 mb-2">
                                            <p>{{ ++$index }}.</p>
                                            <p>{{ $item->konten }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="flex justify-center my-6">
                                <h1 class="text-center poppins-medium text-gray-400">Visi Misi Belum Di Tetapkan</h1>
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-end gap-4 items-center">
                        <button id="btn-click-prev" class="bg-gray-800 p-[1px] rounded-full text-white btn-click">
                            <span class="material-icons md-24">
                                chevron_left
                            </span>
                        </button>

                        <button id="btn-click-next" class="bg-gray-800 p-[1px] rounded-full text-white btn-click">
                            <span class="material-icons md-24">
                                navigate_next
                            </span>
                        </button>
                    </div>

                    <div class="divider"></div>

                    <div>
                        <table class="table">

                            <div class="flex justify-end mb-6">
                                @isset($profile)
                                    <a class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular text-sm"
                                        href="dashboard/atur-akreditas-sekolah">Atur Data Akreditas</a>
                                @endempty
                            </div>

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
                    </div>

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

        let page = 1;

        function nextPage() {
            if (page < 4) {
                ++page;
            }
            changePage();
        }

        function prevPage() {
            if (page > 1) {
                --page;
            }
            changePage();
        }


        function changePage() {
            const containerProfileSekolah = document.getElementById('containerProfileSekolah');
            const containerProfileTambahan = document.getElementById('containerProfileTambahan');
            const containerDataSiswa = document.getElementById('containerDataSiswa');
            const containerVisiMisi = document.getElementById('containerVisiMisi');

            if (page === 1) {
                containerProfileSekolah.classList.remove('hidden');
                containerProfileTambahan.classList.add('hidden');
                containerDataSiswa.classList.add('hidden');
                containerVisiMisi.classList.add('hidden');
            } else if (page === 2) {
                containerProfileTambahan.classList.remove('hidden');
                containerProfileSekolah.classList.add('hidden');
                containerDataSiswa.classList.add('hidden');
                containerVisiMisi.classList.add('hidden');
            } else if (page === 3) {
                containerDataSiswa.classList.remove('hidden');
                containerProfileTambahan.classList.add('hidden');
                containerProfileSekolah.classList.add('hidden');
                containerVisiMisi.classList.add('hidden');
            } else if (page === 4) {
                containerVisiMisi.classList.remove('hidden');
                containerDataSiswa.classList.add('hidden');
                containerProfileTambahan.classList.add('hidden');
                containerProfileSekolah.classList.add('hidden');
            }
        }

        // Menghubungkan fungsi dengan tombol navigasi
        document.getElementById('btn-click-prev').addEventListener('click', prevPage);
        document.getElementById('btn-click-next').addEventListener('click', nextPage);
    </script>
@endsection
