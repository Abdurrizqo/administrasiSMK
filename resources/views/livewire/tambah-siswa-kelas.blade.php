    <div class="card p-10 border rounded-md bg-white mt-10 h-[80rem] overflow-hidden">

        @if ($isModalDeleteOpen)
            <div class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex items-center justify-center">
                <div class="modal-box">
                    <h1 class="text-center text-lg font-medium mb-2">Hapus Data {{ $dataModal['namaSiswa'] }}</h1>
                    <p class="text-red-400 font-light text-center mb-8">seluruh Nilai Yang Telah Di input Akan Terhapus
                    </p>
                    <div class="modal-action flex justify-center">
                        <button wire:click="closeModalDelete" class="btn-click btn-detail w-40">Batal</button>
                        <button wire:click="deleteSiswa('{{ $dataModal['idKelasSiswa'] }}')"
                            class="btn btn-error w-40 text-white">Hapus</button>
                    </div>
                </div>
            </div>
        @endif

        @if ($isModalSaveOpen)
            <div class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex items-center justify-center">
                <div class="modal-box">
                    <h1 class="text-center text-lg font-medium mb-2">Daftarkan Siswa {{ $dataModal['namaSiswa'] }}
                        Kedalam Kelas</h1>

                    <div class="modal-action flex justify-center">
                        <button wire:click="closeModalSave" class="btn-click btn-detail w-40">Batal</button>
                        <button wire:click="masukanKelas('{{ $dataModal['idSiswa'] }}')"
                            class="btn-edit bg-white btn-click w-40">Simpan</button>
                    </div>
                </div>
            </div>
        @endif

        @if ($successMsg)
            <div role="alert" class="alert alert-success mb-8 text-white font-semibold">
                <span>{{ $successMsg }}</span>
            </div>
        @endif

        @if ($errorMsg)
            <div role="alert" class="alert alert-error mb-8 text-white font-semibold">
                <span>{{ $errorMsg }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 overflow-auto">
            <div class="w-full h-full overflow-auto">
                <form class="flex gap-4 w-full mb-10" wire:submit.prevent="">
                    <input type="text" placeholder="Cari Siswa" wire:model.live="searchDataSiswa"
                        class="border px-4 rounded-full w-full outline-none py-2 h-12" />
                </form>

                <div class="w-full h-full">
                    @foreach ($allSiswa as $item)
                        <div wire:key="{{ $item->idSiswa }}" class="border shadow mb-4 rounded-xl">
                            <div class="w-full bg-gray-700 px-3 py-2 text-white rounded-t-xl">
                                <p class="poppins-medium">{{ $item->namaJurusan }}</p>
                            </div>

                            <div class="px-8 py-4 flex justify-end items-center">
                                <div class="flex-1">
                                    <h1 class="poppins-semibold text-lg">{{ $item->namaSiswa }}</h1>
                                    <p class="poppins-light text-gray-400">NIS : {{ $item->nis }}</p>
                                    <p class="poppins-light text-gray-400">NISN : {{ $item->nisn }}</p>
                                </div>
                                <button wire:click="openModalSave('{{ $item->namaSiswa }}', '{{ $item->idSiswa }}')"
                                    class="btn-click md-36 text-neutral material-icons">add_circle</button>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

            <div class="w-full h-full overflow-auto">
                <form class="flex gap-4 w-full mb-10" wire:submit.prevent="">
                    <input type="text" placeholder="Cari Siswa Di Kelas"
                        wire:model.live="searchDataKelasSiswa"
                        class="border px-4 rounded-full w-full outline-none py-2 h-12" />
                </form>

                @foreach ($kelasSiswa as $item)
                    <div wire:key="{{ $item->idKelasSiswa }}" class="border shadow mb-4 rounded-xl">
                        <div class="w-full bg-gray-700 px-3 py-2 text-white rounded-t-xl flex justify-end">
                            <button
                                wire:click="openModalDelete('{{ $item->namaSiswa }}', '{{ $item->idKelasSiswa }}')"
                                class="flex gap-2 btn-click">
                                <p>Hapus</p>
                                <span class="material-icons text-xs">
                                    cancel
                                </span>
                            </button>
                        </div>

                        <div class="px-8 py-4 flex justify-end items-center">
                            <div class="flex-1">
                                <h1 class="poppins-semibold text-lg">{{ $item->namaSiswa }}</h1>
                                <p class="poppins-light text-gray-400">NIS : {{ $item->nis }}</p>
                                <p class="poppins-light text-gray-400">NISN : {{ $item->nisn }}</p>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
