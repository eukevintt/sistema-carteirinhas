<!-- Sidebar fixo (Desktop) -->
<aside class="hidden md:flex flex-col w-64 bg-white border-r border-gray-200">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-2">
            <a href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" class="w-full" alt=""></a>
        </div>
    </div>
    <nav class="mt-6">
        <ul>
            <li class="px-6 py-2 bg-gray-100 font-medium">Dashboard</li>
            <li class="px-6 py-2 hover:bg-gray-50 cursor-pointer">Associados</li>
            <li class="px-6 py-2 hover:bg-gray-50 cursor-pointer">Dependentes</li>
            <li class="px-6 py-2 hover:bg-gray-50 cursor-pointer">Administração</li>
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2 hover:bg-gray-50 cursor-pointer">SAIR</button>
            </form>
        </ul>
    </nav>
</aside>
