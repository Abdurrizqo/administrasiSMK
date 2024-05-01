<div class="w-[30rem] md:w-[34rem] bg-white rounded-lg border p-6">
    @if ($isModalOpen)
        <div class="fixed top-0 left-0 z-40 w-full h-full bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="modal-box">
                <h1 class="text-center text-xl font-medium mb-16">Hapus Data Misi</h1>
                <div class="modal-action flex justify-end">
                    <button wire:click="closeModal"
                        class="btn-click bg-gray-800 text-white px-8 py-1 rounded-lg">Batal</button>
                    <button wire:click="deleteMisi"
                        class="btn-click bg-white text-gray-800 border-gray-800 border px-8 py-1 rounded-lg">Hapus</button>

                </div>
            </div>
        </div>
    @endif

    <h1 class="text-center poppins-bold text-lg md:text-xl mb-4">MISI</h1>

    <div>
        <form wire:submit.prevent="save">
            <div class="w-full">
                @if ($idMisi)
                    <input wire:model="idMisi" type="hidden" disabled
                        class="input poppins-regular input-bordered w-full" />
                @endif
                <input wire:model="konten" type="text" class="input poppins-regular input-bordered w-full" />
                @error('konten')
                    <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                @enderror

                <div class="flex justify-end">
                    @if ($idMisi)
                        <div class="flex gap-3 items-center">
                            <button type="submit" class="btn-click bg-gray-800 text-white py-1 px-3 rounded-lg mt-4">
                                Edit
                            </button>

                            <button wire:click='cancelEdit'
                                class="btn-click border bg-white border-gray-800 text-gray-800 py-1 px-3 rounded-lg mt-4">
                                Cancel
                            </button>
                        </div>
                    @else
                        <button type="submit" class="btn-click bg-gray-800 text-white py-1 px-3 rounded-lg mt-4">
                            Simpan
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <div class="w-full flex flex-col gap-3 justify-center mt-4">
        @foreach ($misi as $index => $item)
            <div class="border-b py-3 px-2 border-gray-500">
                <div class="flex items-start justify-start gap-3 ">
                    <p>{{ ++$index }}.</p>
                    <p>{{ $item->konten }}</p>
                </div>

                <div class="flex justify-end gap-3 text-sm poppins-light mt-4">
                    <button class="text-green-400 btn-click"
                        wire:click="edit('{{ $item->idVisiMisi }}', '{{ $item->konten }}')">Edit</button>
                    <button wire:click="openModal('{{ $item->idVisiMisi }}')"
                        class="text-red-400 btn-click">Delete</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
