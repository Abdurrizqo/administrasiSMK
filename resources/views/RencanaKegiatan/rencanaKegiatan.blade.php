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

        <div class="flex justify-end mb-4">
            <a href="rencana-kegiatan/create" class="btn-detail btn-click">Tambah Rencana Kegiatan</a>
        </div>

        <div class="flex justify-between w-full mb-10">
            <form class="flex gap-4"method="GET">
                <input type="text" placeholder="Cari Nama Kegiatan" name="search"
                    class="border p-3 rounded-full min-w-[24rem] max-w-[30rem] outline-none" />
                <button type="submit" class="btn-outline btn border border-neutral rounded-full w-20">Cari</button>
            </form>
        </div>

        <div class="grid grid-cols-3 gap-4">
            @foreach ($rencanaKegiatan as $item)
                <a href="rencana-kegiatan/detail/{{ $item->idRencanaKegiatan }}"
                    class="bg-white p-3 rounded-md border shadow w-full btn-click">
                    <p class="text-gray-400 poppins-light mb-2 text-end text-sm">{{ $item->created_at }}</p>

                    <h1 class="poppins-semibold text-lg">{{ $item->namaKegiatan }}
                    </h1>

                    <div class="mt-3 text-sm">
                        <p class="poppins-medium">Rencana Tanggal Pelaksanaan</p>
                        <p class="text-gray-400 poppins-light">{{ $item->tanggalMulaiKegiatan }}</p>
                    </div>

                    <div class="mt-3 text-sm">
                        <p class="poppins-medium">Ketua Pelaksana</p>
                        <p class="text-gray-400 poppins-light">{{ $item->namaPegawai }}</p>
                    </div>

                    <div class="mt-3 text-sm">
                        <p class="poppins-medium">Status</p>
                        @if ($item->isFinish)
                            <p class="text-green-400 poppins-light">Selesai</p>
                        @else
                            <p class="text-red-400 poppins-light">Belum Selesai</p>
                        @endif
                    </div>
                </a>
            @endforeach

        </div>

        <div class="mt-10 flex justify-center">
            {{ $rencanaKegiatan->links() }}
        </div>

    </div>
</body>

</html>
