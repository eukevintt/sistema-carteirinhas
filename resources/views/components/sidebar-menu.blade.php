<!-- Sidebar fixo (Desktop) -->
<aside class="hidden md:flex flex-col w-64 bg-white border-r border-gray-200">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-2">
            <a href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" class="w-full" alt=""></a>
        </div>
    </div>
    <nav class="mt-6">
        <ul>
            <a href="{{ route('home') }}">
                <li class="px-6 py-2 {{ request()->routeIs('home') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50' }}">
                    <i class="fa fa-home mr-2 text-primary"></i>Início
                </li>
            </a>

            @can('managers')
                <a href="{{ route('members.index') }}">
                    <li
                        class="px-6 py-2 cursor-pointer {{ request()->routeIs('members.index') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50' }}">
                        <i class="fa fa-user-tie mr-2 text-primary"></i>Associados
                    </li>
                </a>
                <a href="{{ route('dependents.index') }}">
                    <li
                        class="px-6 py-2 cursor-pointer {{ request()->routeIs('dependents.index') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50' }}">
                        <i class="fa fa-users mr-2 text-primary"></i>Dependentes</li>
                </a>
                <a href="{{ route('users.index') }}">
                    <li
                        class="px-6 py-2 cursor-pointer {{ request()->routeIs('users.index') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50' }}">
                        <i class="fa fa-users-gear mr-2 text-primary"></i>Usuários</li>
                </a>
                <a href="{{ route('cards.index') }}">
                    <li
                        class="px-6 py-2 cursor-pointer {{ request()->routeIs('cards.index') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50' }}">
                        <i class="fa fa-id-card mr-2 text-primary"></i>Carteirinhas</li>
                </a>
            @endcan

            <a href="{{ route('profile.view') }}">
                <li
                    class="px-6 py-2 cursor-pointer {{ request()->routeIs('profile.view') ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50' }}">
                    <i class="fa fa-user mr-2 text-primary"></i>Perfil
                </li>
            </a>
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2 hover:bg-gray-50 cursor-pointer w-full text-start"><i
                        class="fa fa-right-from-bracket mr-2 text-primary"></i>SAIR</button>
            </form>
        </ul>
    </nav>
</aside>
