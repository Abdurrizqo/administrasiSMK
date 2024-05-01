@extends('layouts.layoutPegawai')
@section('content')
    <div class="min-h-[100vh] pt-28 p-6">
        <span class="text-sm border border-gray-300 inline-block breadcrumbs bg-white px-8 py-3 poppins-medium rounded-full">
            <ul>
                <li><a href="/home">Home</a></li>
                <li><a href="#">Ganti Password</li></a>
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
                <h1 class="text-center font-bold text-xl">Ganti Password</h1>

                <form method="POST" class="mt-6 w-full flex flex-col gap-3">
                    @csrf
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text text-neutral font-semibold">Username</span>
                        </div>
                        <input name="username" type="text" placeholder="username" class="input input-bordered w-full" />
                        @error('username')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text text-neutral font-semibold">Password</span>
                        </div>
                        <input name="password" type="password" placeholder="password" class="input input-bordered w-full" />
                        @error('password')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text text-neutral font-semibold">Password Baru</span>
                        </div>
                        <input name="passwordBaru" type="password" placeholder="password baru"
                            class="input input-bordered w-full" />
                        @error('passwordBaru')
                            <p class="text-xs text-red-400">*{{ $message }}</p>
                        @enderror
                    </label>

                    <div class="w-full flex justify-end mt-6">
                        <input type="submit" value="Login"
                            class="rounded-lg bg-gray-800 py-[5px] text-white w-32 cursor-pointer" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
