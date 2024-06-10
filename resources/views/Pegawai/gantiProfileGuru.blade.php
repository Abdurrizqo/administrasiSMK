@extends('layouts.layoutPegawai')
@section('content')
    <div class="min-h-[100vh] p-6">
        <span class="text-sm border border-gray-300 inline-block breadcrumbs bg-white px-8 py-3 poppins-medium rounded-full">
            <ul>
                <li><a href="/dashboard">dashboard</a></li>
                <li><a>Ganti Foto Profil</li></a>
            </ul>
        </span>

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-8 text-white font-medium">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if (session('success'))
            <div role="alert" class="alert alert-success mb-8 text-white font-medium">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex justify-center mt-10 mb-20">
            <div class="w-full lg:w-[28rem] bg-white border shadow rounded-md p-10">
                <form method="POST" class="w-full flex flex-col gap-3" enctype="multipart/form-data">
                    @csrf

                    <div class="flex items-center justify-center mb-10">
                        @auth
                            <div style="background-image: url('{{ Storage::url(Auth::user()->photoProfile) }}');"
                                class="w-28 h-28 rounded-full bg-gray-200 bg-center bg-cover"></div>
                        @endauth
                    </div>

                    <div>
                        <input type="file" accept="image/*" name="photoProfile"
                            class="file-input file-input-bordered w-full" />

                        @error('photoProfile')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full flex justify-end mt-6">
                        <input type="submit" value="Simpan"
                            class="rounded-lg bg-gray-800 py-[5px] text-white w-32 cursor-pointer" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
