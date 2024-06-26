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
                <li><a href="#">Edit Profil Sekolah</li></a>
            </ul>
        </span>

        <div class="flex justify-center mt-10 mb-10">
            <div class="w-[30rem] md:w-[34rem] lg:w-[40rem] bg-white rounded-lg border p-10">
                <h1 class="text-center poppins-bold text-lg md:text-xl mb-8">EDIT PROFIL SEKOLAH</h1>

                <form method="POST" class="grid grid-cols-2 gap-x-5 gap-y-0 text-sm md:text-base">
                    @csrf
                    <div>
                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">Nama Sekolah</span>
                            </div>
                            <input required name="namaSekolah" type="text"
                                value="@isset($profile){{ $profile['namaSekolah'] }}@endisset"
                                placeholder="nama sekolah" class="input poppins-regular input-bordered w-full" />
                            @error('namaSekolah')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">NPSN</span>
                            </div>
                            <input required name="npsn" type="text"
                                value="@isset($profile){{ $profile['npsn'] }}@endisset"
                                placeholder="xxxxxx" class="input poppins-regular input-bordered w-full" />
                            @error('npsn')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">Nama Kepala Sekolah</span>
                            </div>
                            <input required name="namaKepalaSekolah" type="text"
                                value="@isset($profile){{ $profile['namaKepalaSekolah'] }}@endisset"
                                placeholder="nama kepala sekolah" class="input poppins-regular input-bordered w-full" />
                            @error('namaKepalaSekolah')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">Semester</span>
                            </div>
                            <select required name="semester" class="select select-bordered flex-1 poppins-regular">
                                @isset($profile)
                                    <option class="poppins-regular" value="{{ $profile['semester'] }}">
                                        {{ $profile['semester'] }}</option>
                                @endisset
                                <option class="poppins-regular" value="GANJIL">GANJIL</option>
                                <option class="poppins-regular" value="GENAP">GENAP</option>
                            </select>
                            @error('semester')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">Lintang</span>
                            </div>
                            <input name="lintang" type="text"
                                value="@isset($profile){{ $profile['lintang'] }}@endisset"
                                placeholder="0.000" class="input poppins-regular input-bordered w-full" />
                            @error('lintang')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>
                    </div>

                    <div>
                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">Tahun Berdiri</span>
                            </div>
                            <input required name="tahunBerdiri" type="number" min="1920" max="2099" step="1"
                                value="@isset($profile){{ $profile['tahunBerdiri'] }}@endisset"
                                placeholder="nama sekolah" class="input poppins-regular input-bordered w-full" />
                            @error('tahunBerdiri')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">NSS</span>
                            </div>
                            <input required name="nss" type="text"
                                value="@isset($profile){{ $profile['nss'] }}@endisset"
                                placeholder="xxxxxx" class="input poppins-regular input-bordered w-full" />
                            @error('nss')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">NIP Kepala Sekolah</span>
                            </div>
                            <input required name="nipKepalaSekolah" type="text"
                                value="@isset($profile){{ $profile['nipKepalaSekolah'] }}@endisset"
                                placeholder="xxxxxx" class="input poppins-regular input-bordered w-full" />
                            @error('nipKepalaSekolah')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">Tahun Ajaran</span>
                            </div>
                            <select required name="tahunAjaran" class="select select-bordered flex-1">
                                @isset($profile)
                                    <option class="poppins-regular" value="{{ $profile['tahunAjaran'] }}">
                                        {{ $profile['tahunAjaran'] }}</option>
                                @endisset
                                @foreach ($tahunAjar as $item)
                                    <option class="poppins-regular" value="{{ $item }}">{{ $item }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tahunAjaran')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full mb-6">
                            <div class="label">
                                <span class="label-text poppins-semibold">Bujur</span>
                            </div>
                            <input name="bujur" type="text"
                                value="@isset($profile){{ $profile['bujur'] }}@endisset"
                                placeholder="0.000" class="input poppins-regular input-bordered w-full" />
                            @error('bujur')
                                <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                            @enderror
                        </label>
                    </div>

                    <div class="w-full col-span-2 mb-6">
                        <div class="label">
                            <span class="label-text poppins-semibold">Alamat</span>
                        </div>

                        <textarea name="alamat" class="border w-full p-3 rounded-lg outline-none h-28 poppins-regular" placeholder="Alamat">
@isset($profile)
{{ $profile['alamat'] }}
@endisset
</textarea>
                        @error('alamat')
                            <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="form-control w-full mb-6 col-span-2">
                        <div class="label">
                            <span class="label-text poppins-semibold">Jenjang Pendidikan</span>
                        </div>
                        <select required name="jenjangPendidikan" class="select select-bordered flex-1 poppins-regular">
                            @isset($profile)
                                <option class="poppins-regular" value="{{ $profile['jenjangPendidikan'] }}">
                                    {{ $profile['jenjangPendidikan'] }}</option>
                            @endisset
                            <option class="poppins-regular" value="TK">TK</option>
                            <option class="poppins-regular" value="SD">SD</option>
                            <option class="poppins-regular" value="SMP">SMP</option>
                            <option class="poppins-regular" value="SMA">SMA</option>
                            <option class="poppins-regular" value="SMK">SMK</option>
                        </select>
                        @error('jenjangPendidikan')
                            <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full mb-6 col-span-2">
                        <div class="label">
                            <span class="label-text poppins-semibold">Email</span>
                        </div>
                        <input required name="email" type="text"
                            value="@isset($profile){{ $profile['email'] }}@endisset"
                            placeholder="example@email.com" class="input poppins-regular input-bordered w-full" />
                        @error('email')
                            <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full mb-6 col-span-2">
                        <div class="label">
                            <span class="label-text poppins-semibold">Nomer Telfon</span>
                        </div>
                        <input required name="nomerTelfon" type="text"
                            value="@isset($profile){{ $profile['nomerTelfon'] }}@endisset"
                            placeholder="000000" class="input poppins-regular input-bordered w-full" />
                        @error('nomerTelfon')
                            <p class="text-xs text-red-400 poppins-regular">*{{ $message }}</p>
                        @enderror
                    </label>

                    <label class="form-control w-full col-span-2">
                        <div class="label">
                            <span class="label-text poppins-semibold">Website</span>
                        </div>
                        <input required name="website" type="text"
                            value="@isset($profile){{ $profile['website'] }}@endisset"
                            placeholder="www.example.com" class="input poppins-regular input-bordered w-full" />
                        @error('website')
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
