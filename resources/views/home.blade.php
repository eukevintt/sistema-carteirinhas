<x-layouts.layout title="Página Inicial - Sistema Petros">
    <div x-data="{ openMenu: false }" class="min-h-screen flex flex-col md:flex-row">

        <x-sidebar-menu />

        <div class="flex-1 flex flex-col relative">

            <x-menu-mobile />

            <main class="p-6 flex-1">

                <x-profile-photo-menu h1="Sistema de Carteirinhas" />

                <div class="mt-6 flex flex-col items-start space-y-3">
                    <h2 class="text-xl font-semibold">Bem-vindo!</h2>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white text-lg px-6 py-3 rounded-md">
                        Gerar Carteirinha
                    </button>
                </div>

                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('users.index') }}">
                        <div class="bg-white rounded shadow p-4">
                            <p class="text-sm font-medium text-gray-600">Usuários</p>
                            <p class="text-xl font-bold">{{ $totalUsers }}</p>
                        </div>
                    </a>

                    <a href="{{ route('members.index') }}">
                        <div class="bg-white rounded shadow p-4">
                            <p class="text-sm font-medium text-gray-600">Associados</p>
                            <p class="text-xl font-bold">{{ $totalMembers }}</p>
                        </div>
                    </a>

                    <a href="{{ route('dependents.index') }}">
                        <div class="bg-white rounded shadow p-4">
                            <p class="text-sm font-medium text-gray-600">Dependentes</p>
                            <p class="text-xl font-bold">{{ $totalDependents }}</p>
                        </div>
                    </a>

                    <a href="{{ route('cards.index') }}">
                        <div class="bg-white rounded shadow p-4">
                            <p class="text-sm font-medium text-gray-600">Carteirinhas Geradas</p>
                            <p class="text-xl font-bold">{{ $totalMembershipCards }}</p>
                        </div>
                    </a>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-semibold">Últimas Carteirinhas Geradas</h3>
                    <ul class="mt-4 space-y-2 text-gray-700">
                        <li class="flex justify-between">
                            <span>João Silva (Associado)</span>
                            <span>12/04/2024</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Maria Souza (Dependente)</span>
                            <span>10/04/2024</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Carlos Pereira (05/04/2024)</span>
                            <span></span>
                        </li>
                        <li class="flex justify-between">
                            <span>Ana Oliveira (02/04/2024)</span>
                            <span></span>
                        </li>
                    </ul>
                </div>
            </main>
        </div>
    </div>
</x-layouts.layout>
