<div class="w-[30rem] md:w-[34rem] bg-white rounded-lg border p-6">
    <h1 class="text-center poppins-bold text-lg md:text-xl mb-1">VISI</h1>
    <p class="mb-10 text-center poppins-medium text-gray-600">
        @if ($visi)
            {{ $visi->konten }}
        @endif
    </p>
    <div>
        <form wire:submit.prevent="save" method="POST">
            <div class="w-full">
                <textarea wire:model="konten" class="border border-gray-800 w-full p-3 rounded text-sm outline-none h-24 poppins-regular"></textarea>
                @error('konten')
                    <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                @enderror

                <div wire:loading>
                    <p class="text-green-500 text-sm poppins-light">Menyimpan...</p>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="btn-click bg-gray-800 text-white py-1 px-3 rounded-lg mt-4">Simpan</button>
            </div>
        </form>
    </div>
</div>
