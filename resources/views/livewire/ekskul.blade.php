<div class="w-full bg-white border rounded-lg p-4 flex flex-col gap-3 items-center justify-center">

    @if ($isModalOpen)
        <div class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="modal-box">
                <h1 class="text-center text-lg font-medium mb-2">Hapus Data {{ $ekskul['namaEkskul'] }}</h1>
                <div class="modal-action flex justify-center">
                    <button wire:click="closeModal" class="btn-active btn-detail">Batal</button>
                    <button wire:click="deleteEkskul('{{ $ekskul['id'] }}')"
                        class="btn btn-error w-40 text-white">Hapus</button>
                </div>
            </div>
        </div>
    @endif

    <h1 class="text-lg poppins-medium">Ekskul</h1>

    <form class="w-full mt-6" wire:submit.prevent="saveEkskul">
        <div class="flex gap-4 items-center">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Nama Ekskul</span>
                </div>
                <input type="text" wire:model="formNamaEkskul" class="input input-bordered w-full" />
                {{-- @error('namaSiswa')
                    <p class="text-xs text-red-400">*{{ $message }}</p>
                @enderror --}}
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Penilaian</span>
                </div>
                <select required wire:model="formNilaiEkskul" class="select select-bordered flex-1">
                    <option>Nilai</option>
                    <option value="Sangat Baik">Sangat Baik</option>
                    <option value="Baik">Baik</option>
                    <option value="Kurang">Kurang</option>
                </select>
                {{-- @error('namaSiswa')
                    <p class="text-xs text-red-400">*{{ $message }}</p>
                @enderror --}}
            </label>
        </div>
        <button class="btn-clcik bg-neutral rounded-lg text-white w-full py-3 mt-10">Simpan</button>
    </form>

    <div class="divider"></div>

    @if ($successMsg)
        <div role="alert" class="alert alert-success mb-3 text-white font-semibold">
            <span>{{ $successMsg }}</span>
        </div>
    @endif

    @if ($errorMsg)
        <div role="alert" class="alert alert-error mb-3 text-white font-semibold">
            <span>{{ $errorMsg }}</span>
        </div>
    @endif

    <div class="w-full flex flex-col gap-3 mb-10">
        @foreach ($listEkskul as $item)
            <div class="p-3 rounded-md border shadow-md flex items-center">
                <div class="flex-grow">
                    <h1 class="poppins-semibold text-lg">{{ $item->namaEkskul }}</h1>
                    <h1 class="poppins-light text-gray-400">{{ $item->nilai }}</h1>
                </div>
                <div>
                    <button wire:click="openModal('{{ $item->idEkskul }}','{{ $item->namaEkskul }}')"
                        class="material-icons md-24">cancel</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
