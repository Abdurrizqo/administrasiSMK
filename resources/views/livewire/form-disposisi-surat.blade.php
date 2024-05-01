<div>
    @if ($isModalOpen)
        <div
            class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex items-center justify-center z-40 gap-4">
            <div class="w-[24rem] h-[34rem] bg-white p-5 rounded-xl flex flex-col">
                <h1 class="text-center text-lg font-medium mb-8">Disposisi Surat</h1>
                <form wire:submit.prevent="simpanDisposisiSurat" class="flex-grow overflow-auto modalScroll p-4">
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Judul</span>
                        </div>
                        <input wire:model="judulDisposisi" type="text" class="input input-bordered w-full" />
                        @error('judulDisposisi')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full mb-4">
                        <div class="label">
                            <span class="label-text font-semibold">Tujuan</span>
                        </div>
                        <input disabled wire:model="namaPegawai" type="text" placeholder="tujuan"
                            class="input input-bordered w-full" />
                        @error('tujuan')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full mb-4">
                        <div class="label">
                            <span class="label-text font-semibold">Arahan</span>
                        </div>
                        <textarea wire:model="arahan" class="w-full min-h-24 max-h-32 border-2 rounded-lg p-2 outline-none"></textarea>
                        @error('arahan')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <div class="flex justify-end gap-5 my-10">
                        <div class="btn-click btn-edit cursor-pointer" wire:click="closeModal">Kembali</div>
                        <button class="btn-click btn-detail" type="submit">Simpan</button>
                    </div>
                </form>
            </div>

            <div class="w-[24rem] h-[34rem] bg-white p-5 rounded-xl flex flex-col">
                <form class="w-full">
                    <input wire:model.live="searchPegawai" type="text" placeholder="nama pegawai"
                        class="input input-bordered w-full rounded-full" />
                </form>
                <div class="flex-frow overflow-auto mt-3 flex flex-col gap-2 modalScroll p-4">
                    @foreach ($pegawai as $item)
                        <div wire:click="selectPegawai('{{ $item->idPegawai }}','{{ $item->namaPegawai }}')"
                            class="border-b rounded cursor-pointer">
                            <h1 class="poppins-medium px-3 py-1">{{ $item->namaPegawai }}</h1>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div>
        <button wire:click="openModal" class="btn-click bg-gray-800 text-white px-8 py-2 rounded-lg">Disposisi</button>
    </div>
</div>
