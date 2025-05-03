<x-layouts.layout title="Detalhes do Usuário - Sistema Petros">
    <div x-data="{ openMenu: false }" class="min-h-screen flex flex-col md:flex-row">
        <x-sidebar-menu />
        <div class="flex-1 flex flex-col relative">
            <x-menu-mobile menuTitle="Detalhes do Usuário" />

            <main class="p-6 flex-1 space-y-6 bg-gray-50">
                <x-profile-photo-menu h1="Detalhes do Usuário" />

                <!-- Botão Voltar -->
                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center text-gray-600 hover:text-gray-800 mb-4">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
                </a>

                <!-- Card de Detalhes do Usuário -->
                <div class="bg-slate-100 backdrop-blur-sm border border-gray-100 rounded-lg p-4 mb-6">
                    <div class="flex items-center space-x-6">
                        <img src="{{ route('users.photo', ['user' => $user->id]) }}"
                            alt="Foto de {{ $user->member ? $user->member->name : ($user->dependent ? $user->dependent->name : '') }}"
                            class="w-24 h-24 rounded-xl object-cover" />
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-900">
                                {{ $user->member ? $user->member->name : ($user->dependent ? $user->dependent->name : '') }}
                            </h2>
                            <p class="mt-1 text-xl text-gray-500">
                                Data de Nascimento: {{ optional($user->birth_date)->format('d/m/Y') }}
                            </p>
                            <p class="mt-1 text-xl text-gray-500">
                                Matrícula:
                                {{ $user->member
                                    ? $user->member->registration_number
                                    : ($user->dependent
                                        ? $user->dependent->registration_number
                                        : 'Não possui') }}
                            </p>
                            @if ($user->dependent)
                                <p class="mt-1 text-xl text-gray-500">
                                    Dependente de
                                    {{ $user->dependent->member ? $user->dependent->member->name : 'Não possui' }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <span class="text-lg font-semibold text-gray-900">Nickname: <span
                                class="text-gray-700 font-medium">{{ $user->nickname }}</span></span>
                        <span
                            class="inline-block px-3 py-1 border rounded-lg {{ $user->role === 'admin'
                                ? 'border-red-500 text-red-800'
                                : ($user->role === 'management'
                                    ? 'border-yellow-500 text-yellow-800'
                                    : ($user->role === 'member'
                                        ? 'border-green-500 text-green-800'
                                        : ($user->role === 'dependent'
                                            ? 'border-blue-500 text-blue-800'
                                            : 'border-gray-500 text-gray-800'))) }}">

                            {{ $user->role === 'admin'
                                ? 'Administrador'
                                : ($user->role === 'management'
                                    ? 'Gerência'
                                    : ($user->role === 'member'
                                        ? 'Associado'
                                        : ($user->role === 'dependent'
                                            ? 'Dependente'
                                            : 'Não possui'))) }}
                        </span>
                    </div>
                </div>

                @if ($user->member && $user->member->dependents->isNotEmpty())
                    <h3 class="text-xl font-semibold">Dependentes</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach ($user->member->dependents as $dependent)
                            <div class="bg-white border border-gray-200 rounded-lg p-6 text-center space-y-2">
                                @if ($dependent->user)
                                    <img src="{{ route('users.photo', ['user' => $dependent->user->id]) }}"
                                        alt="Foto do Dependente" class="w-24 h-24 mx-auto rounded-lg object-cover" />
                                @endif

                                <h4 class="text-lg font-semibold text-gray-900">
                                    {{ $dependent->name }}
                                </h4>

                                <p class="text-sm text-gray-600">
                                    Matrícula: {{ $dependent->registration_number }}
                                </p>

                                @if ($dependent->user)
                                    <p class="text-sm text-gray-600">
                                        Data de Nascimento:
                                        {{ optional($dependent->user->birth_date)->format('d/m/Y') }}
                                    </p>
                                @else
                                    <div class="border border-red-100 rounded-lg bg-red-100 p-2">Dependente não se
                                        cadastrou como usuário(a)</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

            </main>
        </div>
    </div>
</x-layouts.layout>
