<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')

    <title>Laravel</title>
</head>

<body class="flex justify-center">
    <div class="w-[48rem] my-8">

        <div class="card border shadow-md rounded-md">
            <div class="p-8">

                <div class="flex items-center">
                    <div class="flex-1">
                        <h1 class="text-xl font-bold">{{ $dataPegawai['namaPegawai'] }}</h1>
                        <p class="text-gray-400 font-light">{{ $dataPegawai['nipy'] }}</p>
                    </div>

                    <button class="btn btn-error text-white">Keluar</button>
                </div>

                <div class="divider"></div>

                @if (count($waliKelas) > 0)
                    <div class="w-full">
                        <h1 class="text-xl font-bold">Wali Kelas {{ $waliKelas[0]['namaKelas'] }}</h1>
                        <p class="text-gray-400 font-light">{{ $waliKelas[0]['tahunAjaran'] }} -
                            {{ $waliKelas[0]['semester'] }}</p>
                    </div>

                    <a href="" class="btn btn-neutral text-white mt-8 w-full">Periksa Kelas</a>
                @endif
            </div>
        </div>

        <div class="card border shadow-md rounded-md mt-10">
            <div class="p-8">
                @foreach ($mapel as $item)
                    <div class="p-3 rounded-md border shadow mb-5 flex justify-center">
                        <div class="flex-1">
                            <h1 class="font-semibold">{{ $item['dataKelas']['namaKelas'] }}</h1>
                            <p class="text-gray-400">{{ $item['dataMapel']['namaMataPelajaran'] }}</p>
                        </div>

                        <div class="flex gap-4 items-center w-72 justify-between">
                            <a href="home/input-nilai-pts/{{ $item['idKelasMapel'] }}/{{$item['kelas']}}" class="btn btn-neutral">Input Nilai
                                PTS</a>
                            <a href="home/input-nilai-pas/{{ $item['idKelasMapel'] }}/{{$item['kelas']}}" class="btn btn-neutral">Input Nilai
                                PAS</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>

</html>
