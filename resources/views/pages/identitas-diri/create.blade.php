@extends('layouts.app')

@section('title', 'Identitas Diri')

@section('content')

@php
    $labelClasses = 'block text-lg font-medium text-gray-800';
    $inputClasses = 'mt-2 block w-full rounded-lg border-gray-400 shadow-sm focus:ring-[#3e7b27] focus:border-[#3e7b27] h-14 px-4 text-xl';
    $requiredMark = '<span class="text-red-600">*</span>';
@endphp

<div class="min-h-screen w-full bg-gradient-to-br from-white to-[#efe3c2] p-4 sm:p-6 lg:p-8 flex flex-col items-center">

    <form method="POST" action="{{ route('identitas-diri.store') }}" id="identitas-form" class="w-full max-w-7xl">
        @csrf

        <div class="w-full mx-auto bg-white rounded-xl shadow-lg overflow-hidden mb-8">

            <div class="p-6 sm:p-8 border-b border-black/30">
                <h1 class="text-2xl md:text-3xl font-semibold text-center text-black">
                    Identitas Diri
                </h1>

                {{-- Display validation errors --}}
                @if ($errors->any())
                    <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Display success messages --}}
                @if (session('success'))
                    <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

            </div>

            <div class="p-6 sm:p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-8">

                    {{-- Left Column --}}
                    <div class="space-y-8">
                        <div>
                            <label for="nama" class="{{ $labelClasses }}">Nama {!! $requiredMark !!}</label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="{{ $inputClasses }}" placeholder="Masukkan nama lengkap">
                        </div>

                        <div>
                            <label for="umur" class="{{ $labelClasses }}">Umur {!! $requiredMark !!}</label>
                            <input type="number" id="umur" name="umur" value="{{ old('umur') }}" class="{{ $inputClasses }}" placeholder="Contoh: 25">
                        </div>

                        <div>
                            <label for="suku_bangsa" class="{{ $labelClasses }}">Suku Bangsa</label>
                            <div class="relative">
                                <select id="suku_bangsa" name="suku_bangsa" class="{{ $inputClasses }} appearance-none">
                                    <option value="" disabled selected>Pilih suku bangsa</option>
                                    <option value="Jawa" @selected(old('suku_bangsa') == 'Jawa')>Jawa</option>
                                    <option value="Sunda" @selected(old('suku_bangsa') == 'Sunda')>Sunda</option>
                                    <option value="Madura" @selected(old('suku_bangsa') == 'Madura')>Madura</option>
                                    <option value="Lainnya" @selected(old('suku_bangsa') == 'Lainnya')>Lainnya</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="agama" class="{{ $labelClasses }}">Agama {!! $requiredMark !!}</label>
                             <div class="relative">
                                <select id="agama" name="agama" class="{{ $inputClasses }} appearance-none">
                                    <option value="" disabled selected>Pilih agama</option>
                                    <option value="Islam" @selected(old('agama') == 'Islam')>Islam</option>
                                    <option value="Kristen" @selected(old('agama') == 'Kristen')>Kristen</option>
                                    <option value="Katolik" @selected(old('agama') == 'Katolik')>Katolik</option>
                                    <option value="Hindu" @selected(old('agama') == 'Hindu')>Hindu</option>
                                    <option value="Budha" @selected(old('agama') == 'Budha')>Budha</option>
                                    <option value="Konghucu" @selected(old('agama') == 'Konghucu')>Konghucu</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="bb" class="{{ $labelClasses }}">BB (kg) {!! $requiredMark !!}</label>
                                <input type="number" id="bb" name="bb" value="{{ old('bb') }}" class="{{ $inputClasses }}" placeholder="Contoh: 55">
                            </div>
                            <div>
                                <label for="tb" class="{{ $labelClasses }}">TB (cm) {!! $requiredMark !!}</label>
                                <input type="number" id="tb" name="tb" value="{{ old('tb') }}" class="{{ $inputClasses }}" placeholder="Contoh: 160">
                            </div>
                        </div>

                        <div>
                            <label for="jumlah_anak" class="{{ $labelClasses }}">Jumlah Anak Kandung {!! $requiredMark !!}</label>
                            <input type="number" id="jumlah_anak" name="jumlah_anak" value="{{ old('jumlah_anak') }}" class="{{ $inputClasses }}" placeholder="Contoh: 2">
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="space-y-8">
                        <div>
                            <label for="telepon" class="{{ $labelClasses }}">Nomor Telepon {!! $requiredMark !!}</label>
                            <input type="tel" id="telepon" name="telepon" value="{{ old('telepon') }}" class="{{ $inputClasses }}" placeholder="081234567890">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-5 gap-4">
                            <div class="sm:col-span-3">
                                <label for="alamat" class="{{ $labelClasses }}">Alamat {!! $requiredMark !!}</label>
                                <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" class="{{ $inputClasses }}" placeholder="Nama jalan / dusun">
                            </div>
                            <div>
                                <label for="rt" class="{{ $labelClasses }}">RT {!! $requiredMark !!}</label>
                                <input type="text" id="rt" name="rt" value="{{ old('rt') }}" class="{{ $inputClasses }}" placeholder="001">
                            </div>
                            <div>
                                <label for="rw" class="{{ $labelClasses }}">RW {!! $requiredMark !!}</label>
                                <input type="text" id="rw" name="rw" value="{{ old('rw') }}" class="{{ $inputClasses }}" placeholder="002">
                            </div>
                        </div>

                        <div>
                            <label for="desa" class="{{ $labelClasses }}">Desa/Kelurahan {!! $requiredMark !!}</label>
                            <input type="text" id="desa" name="desa" value="{{ old('desa') }}" class="{{ $inputClasses }}" placeholder="Masukkan nama desa/kelurahan">
                        </div>

                        <div>
                            <label for="pendidikan" class="{{ $labelClasses }}">Pendidikan Terakhir {!! $requiredMark !!}</label>
                            <div class="relative">
                                <select id="pendidikan" name="pendidikan" class="{{ $inputClasses }} appearance-none">
                                    <option value="" disabled selected>Pilih pendidikan</option>
                                    <option value="SD" @selected(old('pendidikan') == 'SD')>SD</option>
                                    <option value="SMP" @selected(old('pendidikan') == 'SMP')>SMP</option>
                                    <option value="SMA/SMK" @selected(old('pendidikan') == 'SMA/SMK')>SMA/SMK</option>
                                    <option value="D3" @selected(old('pendidikan') == 'D3')>D3</option>
                                    <option value="S1" @selected(old('pendidikan') == 'S1')>S1</option>
                                    <option value="S2" @selected(old('pendidikan') == 'S2')>S2</option>
                                    <option value="S3" @selected(old('pendidikan') == 'S3')>S3</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="pekerjaan_pasien" class="{{ $labelClasses }}">Pekerjaan Pasien {!! $requiredMark !!}</label>
                            <div class="relative">
                                <select id="pekerjaan_pasien" name="pekerjaan_pasien" class="{{ $inputClasses }} appearance-none">
                                    <option value="" disabled selected>Pilih pekerjaan pasien</option>
                                    <option value="Ibu Rumah Tangga" @selected(old('pekerjaan_pasien') == 'Ibu Rumah Tangga')>Ibu Rumah Tangga</option>
                                    <option value="Wiraswasta" @selected(old('pekerjaan_pasien') == 'Wiraswasta')>Wiraswasta</option>
                                    <option value="Pegawai Swasta" @selected(old('pekerjaan_pasien') == 'Pegawai Swasta')>Pegawai Swasta</option>
                                    <option value="PNS" @selected(old('pekerjaan_pasien') == 'PNS')>PNS</option>
                                    <option value="Lainnya" @selected(old('pekerjaan_pasien') == 'Lainnya')>Lainnya</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="pekerjaan_suami" class="{{ $labelClasses }}">Pekerjaan Suami {!! $requiredMark !!}</label>
                            <div class="relative">
                                <select id="pekerjaan_suami" name="pekerjaan_suami" class="{{ $inputClasses }} appearance-none">
                                    <option value="" disabled selected>Pilih pekerjaan suami</option>
                                    <option value="Wiraswasta" @selected(old('pekerjaan_suami') == 'Wiraswasta')>Wiraswasta</option>
                                    <option value="Pegawai Swasta" @selected(old('pekerjaan_suami') == 'Pegawai Swasta')>Pegawai Swasta</option>
                                    <option value="PNS" @selected(old('pekerjaan_suami') == 'PNS')>PNS</option>
                                    <option value="Tidak Ada" @selected(old('pekerjaan_suami') == 'Tidak Ada')>Tidak Ada</option>
                                    <option value="Lainnya" @selected(old('pekerjaan_suami') == 'Lainnya')>Lainnya</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="status_perkawinan" class="{{ $labelClasses }}">Status Perkawinan {!! $requiredMark !!}</label>
                            <div class="relative">
                                <select id="status_perkawinan" name="status_perkawinan" class="{{ $inputClasses }} appearance-none">
                                    <option value="" disabled selected>Pilih status perkawinan</option>
                                    <option value="Menikah" @selected(old('status_perkawinan') == 'Menikah')>Menikah</option>
                                    <option value="Belum Menikah" @selected(old('status_perkawinan') == 'Belum Menikah')>Belum Menikah</option>
                                    <option value="Janda/Duda" @selected(old('status_perkawinan') == 'Janda/Duda')>Janda/Duda</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Action Buttons - Visually outside, but functionally inside the form --}}
        <div class="w-full mx-auto flex flex-col sm:flex-row justify-end items-center gap-4 px-4 sm:px-0">
            <a href="{{-- route('identitas-diri.index') --}}" class="flex items-center justify-center w-full sm:w-48 h-16 rounded-xl border border-[#3e7b27] text-black font-semibold text-2xl hover:bg-gray-100 transition shadow-md">
                BATAL
            </a>
            <button type="submit" class="w-full sm:w-48 h-16 rounded-xl bg-[#3e7b27] text-white font-semibold text-2xl hover:bg-opacity-90 transition shadow-md">
                SIMPAN
            </button>
        </div>

    </form>

</div>
@endsection
