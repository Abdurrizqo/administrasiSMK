@extends('layouts.layout')
@section('content')
    <div class="w-full">

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-8 text-white font-medium">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <span class="text-sm border border-gray-300 inline-block breadcrumbs bg-white px-8 py-3 poppins-medium rounded-full">
            <ul>
                <li><a href="/dashboard/jurnal-kegiatan">Jurnal Kegiatan</a></li>
                <li><a href="#">Tulis Jurnal</li></a>
            </ul>
        </span>

        <div class="flex justify-center mt-10 mb-10">
            <div class="w-[24rem] md:w-[28rem] lg:w-[36rem] bg-white border shadow rounded-md p-10">
                <h1 class="text-center font-bold text-xl">TULIS JURNAL KEGIATAN</h1>

                <form method="POST" class="mt-6 w-full flex flex-col gap-3 text-xs md:text-sm lg:text-base">
                    @csrf

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Tanggal Jurnal</span>
                        </div>
                        <input type="datetime-local" class="border p-3 rounded-md w-1/2 border-gray-400 outline-none"
                            name="tanggalDibuat" id="tanggalDibuat" />
                        @error('tanggalDibuat')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Materi Kegiatan</span>
                        </div>
                        <textarea class="w-full border border-gray-400 rounded-md p-2 h-24 outline-none" name="materiKegiatan">{{ old('materiKegiatan') }}</textarea>
                        @error('materiKegiatan')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Hasil</span>
                        </div>
                        <textarea class="w-full border border-gray-400 rounded-md p-2 h-24 outline-none" name="Hasil">{{ old('Hasil') }}</textarea>
                        @error('Hasil')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Hambatan</span>
                        </div>
                        <textarea class="w-full border border-gray-400 rounded-md p-2 h-24 outline-none" name="Hambatan">{{ old('Hambatan') }}</textarea>
                        @error('Hambatan')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Solusi</span>
                        </div>
                        <textarea class="w-full border border-gray-400 rounded-md p-2 h-24 outline-none" name="Solusi">{{ old('Solusi') }}</textarea>
                        @error('Solusi')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <p class="text-sm text-red-400">Pastikan seluruh form telah terisi dengan benar, jurnal yang telah
                            disimpan tidak dapat di ganti maupun dihapus</p>
                    </label>

                    <div class="mt-10 w-full flex justify-end">
                        <button class="btn btn-neutral w-40" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const dateTimeInput = document.getElementById('tanggalDibuat');
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Januari adalah 0!
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        dateTimeInput.value = formattedDateTime;
    </script>
@endsection
