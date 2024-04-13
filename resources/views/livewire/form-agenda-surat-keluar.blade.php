<div>
    @if ($isModalOpen)
        <div class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex items-center justify-center z-40">
            <div class="w-[40rem] bg-white p-5 rounded-xl">
                <h1 class="text-center text-lg font-medium mb-8">Catat Surat Keluar</h1>
                <form wire:submit.prevent="simpanAgendaSuratKeluar" class="h-[28rem] overflow-auto">
                    <div class="flex gap-4 items-center mb-4">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Nomer Surat</span>
                            </div>
                            <input wire:model="nomerSurat" type="text" placeholder="xxxx"
                                class="input input-bordered w-full" />
                            @error('nomerSurat')
                                <p class="text-xs text-red-400">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Tanggal Surat</span>
                            </div>
                            <input wire:model="tanggalSurat" type="date" class="input input-bordered w-full" />
                            @error('tanggalSurat')
                                <p class="text-xs text-red-400">*{{ $message }}</p>
                            @enderror
                        </label>
                    </div>

                    <label class="form-control w-full mb-4">
                        <div class="label">
                            <span class="label-text font-semibold">Asal</span>
                        </div>
                        <input wire:model="asalSurat" type="text" placeholder="tujuan"
                            class="input input-bordered w-full" />
                        @error('asalSurat')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full mb-4">
                        <div class="label">
                            <span class="label-text font-semibold">Perihal</span>
                        </div>
                        <textarea wire:model="perihal" class="w-full min-h-24 max-h-32 border-2 rounded-lg p-2 outline-none">
                        </textarea>
                        @error('perihal')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Dokumen</span>
                        </div>
                        <input wire:model="dokumenSurat" type="file" class="file-input file-input-bordered w-full" />
                        <div wire:loading wire:target="dokumenSurat">Uploading...</div>
                        @error('dokumenSurat')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <div class="flex justify-end gap-5 my-10">
                        <div class="btn-click btn-edit cursor-pointer" wire:click="closeModal">Kembali</div>
                        <button class="btn-click btn-detail" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <button wire:click='openModal' class="btn-click bg-neutral text-white px-4 py-2 rounded-lg poppins-regular"
        href="siswa/tambah-siswa">Catat
        Surat Keluar</button>
</div>
