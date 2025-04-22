<x-layouts.layout title="Meu Perfil - Sistema Petros">
    <div x-data="{ openMenu: false }" class="min-h-screen flex flex-col md:flex-row">

        <x-sidebar-menu />

        <div class="flex-1 flex flex-col relative">

            <x-menu-mobile menuTitle="Perfil" />

            <main class="p-6 flex-1">
                <x-profile-photo-menu h1="Perfil do Usuário" />

                <div
                    class="mt-6 bg-white border border-gray-200 rounded-lg shadow p-6 mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center">
                        <img src="{{ route('users.photo', ['user' => auth()->user()->id]) }}" alt="Foto de Perfil"
                            class="w-16 h-16 rounded-full mr-4">
                        <div>
                            @if (Auth::user()->member)
                                <p class="text-lg font-semibold">{{ Auth::user()->member->name }}</p>
                                <p class="text-gray-600">Matrícula: {{ Auth::user()->member->registration_number }}</p>
                            @elseif (Auth::user()->dependent)
                                <p class="text-lg font-semibold">{{ Auth::user()->dependent->name }}</p>
                                <p class="text-gray-600">Matrícula: {{ Auth::user()->dependent->registration_number }}
                                </p>
                                <p class="text-gray-600">Dependete de {{ Auth::user()->dependent->member->name }}</p>
                            @else
                                <p class="text-lg font-semibold">{{ Auth::user()->nickname }}</p>
                                <p class="text-gray-600">Matrícula: Sem matrícula</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg shadow p-6 mb-6">
                    <h2 class="text-lg font-semibold mb-4">Alterar Senha</h2>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Senha
                                atual</label>

                            <div class="relative">
                                <input id="current_password" name="current_password" type="password"
                                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">

                                <button type="button" class="absolute inset-y-0 right-3 flex items-center"
                                    onclick="togglePassword('current_password', 'togglePasswordIcon')">
                                    <i class="fa-solid fa-eye text-gray-500 cursor-pointer" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Nova
                                    senha</label>

                                <div class="relative">
                                    <input id="new_password" name="new_password" type="password"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">

                                    <button type="button" class="absolute inset-y-0 right-3 flex items-center"
                                        onclick="togglePassword('new_password', 'togglePasswordIcon1')">
                                        <i class="fa-solid fa-eye text-gray-500 cursor-pointer"
                                            id="togglePasswordIcon1"></i>
                                    </button>
                                </div>
                                @error('new_password')
                                    <div class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <label for="new_password_confirmation"
                                    class="block text-sm font-medium text-gray-700 mb-1">Confirmar nova senha</label>

                                <div class="relative">
                                    <input id="new_password_confirmation" name="new_password_confirmation"
                                        type="password"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">

                                    <button type="button" class="absolute inset-y-0 right-3 flex items-center"
                                        onclick="togglePassword('new_password_confirmation', 'togglePasswordIcon2')">
                                        <i class="fa-solid fa-eye text-gray-500 cursor-pointer"
                                            id="togglePasswordIcon2"></i>
                                    </button>
                                </div>
                                @error('new_password_confirmation')
                                    <div class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit"
                            class="mt-6 bg-primary duration-200 hover:bg-primary-300 text-white px-6 py-3 rounded cursor-pointer">
                            Salvar nova senha
                        </button>

                        @if (session('success_password'))
                            <div
                                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-center mt-3 mb-3 text-sm">
                                {{ session('success_password') }}
                            </div>
                        @endif
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Alterar Foto de Perfil</h3>
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="flex flex-col items-center">
                                <img src="{{ route('users.photo', ['user' => auth()->user()->id]) }}"
                                    alt="Foto de Perfil" class="w-24 h-24 rounded-full mb-4">

                                @error('photo')
                                    <div class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <label class="w-full max-w-xs cursor-pointer mb-4">
                                    <input type="file" name="photo" id="photo" accept="image/*" required
                                        class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-gray-100 file:text-sm file:font-semibold cursor-pointer file:cursor-pointer">
                                </label>
                                <button type="submit"
                                    class="bg-primary duration-200 hover:bg-primary-300 text-white px-6 py-3 rounded cursor-pointer">
                                    Atualizar foto
                                </button>
                            </div>

                            @if (session('success_photo'))
                                <div
                                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-center mt-3 mb-3 text-sm">
                                    {{ session('success_photo') }}
                                </div>
                            @endif
                        </form>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Informações Pessoais</h3>
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')
                            <div class="mb-4">
                                <label for="nickname"
                                    class="block text-sm font-medium text-gray-700 mb-1">Usuário</label>
                                <input id="nickname" name="nickname" type="text"
                                    value="{{ old('nickname', Auth::user()->nickname) }}"
                                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">

                                @error('nickname')
                                    <div class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Data de
                                    nascimento</label>
                                <input id="birth_date" name="birth_date" type="date"
                                    value="{{ old('birth_date', Auth::user()->birth_date ? Auth::user()->birth_date->format('Y-m-d') : '') }}"
                                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">

                                @error('birth_date')
                                    <div class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit"
                                class="mt-4 bg-primary hover:bg-primary-300 text-white px-6 py-3 rounded cursor-pointer">
                                Salvar alterações
                            </button>

                            @if (session('success_info'))
                                <div
                                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-center mt-3 mb-3 text-sm">
                                    {{ session('success_info') }}
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-layouts.layout>
