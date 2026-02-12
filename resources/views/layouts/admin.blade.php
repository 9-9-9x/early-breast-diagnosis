@extends('layouts.app')

@section('content')
<div
    class="min-h-screen w-full bg-gradient-to-br from-white to-[#efe3c2]"
    x-data="{ sidebarOpen: window.innerWidth >= 1024 }"
    @resize.window="sidebarOpen = window.innerWidth >= 1024"
>

    <x-sidebar />

    <div
        class="transition-all duration-300"
        :class="{ 'lg:ml-80': sidebarOpen }"
    >
        <header class="p-6 lg:p-8">
            <div class="flex justify-between items-center">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 bg-white rounded-md shadow-lg text-[#123524]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h8"></path>
                    </svg>
                </button>

                <div class="relative" x-data="{ profileOpen: false }">
                    <button @click="profileOpen = !profileOpen" class="flex items-center gap-x-4 cursor-pointer focus:outline-none px-4 py-2 rounded-lg hover:bg-black/5 transition-colors">
                        <div class="text-right">
                            <p class="text-xl font-medium text-black">{{ auth()->user()->name }}</p>
                            <p class="text-lg font-light text-[#123524]">Admin</p>
                        </div>
                        <img src="{{ asset('profile.png') }}" alt="Logo Puskesmas" class="w-15 h-15 object-cover">
                        <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{ 'rotate-180': profileOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="profileOpen" @click.outside="profileOpen = false" x-transition
                         class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-black/30 py-2 z-50">
                        <a href="{{ route('pengaturan.edit') }}" class="flex items-center gap-x-3 px-6 py-4 text-xl text-[#123524] hover:bg-green-50 transition-colors font-semibold">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Pengaturan
                        </a>
                        <hr class="my-1 border-black/10">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-x-3 w-full px-6 py-4 text-xl text-red-600 hover:bg-red-50 transition-colors font-semibold">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 17L21 12M21 12L16 7M21 12L7 12M12 17L10.75 17C7.40279 17 4.75 14.3472 4.75 11C4.75 7.65279 7.40279 5 10.75 5L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="px-6 lg:px-8 pb-6 lg:pb-8">
            @yield('admin_content')
        </main>
    </div>
</div>
@endsection
