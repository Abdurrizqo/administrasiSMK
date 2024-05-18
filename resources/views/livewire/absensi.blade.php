<div class="w-full bg-white border rounded-lg p-4 flex flex-col items-center justify-center">
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

    <h1 class="text-base md:text-lg poppins-medium">Presensi</h1>

    <form class="w-full mt-6" wire:submit.prevent="savePresensi">
        <div class="flex gap-4 items-center">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Total Kehadiran</span>
                </div>
                <input type="number" min="0" max="200" wire:model="formTotalKehadiran"
                    class="input input-bordered w-full" />
                @error('formTotalKehadiran')
                    <p class="text-xs text-red-400">*{{ $message }}</p>
                @enderror
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Total Izin</span>
                </div>
                <input type="number" min="0" max="200" wire:model="formTotalIzin"
                    class="input input-bordered w-full" />
                @error('formTotalIzin')
                    <p class="text-xs text-red-400">*{{ $message }}</p>
                @enderror
            </label>
        </div>


        <div class="flex gap-4 items-center mt-6">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Total Sakit</span>
                </div>
                <input type="number" min="0" max="200" wire:model="formTotalSakit"
                    class="input input-bordered w-full" />
                @error('formTotalSakit')
                    <p class="text-xs text-red-400">*{{ $message }}</p>
                @enderror
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold">Total Absen</span>
                </div>
                <input type="number" min="0" max="200" wire:model="formTotalAbsen"
                    class="input input-bordered w-full" />
                @error('formTotalAbsen')
                    <p class="text-xs text-red-400">*{{ $message }}</p>
                @enderror
            </label>
        </div>

        <button class="btn-clcik bg-neutral rounded-lg text-white w-full py-3 mt-10">Simpan</button>
    </form>
</div>
