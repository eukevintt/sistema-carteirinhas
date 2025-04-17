<header class="md:hidden flex items-center justify-between px-4 py-3 bg-white border-b border-gray-200">
    <button @click="openMenu = true" class="p-2 text-gray-600 focus:outline-none" aria-label="Abrir menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <h1 class="text-lg font-semibold text-gray-700">Carteirinhas</h1>

    <a href="{{ route('profile.view') }}">
        <div class="flex items-center space-x-2">
            <img src="{{ route('users.photo', ['user' => auth()->user()->id]) }}"
                class="w-8 h-8 rounded-full object-cover" alt="Foto do usuário">

            <p class="text-sm font-medium">{{ Auth::user()->nickname }}</p>

            <i class="fa-solid fa-chevron-right text-sm"></i>
        </div>
    </a>

</header>
