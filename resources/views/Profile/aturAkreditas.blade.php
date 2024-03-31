@extends('layouts.layout')
@section('content')
    <div class="w-full p-10  flex-1 bg-gray-100">
        @if (session('error'))
            <div role="alert" class="alert alert-error mb-8 text-white">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <span class="text-sm border border-gray-300 inline-block breadcrumbs bg-white px-8 py-3 poppins-medium rounded-full">
            <ul>
                <li><a href="/dashboard">dashboard</a></li>
                <li><a href="#">Atur Akreditasi Sekolah</li></a>
            </ul>
        </span>

        <div class="flex justify-center mt-10 mb-20">
            <div class="w-[26rem] md:w-[32rem] p-10 rounded-lg bg-white h-full">
                <h1 class="text-center poppins-bold text-xl mb-8">AKREDITASI SEKOLAH</h1>

                <form method="POST">
                    @csrf
                    <label class="form-control w-full mb-6">
                        <div class="label">
                            <span class="label-text poppins-semibold">Tahun Akreditasi</span>
                        </div>
                        <input required name="tahunAkreditasi" type="number" min="1920" max="2099" step="1"
                            value="@isset($akreditasi){{ $akreditasi['tahunAkreditasi'] }}@endisset"
                            placeholder="Tahun Akreditasi" class="input poppins-regular input-bordered w-full" />
                        @error('tahunAkreditasi')
                            <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full mb-6">
                        <div class="label">
                            <span class="label-text poppins-semibold">Nilai Akreditasi</span>
                        </div>
                        <input required name="nilaiAkreditasi" type="text"
                            value="@isset($akreditasi){{ $akreditasi['nilaiAkreditasi'] }}@endisset"
                            placeholder="nilai akreditasi" class="input poppins-regular input-bordered w-full" />
                        @error('nilaiAkreditasi')
                            <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full mb-6">
                        <div class="label">
                            <span class="label-text poppins-semibold">Akreditasi</span>
                        </div>
                        <input required name="sebutan" type="text"
                            value="@isset($akreditasi){{ $akreditasi['sebutan'] }}@endisset"
                            placeholder="akreditasi" class="input poppins-regular input-bordered w-full" />
                        @error('akreditasi')
                            <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                        @enderror
                    </label>
                    <div class="mt-10 w-full flex justify-end col-span-2">
                        <button class="btn btn-neutral w-40 poppins-medium">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
