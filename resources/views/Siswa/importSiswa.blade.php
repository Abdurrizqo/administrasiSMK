@extends('layouts.layout')
@section('content')
    <div class="w-full">
        <span class="text-sm border border-gray-300 inline-block breadcrumbs bg-white px-8 py-3 poppins-medium rounded-full">
            <ul>
                <li><a href="/dashboard/siswa">Dashboard</a></li>
                <li><a href="#">Import Data Siswa</li></a>
            </ul>
        </span>

        <div class="flex justify-center mt-10 mb-10">
            <div class="w-[24rem] md:w-[28rem] lg:w-[36rem] bg-white border shadow rounded-md p-10">
                <h1 class="text-center font-bold text-xl">Import Data Siswa</h1>

                <form method="POST" class="mt-6 w-full flex flex-col gap-3" enctype="multipart/form-data">
                    @csrf

                    <label class="form-control w-full">
                        <input name="dokumen" type="file" class="file-input file-input-bordered w-full" />
                        @error('dokumen')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <div class="mt-10 w-full flex justify-end col-span-2">
                        <button class="btn btn-neutral w-40">Simpan</button>
                    </div>
                </form>

                <div class="text-sm text-red-500 mt-10 flex flex-col gap-2">
                    <p>*Download template excel <a target="_blank" class="hover:underline hover:underline-offset-2" href="{{ asset('dokumen/template_import.xlsx') }}">Disini</a>.</p>
                    <p>*Isi mulai dari baris kedua dan seterusnya, jangan ubah template pada baris pertama</p>
                    <p>*Gunakan Id Jurusan pada menu Program Keahlian / Kompetensi Keahlian</p>
                    <p>*Pada kolom hubungan_keluarga isikan dengan nilai 'Ayah', 'Ibu', 'Kakak', 'Paman', 'Lainnya'</p>
                    <p>*Setelah selesai lakukan pengisian form dengan mengupload file tersebut</p>
                </div>
            </div>
        </div>

        @if (session('error'))
            @foreach (session('error') as $errorMessage)
                <div role="alert" class="alert alert-error mb-2 text-white">
                    <ul>
                        <li>{{ $errorMessage }}</li>
                    </ul>
                </div>
            @endforeach
        @endif

        @if (session('success'))
            <div role="alert" class="alert alert-success mb-2 text-white">
                <span>{{ session('success') }}</span>
            </div>
        @endif
    </div>
@endsection
