<x-layouts.layout title="Administração">

    <div class="m-4">
        <x-profile-photo-menu h1="Administração" />

        <main class="p-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('members.index') }}"
                    class="flex items-center p-4 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                    <i class="fa-solid fa-user-tie text-2xl text-primary mr-3"></i>
                    <span class="font-medium text-gray-700">Associados</span>
                </a>
                <a href="{{ route('dependents.index') }}"
                    class="flex items-center p-4 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                    <i class="fa-solid fa-users text-2xl text-primary mr-3"></i>
                    <span class="font-medium text-gray-700">Dependentes</span>
                </a>
                <a href="{{ route('users.index') }}"
                    class="flex items-center p-4 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                    <i class="fa-solid fa-users-gear text-2xl text-primary mr-3"></i>
                    <span class="font-medium text-gray-700">Usuários</span>
                </a>
                <a href="{{ route('cards.index') }}"
                    class="flex items-center p-4 bg-white rounded-lg shadow hover:bg-gray-100 transition">
                    <i class="fa-solid fa-id-card text-2xl text-primary mr-3"></i>
                    <span class="font-medium text-gray-700">Carteirinhas</span>
                </a>
            </div>

            <x-menu-mobile menuTitle="Página Inicial" />
        </main>
</x-layouts.layout>
