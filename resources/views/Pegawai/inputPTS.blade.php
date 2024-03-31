<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')

    <title>Laravel</title>
</head>

<body>
    <nav class="w-full h-20 justify-center flex flex-col bg-white border-b shadow-md py-4 px-10 fixed z-20">
        <div class="flex justify-between items-center">
            <h1 class="font-bold text-lg">INPUT NILAI PTS</h1>
            <h1 class="font-bold text-lg">{{ $kelas['namaKelas'] }}</h1>
            <p class="font-bold text-lg">{{ $kelas['wali']['namaPegawai'] }}</p>
        </div>
    </nav>
    <div class="w-full h-28"></div>

    <div class="mb-10 flex justify-center">
        {{ $listSiswa->links() }}
    </div>

    <div class="flex justify-center">
        <div class="w-[68rem] flex flex-col justify-center gap-y-16">
            @foreach ($listSiswa as $index => $item)
                <div class="card border shadow-md rounded-md">
                    <div class="p-6">
                        <div class="w-full">
                            <h1 class="text-xl font-bold">{{ $item['dataSiswa']['namaSiswa'] }}</h1>
                        </div>

                        <div class="divider"></div>

                        <div class="flex gap-4">
                            <div class="w-60 flex flex-col gap-2 justify-center items-center">
                                <div
                                    class="w-full flex flex-col gap-2 justify-center items-center p-4 rounded-md border shadow">
                                    <p class="font-semibold">Nilai Akademik</p>
                                    <p>{{ $item['nilaiAkademik'] }}</p>
                                </div>

                                <div
                                    class="w-full flex flex-col gap-2 justify-center items-center p-4 rounded-md border shadow">
                                    <p class="font-semibold">Terbilang</p>
                                    <p>{{ $item['terbilangNilaiAkademik'] }}</p>
                                </div>
                            </div>

                            <div class="w-60 flex flex-col gap-2 justify-center items-center">
                                <div
                                    class="w-full flex flex-col gap-2 justify-center items-center p-4 rounded-md border shadow">
                                    <p class="font-semibold">Nilai Keterampilan</p>
                                    <p>{{ $item['nilaiKeterampilan'] }}</p>
                                </div>

                                <div
                                    class="w-full flex flex-col gap-2 justify-center items-center p-4 rounded-md border shadow">
                                    <p class="font-semibold">Terbilang</p>
                                    <p>{{ $item['terbilangNilaiKeterampilan'] }}</p>
                                </div>
                            </div>

                            <div class="flex-1 flex flex-col gap-2 jus items-center p-4 rounded-md border shadow">
                                <p class="font-semibold">Keterangan</p>
                                <p>{{ $item['keterangan'] }}</p>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <form class="w-full dynamic-form" method="POST">
                            @csrf
                            <input type="hidden" name="idRekapPts" value="{{ $item['idRekapPts'] }}">
                            <div class="flex gap-4">
                                <div class="w-60 flex flex-col gap-2 justify-center items-center">
                                    <label class="form-control w-full">
                                        <div class="label">
                                            <span class="label-text font-semibold">Nilai Akademik</span>
                                        </div>
                                        <input required name="nilaiAkademik" id="inputNilaiAkademik{{ $index }}"
                                            type="text" placeholder="0" class="input input-bordered w-full" />
                                        <p class="text-xs text-red-400"></p>
                                    </label>

                                    <label class="form-control w-full">
                                        <div class="label">
                                            <span class="label-text font-semibold">Terbilang</span>
                                        </div>
                                        <input required name="terbilangNilaiAkademik"
                                            id="inputTerbilangNilaiAkademik{{ $index }} disabled type="text"
                                            placeholder="Nol" class="input input-bordered w-full" />
                                    </label>
                                </div>

                                <div class="w-60 flex flex-col gap-2 justify-center items-center">
                                    <label class="form-control w-full">
                                        <div class="label">
                                            <span class="label-text font-semibold">Nilai Keterampilan</span>
                                        </div>
                                        <input required name="nilaiKeterampilan"
                                            id="inputNilaiKeterampilan{{ $index }}" type="text"
                                            placeholder="0" class="input input-bordered w-full" />
                                        <p class="text-xs text-red-400"></p>
                                    </label>

                                    <label class="form-control w-full">
                                        <div class="label">
                                            <span class="label-text font-semibold">Terbilang</span>
                                        </div>
                                        <input required name="terbilangNilaiKeterampilan"
                                            id="inputTerbilangNilaiKeterampilan{{ $index }}" disabled
                                            type="text" placeholder="Nol" class="input input-bordered w-full" />
                                    </label>
                                </div>

                                <div class="flex-1 flex flex-col gap-2 jus items-center rounded-md border shadow">
                                    <textarea class="w-full h-full border outline-none rounded-md p-4" name="keterangan" placeholder="keterangan siswa"></textarea>
                                </div>

                            </div>

                            <button class="btn btn-neutral w-full mt-12">Simpan</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="my-10 flex justify-center">
        {{ $listSiswa->links() }}
    </div>

    <script>
        const dynamicForms = document.querySelectorAll('.dynamic-form');

        dynamicForms.forEach((form, index) => {
            const nilaiAkademikInput = form.querySelector(`#inputNilaiAkademik${index}`);
            const terbilangNilaiAkademikInput = form.querySelector(`#inputTerbilangNilaiAkademik${index}`);
        });
    </script>

</body>

</html>
