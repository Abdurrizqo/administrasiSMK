@extends('layouts.layout')
@section('content')
    <div class="w-full">

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-8 text-white">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <span class="text-sm border border-gray-300 inline-block breadcrumbs bg-white px-8 py-3 poppins-medium rounded-full">
            <ul>
                <li><a href="/dashboard">dashboard</a></li>
                <li><a href="#">Edit Profil Tambahan</li></a>
            </ul>
        </span>

        <div class="flex justify-center mt-10 mb-10">
            <div class="w-[30rem] md:w-[34rem] lg:w-[40rem] bg-white rounded-lg border p-10">
                <h1 class="text-center poppins-bold text-lg md:text-xl mb-8">EDIT PROFIL TAMBAHAN</h1>

                <form method="POST" class="text-sm md:text-base">
                    @csrf
                    <div class="grid grid-cols-2 gap-5 ">
                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">Nomer SK Pendirian</span>
                            </div>
                            <input required name="skPendirian" type="text"
                                value="@isset($profileTambahan){{ $profileTambahan['skPendirian'] }}@endisset"
                                class="input poppins-regular input-bordered w-full" />
                            @error('skPendirian')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">Tanggal SK Pendirian</span>
                            </div>
                            <input required name="tanggalSk" type="date"
                                value="@isset($profileTambahan){{ $profileTambahan['tanggalSk'] }}@endisset"
                                class="input poppins-regular input-bordered w-full" />
                            @error('tanggalSk')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">Nomer SK Izin</span>
                            </div>
                            <input required name="skIzin" type="text"
                                value="@isset($profileTambahan){{ $profileTambahan['skIzin'] }}@endisset"
                                class="input poppins-regular input-bordered w-full" />
                            @error('skIzin')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">Tanggal SK Izin</span>
                            </div>
                            <input required name="tanggalSkIzin" type="date"
                                value="@isset($profileTambahan){{ $profileTambahan['tanggalSkIzin'] }}@endisset"
                                class="input poppins-regular input-bordered w-full" />
                            @error('tanggalSkIzin')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">Akun Rekening</span>
                            </div>
                            <input required name="rekening" type="text"
                                value="@isset($profileTambahan){{ $profileTambahan['rekening'] }}@endisset"
                                class="input poppins-regular input-bordered w-full" />
                            @error('rekening')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">Nomer Rekening</span>
                            </div>
                            <input required name="noRekening" type="text"
                                value="@isset($profileTambahan){{ $profileTambahan['noRekening'] }}@endisset"
                                class="input poppins-regular input-bordered w-full" />
                            @error('noRekening')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>
                    </div>

                    <label class="form-control w-full mb-6">
                        <div class="label">
                            <span class="label-text poppins-semibold">Atas nama</span>
                        </div>
                        <input required name="atasNamaRekening" type="text"
                            value="@isset($profileTambahan){{ $profileTambahan['atasNamaRekening'] }}@endisset"
                            class="input poppins-regular input-bordered w-full" />
                        @error('atasNamaRekening')
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
