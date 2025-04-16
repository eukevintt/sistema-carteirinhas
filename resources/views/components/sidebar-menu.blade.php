<!-- Sidebar fixo (Desktop) -->
<aside class="hidden md:flex flex-col w-64 bg-white border-r border-gray-200">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.png') }}" class="w-full" alt="">
        </div>
    </div>
    <nav class="mt-6">
        <ul>
            <li class="px-6 py-2 bg-gray-100 font-medium">Dashboard</li>
            <li class="px-6 py-2 hover:bg-gray-50 cursor-pointer">Associados</li>
            <li class="px-6 py-2 hover:bg-gray-50 cursor-pointer">Dependentes</li>
            <li class="px-6 py-2 hover:bg-gray-50 cursor-pointer">Administração</li>
        </ul>
    </nav>
</aside>

<!-- Sidebar Mobile (overlay) -->
<div x-show="openMenu" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 -translate-x-full" class="fixed inset-0 z-50 flex md:hidden"
    style="display: none;">

    <!-- Fundo escuro -->
    <div class="fixed inset-0 bg-black opacity-50" @click="openMenu = false"></div>

    <!-- Sidebar mobile -->
    <aside class="relative z-10 w-64 bg-white border-r border-gray-200 shadow-md" x-show="openMenu"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logo.png') }}" alt="">
            </div>
            <button @click="openMenu = false" class="p-2 focus:outline-none">
                <svg class="w-6 h-6 text-primary cursor-pointer" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="mt-6">
            <ul>
                <li class="px-6 py-2 bg-gray-100 font-medium">Dashboard</li>
                <li class="px-6 py-2 hover:bg-gray-50 cursor-pointer">Associados</li>
                <li class="px-6 py-2 hover:bg-gray-50 cursor-pointer">Dependentes</li>
                <li class="px-6 py-2 hover:bg-gray-50 cursor-pointer">Administração</li>
            </ul>
        </nav>
    </aside>
</div>
