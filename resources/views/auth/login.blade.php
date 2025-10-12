@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen w-full bg-gradient-to-br from-white to-[#efe3c2] flex items-center justify-center p-4 sm:p-6 lg:p-8">

    <main class="w-full max-w-6xl mx-auto flex flex-col lg:flex-row gap-8 lg:gap-16">

        {{-- Left Column: Vertically centered image placeholder --}}
        <div class="hidden lg:flex w-full lg:w-1/2 items-center justify-center">
            <img src="{{ asset('amico.svg') }}" alt="Login Illustration" class="w-full h-auto max-w-lg">
        </div>

        {{-- Right Column: Login Form --}}
        <div class="w-full lg:w-1/2 flex justify-center items-center">
            <div class="w-full max-w-lg">
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl lg:text-5xl font-semibold text-[#123524]">
                        LOGIN
                    </h1>
                    <hr class="mt-4 mb-10 border-black/80">
                </div>

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
                        <strong class="font-bold">Oops!</strong>
                        <ul class="mt-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-2xl lg:text-3xl font-semibold text-[#123524] mb-2">
                            Email
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="you@example.com"
                            value="{{ old('email') }}"
                            class="w-full h-16 px-4 rounded-lg bg-white border border-[#3e7b27] focus:ring-2 focus:ring-[#3e7b27] focus:border-[#3e7b27] transition"
                            required
                            autofocus
                        >
                    </div>

                    <div>
                        <label for="password" class="block text-2xl lg:text-3xl font-semibold text-[#123524] mb-2">
                            Password
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••••••"
                            class="w-full h-16 px-4 rounded-lg bg-white border border-[#3e7b27] focus:ring-2 focus:ring-[#3e7b27] focus:border-[#3e7b27] transition"
                            required
                        >
                    </div>

                    <div class="text-right">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-lg text-black hover:text-[#3e7b27] hover:underline transition">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    <button
                        type="submit"
                        class="w-full h-16 flex items-center justify-center rounded-lg bg-[#3e7b27] text-white text-3xl lg:text-4xl font-semibold hover:bg-opacity-90 transition shadow-lg"
                    >
                        LOGIN
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-xl text-black">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-semibold text-[#3e7b27] hover:underline">
                            Daftar
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
