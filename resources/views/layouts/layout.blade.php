<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @vite('resources/css/app.css')
    <title>SIAS</title>
    @livewireStyles
</head>


<body class="w-full min-h-screen flex flex-col relative">
    <div class="navbar h-20 border-b fixed bg-white text-neutral flex gap-3 justify-end top-0 z-20">
        <div class="dropdown dropdown-end">
            @auth
                <p class="text-lg poppins-semibold">
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
                    href="/ganti-photo-profile">Ganti Foto Profile</a>

                <a class="poppins-medium btn-click text-neutral hover:text-white hover:bg-gray-700 p-3 rounded-md"
                    href="/dashboard/ganti-password">Ganti Password</a>

                <a class="poppins-medium btn-click text-neutral hover:text-white hover:bg-gray-700 p-3 rounded-md"
                    href="/logout">Logout</a>
            </div>
        </div>
    </div>

    <div class="navbar h-20"></div>

    <div class="flex-1 flex">
        <div class="fixed top-0 h-full w-48 lg:w-56 bg-neutral z-40">
            <div class="w-full h-20 p-3 bg-gray-700 mb-5">
            </div>

            <div class="text-sm text-white poppins-light px-3 flex flex-col gap-2 sideBar h-full overflow-y-auto">
                <a href="/dashboard" class="hover:bg-gray-700 p-3 rounded-md cursor-pointer flex gap-3 items-center">
                    <span class="material-icons inline-block w-8">
                        maps_home_work
                    </span>

                    <p class="inline-block flex-1">Profil Sekolah</p>
                </a>

                <a href="/dashboard/jurusan"
                    class="hover:bg-gray-700 p-3 rounded-md cursor-pointer flex gap-3 items-center">
                    <span class="material-icons inline-block w-8">
                        architecture
                    </span>

                    <p class="inline-block flex-1">Program Keahlian / Kompetensi Keahlian</p>
                </a>

                <a href="/dashboard/mapel"
                    class="hover:bg-gray-700 p-3 rounded-md cursor-pointer flex gap-3 items-center">
                    <span class="material-icons inline-block w-8">
                        book
                    </span>

                    <p class="inline-block flex-1">Mata Pelajaran</p>
                </a>

                <a href="/dashboard/pegawai"
                    class="hover:bg-gray-700 p-3 rounded-md cursor-pointer flex gap-3 items-center">
                    <span class="material-icons inline-block w-8">
                        people_alt
                    </span>

                    <p class="inline-block flex-1">Pegawai</p>
                </a>

                <a href="/dashboard/siswa"
                    class="hover:bg-gray-700 p-3 rounded-md cursor-pointer flex gap-3 items-center">
                    <span class="material-icons inline-block w-8">
                        school
                    </span>

                    <p class="inline-block flex-1">Siswa</p>
                </a>

                <a href="/dashboard/kelas"
                    class="hover:bg-gray-700 p-3 rounded-md cursor-pointer flex gap-3 items-center">
                    <span class="material-icons inline-block w-8">
                        splitscreen
                    </span>

                    <p class="inline-block flex-1">Kelas</p>
                </a>

                <a href="/dashboard/agenda-surat-masuk"
                    class="hover:bg-gray-700 p-3 rounded-md cursor-pointer flex gap-3 items-center">
                    <span class="material-icons inline-block w-8">
                        email
                    </span>

                    <p class="inline-block flex-1">Surat Masuk</p>
                </a>

                <a href="/dashboard/agenda-surat-keluar"
                    class="hover:bg-gray-700 p-3 rounded-md cursor-pointer flex gap-3 items-center">
                    <span class="material-icons inline-block w-8">
                        drafts
                    </span>

                    <p class="inline-block flex-1">Surat Keluar</p>
                </a>

                <a href="/dashboard/disposisi-surat"
                    class="hover:bg-gray-700 p-3 rounded-md cursor-pointer flex gap-3 items-center">
                    <span class="material-icons inline-block w-8">
                        share
                    </span>

                    <p class="inline-block flex-1">Disposisi Surat</p>
                </a>

                <a href="/rencana-kegiatan"
                    class="hover:bg-gray-700 p-3 rounded-md cursor-pointer flex gap-3 items-center">
                    <span class="material-icons inline-block w-8">
                        event_note
                    </span>

                    <p class="inline-block flex-1">Rencana Kegiatan</p>
                </a>

                <a href="/dashboard/jurnal-kegiatan"
                    class="hover:bg-gray-700 mb-40 p-3 rounded-md cursor-pointer flex gap-3 items-center">
                    <span class="material-icons inline-block w-8">
                        assignment_add
                    </span>

                    <p class="inline-block flex-1">Jurnal Kegiatan</p>
                </a>
            </div>
        </div>

        <div class="min-w-48 lg:min-w-56"></div>

        <div class="flex-1 flex flex-col w-full min-h-screen">
            <div class="flex-1 p-4 min-h-screen w-full bg-gray-100">
                @yield('content')
            </div>
            <div class="h-10 bg-gray-700"></div>
        </div>
    </div>
</body>

</html>
