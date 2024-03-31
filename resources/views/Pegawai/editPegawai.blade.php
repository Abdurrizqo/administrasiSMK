@extends('layouts.layout')
@section('content')
    <div class="w-full p-10 bg-gray-100">

        @if (session('error'))
            <div role="alert" class="alert alert-error mb-10 text-white font-medium">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <span class="text-sm border border-gray-300 inline-block breadcrumbs bg-white px-8 py-3 poppins-medium rounded-full">
            <ul>
                <li><a href="/dashboard/pegawai">Data Pegawai</a></li>
                <li><a href="#">Edit Pegawai</li></a>
            </ul>
        </span>

        <div class="flex justify-center mt-10 mb-20">
            <div class="w-[32rem] bg-white border shadow rounded-md p-10">
                <h1 class="text-center font-bold text-xl">Edit Data Pegawai</h1>
                <h1 class="text-center font-bold text-xl">{{ $pegawai['namaPegawai'] }}</h1>

                <form method="POST" class="mt-6 w-full flex flex-col gap-3">
                    @csrf
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">Nama Lengkap</span>
                        </div>
                        <input required name="namaPegawai" value="{{ $pegawai['namaPegawai'] }}" type="text"
                            placeholder="nama lengkap" class="input input-bordered w-full" />
                        @error('namaPegawai')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">NIP Pegawai</span>
                        </div>
                        <input required name="nipy" value="{{ $pegawai['nipy'] }}" type="text" placeholder="xxxxx"
                            class="input input-bordered w-full" />
                        @error('nipy')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-semibold">STATUS</span>
                        </div>
                        <select required name="status" class="select select-bordered flex-1">
                            <option @if ($pegawai['status'] == 'GURU') selected @endif value="GURU">GURU</option>
                            <option @if ($pegawai['status'] == 'TU') selected @endif value="TU">TU</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <div class="mt-10 w-full flex justify-end">
                        <button class="btn btn-neutral w-40" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
