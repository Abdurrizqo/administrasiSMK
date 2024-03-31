@extends('layouts.layout')
@section('content')
    <div class="w-full p-10 flex-1 bg-gray-200/60">

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-8">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="flex justify-center">
            <div class="w-full lg:w-[40rem] border shadow rounded-md p-10">
                <h1 class="text-center font-bold text-xl">Edit Data Siswa</h1>
                <h1 class="text-center font-bold text-xl">{{ $siswa['namaSiswa'] }}</h1>

                <form method="POST" class="mt-6 w-full flex flex-col gap-3">
                    @csrf

                    <label class="form-control w-full mb-6">
                        <div class="label">
                            <span class="label-text font-semibold">Nama Siswa</span>
                        </div>
                        <input required name="namaSiswa" value="{{ $siswa['namaSiswa'] }}" type="text"
                            placeholder="nama siswa" class="input input-bordered w-full" />
                        @error('namaSiswa')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <div class="grid grid-cols-2 gap-5 mb-6">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">NIS</span>
                            </div>
                            <input required name="nis" value="{{ $siswa['nis'] }}" type="text" placeholder="xxxx"
                                class="input input-bordered w-full" />
                            @error('nis')
                                <p class="text-xs text-red-400">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">NISN</span>
                            </div>
                            <input required name="nisn" value="{{ $siswa['nisn'] }}" type="text" placeholder="xxxx"
                                class="input input-bordered w-full" />
                            @error('nisn')
                                <p class="text-xs text-red-400">*{{ $message }}</p>
                            @enderror
                        </label>
                    </div>

                    <div class="grid grid-cols-2 gap-5 mb-6">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Jurusan</span>
                            </div>
                            <select required name="idJurusan" class="select select-bordered flex-1">
                                @foreach ($jurusan as $item)
                                    <option @if ($siswa['idJurusan'] === $item['idJurusan']) selected @endif
                                        value="{{ $item['idJurusan'] }}">
                                        {{ $item['namaJurusan'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idJurusan')
                                <p class="text-xs text-red-400">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Tahun Masuk</span>
                            </div>
                            <input required name="tahunMasuk" type="number" min="1920" max="2099" step="1"
                                value="{{ $siswa['tahunMasuk'] }}" placeholder="xxxx"
                                class="input input-bordered w-full" />
                            @error('tahunMasuk')
                                <p class="text-xs text-red-400">*{{ $message }}</p>
                            @enderror
                        </label>
                    </div>

                    <label class="form-control w-full mb-6">
                        <div class="label">
                            <span class="label-text font-semibold">Nama Wali</span>
                        </div>
                        <input required name="namaWali" value="{{ $siswa['namaWali'] }}" type="text"
                            placeholder="nama wali" class="input input-bordered w-full" />
                        @error('namaWali')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <div class="grid grid-cols-2 gap-5 mb-6">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">NIK Wali</span>
                            </div>
                            <input required name="nikWali" value="{{ $siswa['nikWali'] }}" type="text"
                                placeholder="xxxx" class="input input-bordered w-full" />
                            @error('nikWali')
                                <p class="text-xs text-red-400">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Hubungan Keluarga</span>
                            </div>
                            <select required name="hubunganKeluarga" class="select select-bordered flex-1">
                                <option @if ($siswa['hubunganKeluarga'] === 'Ayah') selected @endif value="Ayah">
                                    Ayah
                                </option>
                                <option @if ($siswa['hubunganKeluarga'] === 'Ibu') selected @endif value="Ibu">
                                    Ibu
                                </option>
                                <option @if ($siswa['hubunganKeluarga'] === 'Kakak') selected @endif value="Kakak">
                                    Kakak
                                </option>
                                <option @if ($siswa['hubunganKeluarga'] === 'Paman') selected @endif value="Paman">
                                    Paman
                                </option>
                                <option @if ($siswa['hubunganKeluarga'] === 'Ayah') Lainnya @endif value="Lainnya">
                                    Lainnya
                                </option>
                            </select>
                            @error('hubunganKeluarga')
                                <p class="text-xs text-red-400">*{{ $message }}</p>
                            @enderror
                        </label>
                    </div>

                    <div class="w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Alamat</span>
                        </div>

                        <textarea name="alamat" class="border w-full p-3 rounded-lg outline-none h-28" placeholder="Alamat">{{ $siswa['alamat'] }}</textarea>
                        @error('alamat')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-10 w-full flex justify-end col-span-2">
                        <button class="btn btn-neutral w-40">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
