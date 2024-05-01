<div class="w-full bg-white border rounded-lg p-4 flex flex-col justify-center items-center gap-3">

    @if ($isModalPtsOpen)
        <div class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex items-center justify-center z-40">
            <div class="w-[40rem] bg-white p-5 rounded-xl">
                <h1 class="poppins-semibold mb-5 text-lg">Catatan Untuk Siswa (PTS)</h1>
                <form class="w-full" wire:submit.prevent="saveCatatanPts">
                    <textarea wire:model="catatanPts" class="w-full min-h-52 max-h-64 border-2 rounded-lg p-2 outline-none">
                    </textarea>
                    @error('catatanPts')
                        <p class="text-xs text-red-400">*{{ $message }}</p>
                    @enderror

                    @if ($mesgSuccess)
                        <p class="text-green-500 poppins-regular">Berhasil Tersimpan</p>
                    @endif

                    @if ($mesgError)
                        <p class="text-red-500 poppins-regular">Gagal Tersimpan</p>
                    @endif

                    <div class="flex justify-end gap-5 mt-5">
                        <div class="btn-click btn-edit cursor-pointer" wire:click="closeModalPts">Kembali</div>
                        <button class="btn-click btn-detail" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if ($isModalPasOpen)
        <div class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex items-center justify-center z-40">
            <div class="w-[40rem] bg-white p-5 rounded-xl">
                <h1 class="poppins-semibold mb-5 text-lg">Catatan Untuk Siswa (PAS)</h1>
                <form class="w-full" wire:submit.prevent="saveCatatanPas">
                    <textarea wire:model="catatanPas" class="w-full min-h-52 max-h-64 border-2 rounded-lg p-2 outline-none"></textarea>
                    @error('catatanPas')
                        <p class="text-xs text-red-400">*{{ $message }}</p>
                    @enderror

                    @if ($mesgSuccess)
                        <p class="text-green-500 poppins-regular">Berhasil Tersimpan</p>
                    @endif

                    @if ($mesgError)
                        <p class="text-red-500 poppins-regular">Gagal Tersimpan</p>
                    @endif

                    <div class="flex justify-end gap-5 mt-5">
                        <div class="btn-click btn-edit cursor-pointer" wire:click="closeModalPas">Kembali</div>
                        <button class="btn-click btn-detail" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <h1 class="text-lg poppins-medium">Catatan Siswa</h1>

    <div class="flex gap-4 justify-center items-center w-full mt-6">
        <button wire:click="openModalPts" class="btn-click py-2 rounded-lg flex-grow text-white bg-gray-800">Catatan
            PTS</button>
        <button wire:click="openModalPas" class="btn-click py-2 rounded-lg flex-grow text-white bg-gray-800">Catatan
            PAS</button>
    </div>
</div>
