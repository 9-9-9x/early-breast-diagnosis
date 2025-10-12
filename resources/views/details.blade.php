{{--
    NOTE:
    - This component is designed to be full-screen (100vh) without page scroll.
    - The form content area will scroll internally if the viewport is too short.
    - This layout uses Flexbox to create a fixed header and footer within the main card.
--}}

@php
    // To keep the code DRY, we can define common classes here.
    $labelClasses = 'block text-base font-medium text-gray-800';
    $inputClasses = 'mt-1 block w-full rounded-md border-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 h-12 px-3';
    $requiredMark = '<span class="text-red-600">*</span>';
@endphp

{{-- Main full-screen container --}}
<div class="h-screen w-full bg-gradient-to-tr from-white to-[#efe3c2] p-4 sm:p-6 lg:p-8 flex flex-col overflow-hidden">

    {{-- Main content card, structured to fill the available height --}}
    <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-lg flex flex-col flex-1 w-full h-full overflow-hidden">

        {{-- Card Header: Title --}}
        <div class="flex-shrink-0 p-6 sm:p-8 pb-4">
            <h1 class="text-2xl md:text-3xl font-semibold text-center text-black">
                Identitas Diri
            </h1>
            <hr class="mt-6 border-black/30">
        </div>

        {{-- Form Body: Takes up remaining space and handles scrolling --}}
        <form action="#" method="POST" class="flex flex-col flex-1 overflow-hidden">

            {{-- Scrollable content area for all the form fields --}}
            <div class="flex-1 overflow-y-auto px-6 sm:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-8">

                    {{-- Column 1 --}}
                    <div class="space-y-8">
                        {{-- Nama --}}
                        <div>
                            <label for="nama" class="{{ $labelClasses }}">Nama {!! $requiredMark !!}</label>
                            <input type="text" id="nama" name="nama" class="{{ $inputClasses }}" placeholder="Masukkan nama lengkap">
                        </div>

                        {{-- Umur --}}
                        <div>
                            <label for="umur" class="{{ $labelClasses }}">Umur {!! $requiredMark !!}</label>
                            <input type="number" id="umur" name="umur" class="{{ $inputClasses }}" placeholder="Contoh: 25">
                        </div>

                        {{-- Suku Bangsa --}}
                        <div>
                            <label for="suku_bangsa" class="{{ $labelClasses }}">Suku Bangsa</label>
                            <div class="relative">
                                <select id="suku_bangsa" name="suku_bangsa" class="{{ $inputClasses }} appearance-none">
                                    <option disabled selected>Pilih suku bangsa</option>
                                    <option>Jawa</option>
                                    <option>Sunda</option>
                                    <option>Madura</option>
                                    <option>Lainnya</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Agama --}}
                        <div>
                            <label for="agama" class="{{ $labelClasses }}">Agama {!! $requiredMark !!}</label>
                             <div class="relative">
                                <select id="agama" name="agama" class="{{ $inputClasses }} appearance-none">
                                    <option disabled selected>Pilih agama</option>
                                    <option>Islam</option>
                                    <option>Kristen</option>
                                    <option>Katolik</option>
                                    <option>Hindu</option>
                                    <option>Budha</option>
                                    <option>Konghucu</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>

                        {{-- BB & TB --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="bb" class="{{ $labelClasses }}">BB (kg) {!! $requiredMark !!}</label>
                                <input type="number" id="bb" name="bb" class="{{ $inputClasses }}" placeholder="Contoh: 55">
                            </div>
                            <div>
                                <label for="tb" class="{{ $labelClasses }}">TB (cm) {!! $requiredMark !!}</label>
                                <input type="number" id="tb" name="tb" class="{{ $inputClasses }}" placeholder="Contoh: 160">
                            </div>
                        </div>

                         {{-- Jumlah Anak Kandung --}}
                        <div>
                            <label for="jumlah_anak" class="{{ $labelClasses }}">Jumlah Anak Kandung {!! $requiredMark !!}</label>
                            <input type="number" id="jumlah_anak" name="jumlah_anak" class="{{ $inputClasses }}" placeholder="Contoh: 2">
                        </div>
                    </div>

                    {{-- Column 2 --}}
                    <div class="space-y-8">
                        {{-- Nomor Telepon --}}
                        <div>
                            <label for="telepon" class="{{ $labelClasses }}">Nomor Telepon {!! $requiredMark !!}</label>
                            <input type="tel" id="telepon" name="telepon" class="{{ $inputClasses }}" placeholder="081234567890">
                        </div>

                        {{-- Alamat, RT, RW --}}
                        <div class="grid grid-cols-1 sm:grid-cols-5 gap-4">
                            <div class="sm:col-span-3">
                                <label for="alamat" class="{{ $labelClasses }}">Alamat {!! $requiredMark !!}</label>
                                <input type="text" id="alamat" name="alamat" class="{{ $inputClasses }}" placeholder="Nama jalan / dusun">
                            </div>
                            <div>
                                <label for="rt" class="{{ $labelClasses }}">RT {!! $requiredMark !!}</label>
                                <input type="text" id="rt" name="rt" class="{{ $inputClasses }}" placeholder="001">
                            </div>
                            <div>
                                <label for="rw" class="{{ $labelClasses }}">RW {!! $requiredMark !!}</label>
                                <input type="text" id="rw" name="rw" class="{{ $inputClasses }}" placeholder="002">
                            </div>
                        </div>

                        {{-- Desa/Kelurahan --}}
                        <div>
                            <label for="desa" class="{{ $labelClasses }}">Desa/Kelurahan {!! $requiredMark !!}</label>
                            <input type="text" id="desa" name="desa" class="{{ $inputClasses }}" placeholder="Masukkan nama desa/kelurahan">
                        </div>

                        {{-- Pendidikan Terakhir --}}
                        <div>
                            <label for="pendidikan" class="{{ $labelClasses }}">Pendidikan Terakhir {!! $requiredMark !!}</label>
                            <div class="relative">
                                <select id="pendidikan" name="pendidikan" class="{{ $inputClasses }} appearance-none">
                                    <option disabled selected>Pilih pendidikan</option>
                                    <option>SD</option>
                                    <option>SMP</option>
                                    <option>SMA/SMK</option>
                                    <option>D3</option>
                                    <option>S1</option>
                                    <option>S2</option>
                                    <option>S3</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Pekerjaan Pasien --}}
                        <div>
                            <label for="pekerjaan_pasien" class="{{ $labelClasses }}">Pekerjaan Pasien {!! $requiredMark !!}</label>
                            <input type="text" id="pekerjaan_pasien" name="pekerjaan_pasien" class="{{ $inputClasses }}" placeholder="Contoh: Ibu Rumah Tangga">
                        </div>

                        {{-- Pekerjaan Suami --}}
                        <div>
                            <label for="pekerjaan_suami" class="{{ $labelClasses }}">Pekerjaan Suami {!! $requiredMark !!}</label>
                            <input type="text" id="pekerjaan_suami" name="pekerjaan_suami" class="{{ $inputClasses }}" placeholder="Contoh: Wiraswasta">
                        </div>

                        {{-- Perkawinan Pasangan --}}
                        <div>
                            <label for="perkawinan" class="{{ $labelClasses }}">Perkawinan Pasangan {!! $requiredMark !!}</label>
                             <input type="text" id="perkawinan" name="perkawinan" class="{{ $inputClasses }}" placeholder="Contoh: Menikah">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Footer: Action Buttons --}}
            <div class="flex-shrink-0 p-6 sm:p-8 pt-4 mt-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row justify-end items-center gap-4">
                    <button type="button" class="w-full sm:w-auto px-10 py-3 rounded-lg border border-[#3e7b27] text-black font-semibold text-lg hover:bg-gray-100 transition duration-200">
                        BATAL
                    </button>
                    <button type="submit" class="w-full sm:w-auto px-10 py-3 rounded-lg bg-[#3e7b27] text-white font-semibold text-lg hover:bg-opacity-90 transition duration-200">
                        SIMPAN
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
