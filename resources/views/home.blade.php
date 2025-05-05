<x-layouts.layout title="Página Inicial - Sistema Petros">
    <div x-data="{ openMenu: false }" class="min-h-screen flex flex-col md:flex-row">

        <x-sidebar-menu />

        <div class="flex-1 flex flex-col relative">

            <x-menu-mobile menuTitle="Página Inicial" />

            <main class="p-6 flex-1">

                <x-profile-photo-menu h1="Sistema de Carteirinhas" />



                @php

                    $latestCard = Auth::user()?->dependent
                        ? Auth::user()?->dependent?->membershipCards()->latest('issued_at')->first()
                        : Auth::user()?->member?->membershipCards()->latest('issued_at')->first();

                @endphp

                @if (!$latestCard && (auth()->user()->member || auth()->user()->dependent))
                    <div class="mt-6 flex flex-col items-center space-y-3 ">
                        <h2 class="text-4xl font-bold">Bem-vindo!</h2>
                        <p class="textlg text-gray-700 text-center max-w-md">
                            Você ainda não gerou nenhuma carteirinha. Para gerar clique no botão abaixo.
                        </p>

                        <a href="{{ route('cards.member.generate', auth()->user()->id) }}"
                            class="bg-primary hover:bg-primary-300 cursor-pointer transition mx-auto text-white text-lg px-6 py-3 rounded-md">
                            Gerar Carteirinha
                        </a>
                    </div>

                    <div
                        class="flex items-center justify-center mt-8 space-x-4 max-w-md mx-auto bg-white border border-gray-200 rounded-lg p-4 shadow">
                        <div class="w-16 h-16 rounded-full overflow-hidden">
                            <img src="{{ route('users.photo', ['user' => auth()->user()->id]) }}" alt=""
                                class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="text-lg font-semibold">
                                {{ auth()->user()->dependent ? auth()->user()->dependent->name : (auth()->user()->member ? auth()->user()->member->name : auth()->user()->nickname) }}
                            </p>
                            <p class="text-gray-500">
                                {{ auth()->user()->birth_date ? auth()->user()->birth_date->format('d/m/Y') : '-' }}</p>
                        </div>
                    </div>
                @elseif (isset($latestCard) && $latestCard->expires_at > now())
                    <div class="mt-6 flex flex-col items-center space-y-3">
                        <h2 class="text-4xl font-bold">Carteirinha</h2>
                        <p class="text-lg text-gray-700 text-center max-w-md">
                            Sua carteirinha é válida até
                            {{ $latestCard->expires_at->copy()->subDay()->format('d/m/Y') }}.
                        </p>
                    </div>

                    <div class="mt-8 max-w-md mx-auto bg-white border border-gray-200 rounded-lg p-4 shadow space-y-4">
                        <div class="flex items-center space-x-4 justify-center">
                            <div class="w-16 h-16 rounded-full overflow-hidden">
                                <img src="{{ route('users.photo', ['user' => auth()->user()->id]) }}" alt=""
                                    class="w-full h-full object-cover" />
                            </div>
                            <div>
                                <p class="text-lg font-semibold">
                                    {{ auth()->user()->dependent ? auth()->user()->dependent->name : (auth()->user()->member ? auth()->user()->member->name : auth()->user()->nickname) }}
                                </p>
                                <p class="text-gray-500">{{ auth()->user()->member ? 'Associado' : 'Dependente' }}
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('cards.member.generate', auth()->user()->id) }}"
                            class="block w-full bg-primary hover:bg-primary-300 text-white text-center text-lg px-6 py-3 rounded-md transition">
                            Visualizar carteirinha
                        </a>
                        <a href="{{ route('cards.download', auth()->user()->id) }}"
                            class="block w-full border border-gray-300 hover:bg-gray-50 text-gray-700 text-center text-lg px-6 py-3 rounded-md transition">
                            <i class="fas fa-download mr-2"></i>Baixar PDF
                        </a>
                    </div>
                @elseif(isset($latestCard) && $latestCard->expires_at < now())
                    <div class="mt-6 max-w-md mx-auto bg-white border border-gray-200 rounded-lg p-6 shadow space-y-6">
                        <h2 class="text-3xl font-bold text-center">Carteirinha Expirada</h2>

                        <div class="flex items-center space-x-4 justify-center">
                            <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-100">
                                <img src="{{ route('users.photo', ['user' => auth()->user()->id]) }}" alt=""
                                    class="w-full h-full object-cover" />
                            </div>
                            <div>
                                <p class="text-lg font-semibold">
                                    {{ auth()->user()->dependent
                                        ? auth()->user()->dependent->name
                                        : (auth()->user()->member
                                            ? auth()->user()->member->name
                                            : auth()->user()->nickname) }}
                                </p>
                                <p class="text-gray-500">
                                    {{ auth()->user()->member ? 'Associado' : 'Dependente' }}
                                </p>
                            </div>
                        </div>

                        <p class="text-gray-700 text-center">
                            Sua carteirinha expirou em
                            {{ $latestCard->expires_at->copy()->subDay()->format('d/m/Y') }}.
                        </p>

                        <a href="{{ route('cards.member.generate', auth()->user()->id) }}"
                            class="block w-full bg-red-600 hover:bg-red-700 text-white text-center py-3 rounded-md transition font-semibold">
                            Gerar Nova Carteirinha
                        </a>
                    </div>
                @endif


                @can('managers')
                    <h2 class="text-center font-bold text-3xl mt-5">Visão geral do sistema</h2>
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
                            @foreach ($lastsCards as $card)
                                <li class="flex justify-between">
                                    <span>
                                        @if ($card->member)
                                            {{ $card->member->name }}
                                            ({{ $card->member->user->role === 'member' ? 'Associado' : 'Gerência' }})
                                        @else
                                            {{ $card->dependent->name }} (Dependente)
                                        @endif
                                    </span>
                                    <span>{{ $card->issued_at->format('d/m/Y') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endcan

            </main>
        </div>
    </div>
</x-layouts.layout>
