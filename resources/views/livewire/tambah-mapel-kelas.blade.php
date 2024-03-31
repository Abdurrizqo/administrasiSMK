<div class="mt-10">

    @if ($modalIsOpenDelete)
        <div class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="modal-box">
                <h1 class="text-center text-lg font-medium mb-2">Hapus Data {{ $dataModal['namaMapel'] }}</h1>
                <p class="text-red-400 font-light text-center mb-8">seluruh Nilai Yang Telah Di input Akan Terhapus
                </p>
                <div class="modal-action flex justify-center">
                    <button wire:click="closeModal" class="btn-active btn-detail">Batal</button>
                    <button wire:click="delete('{{ $dataModal['idMapel'] }}')"
                        class="btn btn-error w-40 text-white">Hapus</button>
                </div>
            </div>
        </div>
    @endif

    @if ($modalIsOpenEdit)
        <div class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="modal-box">
                <h1 class="text-center text-lg font-medium mb-8">Edit Data {{ $dataModal['namaMapel'] }}</h1>
                <form class="mt-6 w-full flex flex-col gap-3"
                    wire:submit.prevent="edit('{{ $dataModal['idKelasMapel'] }}')">
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Guru Mapel</span>
                        </div>
                        <select required class="select select-bordered flex-1" wire:model="stateGuruEdit">
                            @foreach ($guru as $index => $item)
                                <option value="{{ $item->idPegawai }}">{{ $item->namaPegawai }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Mata Pelajaran</span>
                        </div>
                        <select required class="select select-bordered flex-1" wire:model="stateMapelEdit">
                            @foreach ($mapel as $index => $item)
                                <option value="{{ $item->idMataPelajaran }}">{{ $item->namaMataPelajaran }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <div class="mt-10 w-full flex justify-center gap-16 items-center">
                        <button wire:click.prevent="closeModalEdit" class="btn-click btn-edit">Batal</button>
                        <button class="btn-click btn-detail">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @isset($messageSuccess)
        <div role="alert" class="alert alert-success mb-8 text-white font-semibold">
            <span>{{ $messageSuccess }}</span>
        </div>
    @endisset

    @isset($messageError)
        <div role="alert" class="alert alert-success mb-8 text-white font-semibold">
            <span>{{ $messageError }}</span>
        </div>
    @endisset

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 border rounded-md bg-white p-10">
        <div class="w-full border-b-2 lg:border-b-0 lg:border-r-2 grid grid-cols-2 gap-8">
            <div class="mb-4">
                <h4 class="poppins-semibold">Nama Kelas</h4>
                <p class="text-gray-400 font-light">{{ $kelas['namaKelas'] }}</p>
            </div>

            <div class="mb-4">
                <h4 class="poppins-semibold">Wali Kelas</h4>
                <p class="text-gray-400 font-light">{{ $kelas['namaPegawai'] }}</p>
            </div>

            <div class="mb-4">
                <h4 class="poppins-semibold">Tahun Ajaran</h4>
                <p class="text-gray-400 font-light">{{ $kelas['tahunAjaran'] }}</p>
            </div>

            <div class="mb-4">
                <h4 class="poppins-semibold">Semester</h4>
                <p class="text-gray-400 font-light uppercase">{{ $semester }}</p>
            </div>
        </div>

        <div class="w-full">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-2 gap-5 mb-5">
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Guru Mapel</span>
                        </div>
                        <select required class="select select-bordered flex-1" name="stateGuru" wire:model="stateGuru">
                            <option>Pilih Guru</option>
                            @foreach ($guru as $index => $item)
                                <option value="{{ $item->idPegawai }}">{{ $item->namaPegawai }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Mata Pelajaran</span>
                        </div>
                        <select required class="select select-bordered flex-1" name="stateMapel"
                            wire:model="stateMapel">
                            <option>Pilih Mapel</option>
                            @foreach ($mapel as $index => $item)
                                <option value="{{ $item->idMataPelajaran }}">{{ $item->namaMataPelajaran }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <button class="btn btn-neutral w-full">Simpan</button>
            </form>
        </div>
    </div>

    <div
        class="mt-10 border rounded-md bg-white p-10 flex flex-wrap justify-center lg:justify-start items-start gap-10">
        @foreach ($listKelasMapel as $item)
            <div wire:key="{{ $item->idKelasMapel }}" class="border shadow mb-6 rounded-xl w-[20rem]">
                <div class="w-full bg-gray-700 px-3 py-2 text-white flex justify-end rounded-t-xl gap-16">
                    <button
                        wire:click="openModalEdit('{{ $item->idMataPelajaran }}', '{{ $item->idPegawai }}', '{{ $item->idKelasMapel }}', '{{ $item->namaMataPelajaran }}')"
                        class="flex gap-3 btn-click items-center">
                        <span class="material-icons md-18">edit</span>
                        <p>Edit</p>
                    </button>

                    <button wire:click="openModal('{{ $item->namaMataPelajaran }}', '{{ $item->idKelasMapel }}')"
                        class="flex gap-3 btn-click items-center">
                        <span class="material-icons md-18">cancel</span>
                        <p>Hapus</p>
                    </button>
                </div>

                <div class="w-full px-6 py-4 ">
                    <h1 class="mb-1 poppins-medium">{{ $item->namaMataPelajaran }}</h1>
                    <p class="poppins-light">{{ $item->namaPegawai }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
