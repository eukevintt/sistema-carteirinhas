<div class="fixed bottom-0 left-0 z-50 w-full h-16 bg-primary block md:hidden">
    <div
        class="grid h-full max-w-lg {{ Gate::allows('managers') ? 'grid-cols-4' : 'grid-cols-3' }}  mx-auto font-medium">

        <a href="{{ route('home') }}"
            class="inline-flex flex-col items-center justify-center px-5 {{ request()->routeIs('home') ? 'bg-slate-700' : 'hover:bg-slate-700' }} group">
            <i class="fa fa-home {{ request()->routeIs('home') ? 'text-white' : 'text-gray-200' }} mb-2"></i>
            <span class="text-sm {{ request()->routeIs('home') ? 'text-white' : 'text-gray-200' }} ">Início</span>
        </a>

        @can('managers')
            <a href="{{ route('administration') }}"
                class="inline-flex flex-col items-center justify-center px-5 group {{ request()->routeIs('administration') ? 'bg-slate-700' : 'hover:bg-slate-700' }}">
                <i
                    class="fa fa-user-tie {{ request()->routeIs('administration') ? 'text-white' : 'text-gray-200' }} mb-2"></i>
                <span
                    class="text-sm {{ request()->routeIs('administration') ? 'text-white' : 'text-gray-200' }}">Administração</span>
            </a>
        @endcan

        <a href="{{ route('profile.view') }}"
            class="inline-flex flex-col items-center justify-center px-5 {{ request()->routeIs('profile.*') ? 'bg-slate-700' : 'hover:bg-slate-700' }} group">
            <i
                class="fa fa-circle-user mb-2 {{ request()->routeIs('profile.*') ? 'text-white' : 'text-gray-200' }}"></i>
            <span class="text-sm {{ request()->routeIs('profile.*') ? 'text-white' : 'text-gray-200' }}">Perfil</span>
        </a>

        <form action="{{ route('auth.logout') }}" method="POST" class="h-full w-full">
            @csrf
            <button type="submit"
                class="inline-flex flex-col items-center justify-center w-full h-full px-5 {{ request()->routeIs('auth.logout') ? 'bg-slate-700' : 'hover:bg-slate-700' }} group">
                <i
                    class="fa fa-right-from-bracket mb-2 {{ request()->routeIs('auth.logout') ? 'text-white' : 'text-gray-200' }}"></i>
                <span
                    class="text-sm {{ request()->routeIs('auth.logout') ? 'text-white' : 'text-gray-200' }}">Sair</span>
            </button>
        </form>



    </div>
</div>
