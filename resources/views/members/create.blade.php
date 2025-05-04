<x-layouts.layout title="Adicionar um Associado - Sistema Petros">
    <div x-data="{ openMenu: false }" class="min-h-screen flex flex-col md:flex-row">
        <x-sidebar-menu />
        <div class="flex-1 flex flex-col relative">
            <x-menu-mobile menuTitle="Adicionar um Associado" />

            <main class="p-6 flex-1 space-y-6 bg-gray-50">
                <x-profile-photo-menu h1="Adicionar um Associado" />

                <a href="{{ route('members.index') }}"
                    class="inline-flex items-center text-gray-600 hover:text-gray-800 mb-4">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
                </a>

                @if (session('error'))
                    <div class="mt-3 p-4 rounded-lg bg-red-100 border border-red-300 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('members.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                        <input type="text" name="name" id="name"
                            class="block w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:ring-primary focus:outline-none" />
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label for="registration_number"
                            class="block text-sm font-medium text-gray-700 mb-1">Matrícula</label>
                        <input type="text" name="registration_number" id="registration_number"
                            class="block w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:ring-primary focus:outline-none" />
                        @error('registration_number')
                            <div class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full bg-primary hover:bg-primary-300 text-white font-medium text-lg px-6 py-4 rounded-lg transition cursor-pointer">
                            Salvar Alterações
                        </button>
                    </div>
                </form>

                @if (session('success'))
                    <x-toasts.confirmation-toast msg="{{ session('success') }}" />
                @endif

            </main>
        </div>
    </div>

</x-layouts.layout>
