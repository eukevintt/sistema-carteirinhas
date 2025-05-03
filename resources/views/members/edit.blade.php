<x-layouts.layout title="Editar Associado - Sistema Petros">
    <div x-data="{ openMenu: false }" class="min-h-screen flex flex-col md:flex-row">
        <x-sidebar-menu />
        <div class="flex-1 flex flex-col relative">
            <x-menu-mobile menuTitle="Editar Associado" />

            <main class="p-6 flex-1 space-y-6 bg-gray-50">
                <x-profile-photo-menu h1="Editar Associado" />

                <a href="{{ route('members.index') }}"
                    class="inline-flex items-center text-gray-600 hover:text-gray-800 mb-4">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
                </a>

                @if ($member->user)
                    <div class="bg-slate-100 backdrop-blur-sm border border-gray-100 rounded-lg p-4 mb-6">
                        <div class="flex items-center space-x-6">
                            <img src="{{ route('users.photo', ['user' => $member->user->id]) }}"
                                alt="Foto de {{ $member->name }}" class="w-25 h-25 rounded-xl object-cover" />
                            <div>
                                <h2 class="text-2xl font-semibold text-gray-900">
                                    {{ $member->name }}
                                </h2>
                                <p class="mt-1 text-xl text-gray-500">
                                    Data de Nascimento: {{ optional($member->user->birth_date)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <p class="text-sm text-gray-500 mb-6 text-center">Altere as informações do associado abaixo e
                        clique em salvar. Se deseja alterar outras informações deste associado, <a
                            class="text-primary hover:underline hover:text-primary-300 duration-200"
                            href="{{ route('users.edit', $member->user->id) }}">Clique aqui!</a>
                    </p>
                @else
                    <p class="text-sm text-gray-500 mb-6 text-center">Altere as informações do associado abaixo e
                        clique em salvar.</p>
                @endif


                <form action="{{ route('members.update', $member->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $member->name) }}"
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
                            value="{{ old('registration_number', $member->registration_number) }}"
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
