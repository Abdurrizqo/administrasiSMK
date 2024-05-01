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
                        href="/dashboard/ganti-password">Ganti Password</a>
                    <a class="poppins-medium btn-click text-neutral hover:text-white hover:bg-gray-700 p-3 rounded-md"
                        href="/logout">Logout</a>
                </div>
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
            </div>
        </div>

        <div class="min-w-48 lg:w-56"></div>

        <div class="flex-1 flex flex-col w-full min-h-screen">
            <div class="flex-1 p-4 min-h-screen w-full bg-gray-100">
                @yield('content')
            </div>
            <div class="h-10 bg-gray-700"></div>
        </div>
    </div>
</body>

</html>
