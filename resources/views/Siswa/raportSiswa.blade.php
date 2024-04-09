<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>SIAS</title>
</head>

<body class="relative poppins-regular min-h-screen">
    <div class="navbar h-20 border-b fixed bg-white text-neutral flex justify-end top-0 z-20">
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
                        href="/home/ganti-password">Ganti Password</a>
                    <a class="poppins-medium btn-click text-neutral hover:text-white hover:bg-gray-700 p-3 rounded-md"
                        href="/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="min-h-[100vh] pt-28 px-8 pb-10 bg-gray-200">
        <span
            class="text-sm border border-gray-300 inline-block breadcrumbs bg-white px-8 py-3 poppins-medium rounded-full mb-10">
            <ul>
                <li><a href="/dashboard/siswa">Dashboard</a></li>
                <li><a href="/dashboard/siswa/detail/{{ $siswa->idSiswa }}">Detail Siswa</li></a>
                <li><a href="#">Raport Siswa</li></a>
            </ul>
        </span>

        <div class="flex gap-10 ">
            <div class="min-w-[28rem] max-w-[20rem] flex flex-col gap-6">

                <div class="w-full bg-white border rounded-lg p-4 flex flex-col justify-center items-center gap-3">
                    <form id="myForm" method="GET" class="w-full">
                        <select id="semester" name="semester" class="select text-lg w-full poppins-bold">
                            <option @if (request('semester') !== 'GENAP') selected @endif value="GANJIL" class="text-base">
                                Semester Ganjil
                            </option>

                            <option @if (request('semester') === 'GENAP') selected @endif value="GENAP" class="text-base">
                                Semester Genap
                            </option>
                        </select>
                    </form>
                </div>

                <div class="w-full bg-white border rounded-lg p-4 flex flex-col justify-center items-center gap-3">
                    <div class="avatar">
                        <div class="w-24 rounded-full">
                            @if ($siswa->fotoSiswa)
                                <img src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
                            @else
                                <div class="w-full h-full bg-gray-600"></div>
                            @endif
                        </div>
                    </div>

                    <h1 class="text-lg poppins-medium">{{ $siswa->namaSiswa }}</h1>
                    <p class="text-gray-500 mb-4">{{ $siswa->nis }} - {{ $siswa->nisn }}</p>

                    @if ($siswa->status)
                        @if ($siswa->status == 'NAIK KELAS')
                            <h1 class="poppins-regular bg-green-500 rounded-full px-3 py-1 text-white">
                                {{ $siswa->status }}</h1>
                        @else
                            <h1 class="poppins-regular bg-red-500 rounded-full px-3 py-1 text-white">
                                {{ $siswa->status }}
                            </h1>
                        @endif
                    @endif
                </div>

                <div class="w-full bg-white border rounded-lg p-4 flex flex-col items-center justify-center">
                    <h1 class="text-lg poppins-medium">Presensi</h1>

                    <div class="flex gap-4 items-center mt-6">
                        <div class="w-20 flex flex-col gap-1 p-2 border rounded-lg justify-center items-center">
                            <p class="text-gray-500">Hadir</p>
                            <p class="poppins-semibold">{{ $siswa->totalHadir }}</p>
                        </div>
                        <div class="w-20 flex flex-col gap-1 p-2 border rounded-lg justify-center items-center">
                            <p class="text-gray-500">Izin</p>
                            <p class="poppins-semibold">{{ $siswa->totalIzin }}</p>
                        </div>
                        <div class="w-20 flex flex-col gap-1 p-2 border rounded-lg justify-center items-center">
                            <p class="text-gray-500">Sakit</p>
                            <p class="poppins-semibold">{{ $siswa->totalSakit }}</p>
                        </div>
                        <div class="w-20 flex flex-col gap-1 p-2 border rounded-lg justify-center items-center">
                            <p class="text-gray-500">Absen</p>
                            <p class="poppins-semibold">{{ $siswa->totalTanpaKeterangan }}</p>
                        </div>
                    </div>
                </div>

                <div class="w-full bg-white border rounded-lg p-4 flex flex-col gap-3 items-center justify-center">

                    <h1 class="text-lg poppins-medium">Ekskul</h1>
                    <div class="w-full flex flex-col gap-3 mb-10">
                        @foreach ($ekskul as $item)
                            <div class="p-3 rounded-md border shadow flex items-center">
                                <div class="flex-grow">
                                    <h1 class="poppins-semibold text-lg">{{ $item->namaEkskul }}</h1>
                                    <h1 class="poppins-light text-gray-400">{{ $item->nilai }}</h1>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex-grow h-full flex flex-col gap-4 justify-center items-center w-full">
                <div class="w-full h-52 bg-white border rounded-lg p-4 overflow-auto">
                        <h1 class="text-lg poppins-bold mb-3">Catatan Guru</h1>
                    <p class="text-base poppins-regular text-gray-950 mt-4">{{ $siswa->catatanPas }}</p>
                </div>
                
                <div class="w-full flex-grow bg-white p-4 rounded-lg overflow-auto">
                    <table class="table border w-full">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Mata Pelajaran</th>
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
                                    <th class="text-center border">{{ ++$index }}</th>
                                    <td class="whitespace-nowrap border">{{ $item->namaMataPelajaran }}</td>
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
                                <th colspan="2" class="border">Total Nilai Akademik</th>
                                <td class="border text-center">{{ $totalNilai->totalAkademik }}</td>
                                <td class="border"></td>
                                <th colspan="2" class="border">Total Nilai Keterampilan</th>
                                <td class="border text-center">{{ $totalNilai->totalKeterampilan }}</td>
                            </tr>
                            <tr>
                                <th colspan="2" class="border">Rata-Rata Nilai Akademik</th>
                                <td class="border text-center">{{ $avgAkademik }}</td>
                                <td class="border"></td>
                                <th colspan="2" class="border">Rata-Rata Nilai Keterampilan</th>
                                <td class="border text-center">{{ $avgKeterampilan }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        var select = document.getElementById("semester");

        select.addEventListener("change", function() {
            document.getElementById("myForm").submit();
        });
    </script>
</body>

</html>
