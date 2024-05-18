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

@extends('layouts.layoutPegawai')
@section('content')
    <div class="min-h-[100vh] pt-28 px-8 pb-10">

        <span
            class="text-sm border border-gray-300 inline-block breadcrumbs bg-white px-8 py-3 poppins-medium rounded-full mb-10">
            <ul>
                <li><a href="/home">Home</a></li>
                <li><a href="#">Rekap Nilai Per Sisiwa</li></a>
            </ul>
        </span>

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


        <div class="flex gap-5 overflow-auto text-sm md:text-base">
            <div class="min-w-[16rem] max-w-[28rem] flex flex-col gap-6">

                <div class="w-full bg-white border rounded-lg p-4 flex flex-col justify-center items-center gap-3">
                    <a target="_blank" href="{{ $siswa->idSiswa }}/rekap-nilai-siswa"
                        class="btn-click text-center py-1 w-full border rounded-lg border-gray-800 text-white bg-gray-800">Rekap
                        Nilai</a>
                </div>
                <div class="w-full bg-white border rounded-lg p-4 flex flex-col justify-center items-center gap-3">
                    <div class="avatar">
                        <div class="w-24 h-24 rounded-full bg-gray-300 relative"
                            style="background-image: url('{{ Storage::url($siswa->fotoSiswa) }}'); background-size: cover; background-position: center;">
                        </div>
                    </div>

                    <h1 class="text-base md:text-lg poppins-medium">{{ $siswa->namaSiswa }}</h1>
                    <p class="text-gray-500 mb-4">{{ $siswa->nis }} - {{ $siswa->nisn }}</p>

                    @if ($siswa->status)
                        @if ($siswa->status == 'NAIK KELAS')
                            <h1 class="poppins-regular bg-green-500 rounded-full px-3 py-1 text-white">
                                {{ $siswa->status }}</h1>
                        @else
                            <h1 class="poppins-regular bg-red-500 rounded-full px-3 py-1 text-white">{{ $siswa->status }}
                            </h1>
                        @endif
                    @endif
                </div>

                @if ($semester === 'GENAP')
                    <div class="w-full bg-white border rounded-lg p-4 flex flex-col justify-center items-center gap-10">

                        @if (session('success'))
                            <div role="alert" class="alert alert-success mb-5 text-white">
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        @if (session('error'))
                            <div role="alert" class="alert alert-error mb-5 text-white">
                                <span>{{ session('error') }}</span>
                            </div>
                        @endif

                        <h1 class="text-base md:text-lg poppins-medium">Kenaikan Kelas</h1>


                        <form method="POST" class="w-full">
                            @csrf
                            <label class="form-control w-full">
                                <select required name="status" class="select select-bordered flex-1">
                                    <option>Status Kenaikan Kelas</option>

                                    <option @if ($siswa->status === 'NAIK KELAS') selected @endif value="NAIK KELAS">NAIK KELAS
                                    </option>

                                    <option @if ($siswa->status === 'TINGGAL KELAS') selected @endif value="TINGGAL KELAS">TINGGAL
                                        KELAS</option>
                                </select>
                                @error('status')
                                    <p class="text-xs text-red-400">*{{ $message }}</p>
                                @enderror
                            </label>

                            <button class="btn-clcik bg-neutral rounded-lg text-white w-full py-3 mt-10">Simpan</button>
                        </form>
                    </div>
                @endif


                <livewire:catatan-siswa :semester="$semester" />
                <livewire:absensi :semester="$semester" />
                <livewire:ekskul />
            </div>

            <div class="flex-grow h-full">
                <div class="bg-white p-4 rounded-lg overflow-auto">
                    <table class="table border w-full">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Mata Pelajaran</th>
                                <th class="text-center"></th>
                                <th class="text-center">Nilai Akademik</th>
                                <th class="text-center">Terbilang</th>
                                <th class="text-center">Nilai Keterampilan</th>
                                <th class="text-center">Terbilang</th>
                                <th class="text-center">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekapMapel as $index => $item)
                                <tr>
                                    <th rowspan="2" class="text-center border">{{ ++$index }}</th>
                                    <td rowspan="2" class="whitespace-nowrap border">{{ $item->namaMataPelajaran }}</td>
                                    <td class="text-center border">PTS</td>

                                    @foreach ($pts as $rekapPts)
                                        @if ($rekapPts->kelasMapel === $item->idKelasMapel)
                                            <td class="text-center">{{ $rekapPts->nilaiAkademik }}</td>
                                            <td class="border">{{ $rekapPts->terbilangNilaiAkademik }}</td>
                                            <td class="text-center border">{{ $rekapPts->nilaiKeterampilan }}</td>
                                            <td class="border">{{ $rekapPts->terbilangNilaiKeterampilan }}</td>
                                            <td class="border">{{ $rekapPts->keterangan }}</td>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="text-center border">PAS</td>
                                    @foreach ($pas as $rekapPas)
                                        @if ($rekapPas->kelasMapel === $item->idKelasMapel)
                                            <td class="text-center border">{{ $rekapPas->nilaiAkademik }}</td>
                                            <td class="border">{{ $rekapPas->terbilangNilaiAkademik }}</td>
                                            <td class="text-center border">{{ $rekapPas->nilaiKeterampilan }}</td>
                                            <td class="border">{{ $rekapPas->terbilangNilaiKeterampilan }}</td>
                                            <td class="border">{{ $rekapPas->keterangan }}</td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach

                            <tr>
                                <th rowspan="2" colspan="2" class="text-center border">Total Nilai</th>
                                <td class="border">PTS</td>
                                <th class="border text-center">Total Nilai Akademik</th>
                                <td class="border text-center">{{ $totalNilaiPts->totalAkademik }}</td>
                                <td class="border"></td>
                                <th class="border text-center">Total Nilai Keterampilan</th>
                                <td class="border text-center">{{ $totalNilaiPts->totalKeterampilan }}</td>
                            </tr>
                            <tr>
                                <td class="border">PAS</td>
                                <th class="border text-center">Total Nilai Akademik</th>
                                <td class="border text-center">{{ $totalNilaiPas->totalAkademik }}</td>
                                <td class="border"></td>
                                <th class="border text-center">Total Nilai Keterampilan</th>
                                <td class="border text-center">{{ $totalNilaiPas->totalKeterampilan }}</td>
                            </tr>

                            <tr>
                                <th rowspan="2" colspan="2" class="text-center border">Rata-Rata</th>
                                <td class="border">PTS</td>
                                <th class="border text-center">Rata-Rata Nilai Akademik</th>
                                <td class="border text-center">{{ $avgpts['avgAkademik'] }}</td>
                                <td class="border"></td>
                                <th class="border text-center">Rata-Rata Nilai Keterampilan</th>
                                <td class="border text-center">{{ $avgpts['avgKeterampilan'] }}</td>
                            </tr>
                            <tr>
                                <td class="border">PAS</td>
                                <th class="border text-center">Rata-Rata Nilai Akademik</th>
                                <td class="border text-center">{{ $avgpas['avgAkademik'] }}</td>
                                <td class="border"></td>
                                <th class="border text-center">Rata-Rata Nilai Keterampilan</th>
                                <td class="border text-center">{{ $avgpas['avgKeterampilan'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="w-full flex gap-10 flex-wrap mb-10 mt-10">
                    <div class="flex-1 rounded-md border shadow p-4 bg-white max-h-[32rem] relative overflow-auto">
                        <h1 class="font-bold text-lg mb-6">Catatan Siswa</h1>
                        <form method="POST" action="/catatan/{{ $siswa->idSiswa }}"
                            class="flex gap-3 flex-col sticky top-0 bg-white pb-4">
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

                                    <button
                                        onclick="modalDeleteCatatan.showModal(); deleteCatatan('{{ $item->idCatatanSiswa }}')"
                                        class="btn-click">
                                        <span class="material-icons text-red-500 md-24">
                                            delete
                                        </span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex-1 rounded-md border shadow p-4 bg-white max-h-[32rem] relative overflow-auto">
                        <h1 class="font-bold text-lg mb-6">Sertifikat siswa</h1>

                        <form method="POST" action="/sertifikat/{{ $siswa->idSiswa }}" enctype="multipart/form-data"
                            class="flex gap-3 flex-col sticky top-0 bg-white pb-6">
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
                                    <input name="sertifikat" type="file"
                                        class="file-input file-input-bordered w-full" />
                                    @error('sertifikat')
                                        <p class="text-xs text-red-400">*{{ $message }}</p>
                                    @enderror
                                </label>

                                <button type="submit" class="btn-detail btn-click">Simpan</button>
                            </div>
                        </form>

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
        </div>
    </div>

    <script>
        function deleteCatatan(dataIdCatatan) {
            const linkDelete = document.getElementById("linkDeleteCatatan");
            linkDelete.setAttribute("href", `/catatan/${dataIdCatatan}/delete`);
        }

        function deleteSertifikat(dataIdSertifikat) {
            const linkDelete = document.getElementById("linkDeleteSertifikat");
            linkDelete.setAttribute("href", `/sertifikat/${dataIdSertifikat}/delete`);
        }
    </script>
@endsection
