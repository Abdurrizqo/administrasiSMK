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

<body class="relative bg-gray-200">
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
                    href="/ganti-photo-profile-guru">Ganti Foto Profile</a>

                <a class="poppins-medium btn-click text-neutral hover:text-white hover:bg-gray-700 p-3 rounded-md"
                    href="/dashboard/ganti-password">Ganti Password</a>

                <a class="poppins-medium btn-click text-neutral hover:text-white hover:bg-gray-700 p-3 rounded-md"
                    href="/logout">Logout</a>
            </div>
        </div>
    </div>

    @yield('content')

    @livewireScripts
</body>

</html>
