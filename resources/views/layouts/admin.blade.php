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

                <div class="flex items-center gap-x-4">
                    <div class="text-right">
                        <p class="text-xl font-medium text-black">Ranee Alleyda</p>
                        <p class="text-lg font-light text-gray-700">Admin</p>
                    </div>
                    <img src="https://via.placeholder.com/58" alt="Profile User" class="w-14 h-14 rounded-full object-cover">
                </div>
            </div>
        </header>

        <main class="px-6 lg:px-8 pb-6 lg:pb-8">
            @yield('admin_content')
        </main>
    </div>
</div>
@endsection
