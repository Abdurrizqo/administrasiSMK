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
