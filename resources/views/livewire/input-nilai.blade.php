<div class="w-full mt-8 flex gap-4">
    <div class="min-w-[24rem] max-w-[24rem] bg-white border rounded-lg p-4 flex flex-col gap-3 overflow-auto">
        <form class="w-full mb-4 ">
            <select class="text-xl w-full poppins-bold outline-none" wire:model.live="segmentSemester"
                wire:change="resetView">
                <option value="PTS" class="popping-regular text-base">Rekap Data PTS</option>
                <option value="PAS" class="popping-regular text-base">Rekap Data PAS</option>
            </select>
        </form>

        @foreach ($kelasSiswa as $item)
            <div wire:click="selectSiswa('{{ $item->idSiswa }}')"
                class="p-4 rounded-lg border cursor-pointer btn-click">
                <h1 class="poppins-semibold text-lg">{{ $item->namaSiswa }}</h1>
                <p class="text-gray-400">{{ $item->nis }} - {{ $item->nisn }}</p>
            </div>
        @endforeach
    </div>

    @if ($selectedSiswa)
        <div class="min-w-[24rem] max-w-[32rem]">
            <div class="p-4 bg-white rounded-lg border w-full">
                <form wire:submit.prevent="save">
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Nilai Akademik</span>
                        </div>
                        <input type="text" wire:model="formNilaiAkademik" placeholder="0"
                            class="input input-bordered w-full" />
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Nilai Keterampilan</span>
                        </div>
                        <input type="text" wire:model="formNilaiKeterampilan" placeholder="0"
                            class="input input-bordered w-full" />
                    </label>

                    <div class="w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Keterangan</span>
                        </div>

                        <textarea wire:model="formKeterangan" class="border w-full p-3 rounded-lg outline-none h-28" placeholder="Keterangan"></textarea>
                    </div>

                    <div class="mt-10 w-full flex justify-end col-span-2">
                        <button class="btn btn-neutral w-40">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex-grow">
            <div class="bg-white p-4 border rounded-lg">
                <h1 class="mb-12 poppins-bold text-lg text-center">Rekap Nilai {{ $segmentSemester }}
                    @foreach ($kelasSiswa as $item)
                        @if ($item->idSiswa === $idSiswa)
                            {{ $item->namaSiswa }}
                        @endif
                    @endforeach

                </h1>
                @if ($rekap)
                    <div class="grid grid-cols-2 gap-x-2 gap-y-4 justify-items-center mb-4">
                        <h1 class="text-center poppins-medium">Nilai Akademik</h1>
                        <h1 class="text-center poppins-medium">Terbaca</h1>
                        <p class="text-center">{{ $rekap->nilaiAkademik }}</p>
                        <p>{{ $rekap->terbilangNilaiAkademik }}</p>
                    </div>

                    <div class="divider"></div>

                    <div class="grid grid-cols-2 gap-x-2 gap-y-4 justify-items-center mt-4 mb-4">
                        <h1 class="text-center poppins-medium">Nilai Keterampilan</h1>
                        <h1 class="text-center poppins-medium">Terbaca</h1>
                        <p class="text-center">{{ $rekap->nilaiKeterampilan }}</p>
                        <p>{{ $rekap->terbilangNilaiKeterampilan }}</p>
                    </div>

                    <div class="divider"></div>

                    <div class="flex justify-center flex-col items-center mt-4 mb-4">
                        <h1 class="text-center poppins-medium">Keterangan</h1>
                        <p>{{ $rekap->keterangan }}</p>
                    </div>
                @endif
            </div>
        </div>
    @endif

</div>
