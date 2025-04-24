<x-layouts.layout title="Adicionar um Dependente - Sistema Petros">
    <div x-data="{ openMenu: false }" class="min-h-screen flex flex-col md:flex-row">
        <x-sidebar-menu />
        <div class="flex-1 flex flex-col relative">
            <x-menu-mobile menuTitle="Adicionar um Dependente" />

            <main class="p-6 flex-1 space-y-6 bg-gray-50">
                <x-profile-photo-menu h1="Adicionar um Dependente" />

                <a href="{{ route('dependents.index') }}"
                    class="inline-flex items-center text-gray-600 hover:text-gray-800 mb-4">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
                </a>

                <form action="{{ route('dependents.store') }}" method="POST" class="space-y-6">
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
                        <label for="member_id" class="block text-sm font-medium text-gray-700 mb-1">Associado</label>
                        <select name="member_id" id="member_id" class="select2">
                            <option value="none">Selecione um Associado</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">
                                    {{ $member->name }} ({{ $member->registration_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')
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
                    <div
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-center mb-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

            </main>
        </div>
    </div>

</x-layouts.layout>
