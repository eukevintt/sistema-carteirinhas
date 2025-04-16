<x-layouts.layout title="Página Inicial - Sistema Petros">

    <div x-data="{ openMenu: false }" class="min-h-screen flex flex-col md:flex-row">

        <!-- Componente do Menu -->
        <x-sidebar-menu />

        <!-- Área principal -->
        <div class="flex-1 flex flex-col relative">

            <!-- Cabeçalho Mobile (apenas < md) -->
            <header class="md:hidden flex items-center justify-between px-4 py-3 bg-white border-b border-gray-200">
                <button @click="openMenu = true" class="p-2 text-gray-600 focus:outline-none" aria-label="Abrir menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <h1 class="text-lg font-semibold text-gray-700">Carteirinhas</h1>

                <div class="w-8 h-8 rounded-full bg-gray-300"></div>
            </header>

            <!-- Conteúdo Principal -->
            <main class="p-6 flex-1">

                <!-- Cabeçalho Desktop (≥ md) -->
                <div class="hidden md:flex items-center justify-between">
                    <h1 class="text-2xl font-semibold">Sistema de Carteirinhas</h1>
                    <div class="w-10 h-10 rounded-full bg-gray-300"></div>
                </div>

                <!-- Bem-vindo + Botão -->
                <div class="mt-6 flex flex-col items-start space-y-3">
                    <h2 class="text-xl font-semibold">Bem-vindo!</h2>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white text-lg px-6 py-3 rounded-md">
                        Gerar Carteirinha
                    </button>
                </div>

                <!-- Cards de estatísticas: 2 colunas no mobile, 4 no desktop -->
                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white rounded shadow p-4">
                        <p class="text-sm font-medium text-gray-600">Usuários</p>
                        <p class="text-xl font-bold">120</p>
                    </div>
                    <div class="bg-white rounded shadow p-4">
                        <p class="text-sm font-medium text-gray-600">Associados</p>
                        <p class="text-xl font-bold">85</p>
                    </div>
                    <div class="bg-white rounded shadow p-4">
                        <p class="text-sm font-medium text-gray-600">Dependentes</p>
                        <p class="text-xl font-bold">50</p>
                    </div>
                    <div class="bg-white rounded shadow p-4">
                        <p class="text-sm font-medium text-gray-600">Carteirinhas Geradas</p>
                        <p class="text-xl font-bold">150</p>
                    </div>
                </div>

                <!-- Últimas Carteirinhas -->
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
