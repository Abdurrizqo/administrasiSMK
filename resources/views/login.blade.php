<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')

    <title>SIAS</title>
</head>

<div class="flex w-full h-screen justify-center items-center bg-gray poppins-regular">
    <div class="w-[72%] lg:w-[58rem] lg:h-[28rem] lg:items-center lg:justify-center lg:flex gap-10 bg-white px-12 py-16 rounded-lg border-2">
        <div class="mb-24 md:flex-1">
            <h1 class="poppins-semibold text-2xl">Login Sistem Informasi Manajemen Administrasi</h1>
            <p class="poppins-medium mt-3 text-gray-600 text-lg">SMK Muhammadiyah Sangatta Utara</p>
        </div>

        <form method="POST" class="flex flex-col gap-8 lg:w-[20rem]">
            @csrf
            <div>
                <label class="input input-bordered flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                        class="w-4 h-4 opacity-70">
                        <path
                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                    </svg>
                    <input type="text" class="grow" placeholder="Username" name="username"
                        value="{{ old('username') }}" />

                </label>
                @error('username')
                    <p class="text-xs text-red-400">*{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="input input-bordered flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                        class="w-4 h-4 opacity-70">
                        <path fill-rule="evenodd"
                            d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
                            clip-rule="evenodd" />
                    </svg>
                    <input type="password" class="grow" placeholder="password" name="password" />

                </label>
                @error('password')
                    <p class="text-xs text-red-400">*{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="rounded-lg bg-gray-700 text-white py-2 text-lg poppins-medium btn-click">Login</button>
        </form>
    </div>
</div>

</html>
