<div>
    @if ($isModalOpen)
        <div class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex items-center justify-center z-40">
            <div class="w-[32rem] bg-white p-5 rounded-xl">
                <h1 class="text-center text-lg font-medium mb-4">Dokumen Raport Semester</h1>

                <form wire:submit.prevent="simpanDokumenRaport" class="overflow-auto modalScroll p-4">

                    <label class="form-control w-full">
                        <input wire:model="dokumenRaport" type="file" class="file-input file-input-bordered w-full" />
                        <div wire:loading wire:target="dokumenRaport" class="pl-2 text-gray-500 poppins-light">
                            Uploading...</div>
                        @error('dokumenRaport')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <div class="flex justify-end gap-5 my-5">
                        <div class="btn-click btn-edit cursor-pointer" wire:click="closeModal">Kembali</div>
                        <button class="btn-click btn-detail" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <button wire:click="openModal" class="btn-click bg-neutral text-white w-full py-1 rounded-lg poppins-regular">
        Dokumen Raport
    </button>
</div>
