<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @vite('resources/css/app.css')
    <title>SIAS</title>
</head>

<body class="relative poppins-regular flex flex-col min-h-screen">
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

    <div class="w-full flex-grow flex bg-gray-200 relative">
        <div class="w-[20rem] lg:w-[28rem] h-screen fixed bg-white border-r p-4 overflow-auto">
            <p class="poppins-light text-gray-400 text-xs lg:text-sm">{{ $disposisi->tanggalDisposisi }}</p>

            <h1 class="poppins-medium lg:text-xl">{{ $disposisi->judulDisposisi }}</h1>
            <p class="text-gray-800 text-xs lg:text-sm mt-2">{{ $disposisi->arahan }}</p>

            <div class="divider"></div>
            <p class="poppins-light text-gray-400 text-xs lg:text-sm">Asal Surat</p>
            <h1 class="poppins-medium lg:text-xl">{{ $disposisi->asalTujuanSurat }}</h1>
            <p class="text-gray-800 text-xs lg:text-sm mt-2">{{ $disposisi->perihal }}</p>
        </div>

        <div class="w-[20rem] lg:w-[28rem]"></div>

        <div class="flex-1 flex flex-col overflow-hidden w-full" id="boxChat">
            <div class="flex-grow py-5 px-4 w-full" id="chatContainer">
                @foreach ($loadChat as $item)
                    @php
                        $isCurrentUser = $item->pegawai === $user;
                        $chatClass = $isCurrentUser ? 'chat-end' : 'chat-start';
                        $fileDownloadLink = $item->file
                            ? route('messageFile.download', ['filename' => basename($item->file)])
                            : null;
                    @endphp

                    <div class="chat {{ $chatClass }}">
                        <div class="chat-bubble text-xs lg:text-base">
                            @if ($fileDownloadLink)
                                <a target="_blank" href="{{ $fileDownloadLink }}"
                                    class="bg-gray-600 p-4 w-full rounded-lg mb-5 flex gap-2 justify-start items-center">
                                    <span class="material-icons text-white">description</span>
                                    <p class="text-white poppins-medium">Download</p>
                                </a>
                            @endif

                            <div>{{ $item->message }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <livewire:container-chat :idDisposisi="$disposisi->idDisposisi" />
        </div>
    </div>

    <input type="hidden" id="urlLoad" value="{{ url('/') }}/load-message/{{ $disposisi->idDisposisi }}">
    <input type="hidden" id="idDisposisi" value="{{ $disposisi->idDisposisi }}">
    <input type="hidden" id="userId" value="{{ $user }}">
    @vite('resources/js/app.js')
    @vite('resources/js/chat.js')

</body>

</html>
