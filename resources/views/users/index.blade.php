<x-layouts.layout title="Usuários - Sistema Petros">
    <div x-data="{ openMenu: false }" class="min-h-screen flex flex-col md:flex-row">
        <x-sidebar-menu />
        <div class="flex-1 flex flex-col relative">
            <x-menu-mobile menuTitle="Usuários" />

            <main class="p-6 flex-1 space-y-6 bg-gray-50">
                <x-profile-photo-menu h1="Usuários" />

                <div class="space-y-6">

                    <div class="flex flex-col md:flex-row md:justify-start md:items-center gap-4">
                        <a href="{{ route('users.create') }}" type="button"
                            class="bg-primary hover:bg-primary-300 text-white font-medium px-6 py-3 rounded cursor-pointer text-center">
                            Adicionar Usuário
                        </a>
                    </div>

                    <div>
                        <ul class="flex border-b border-gray-200 justify-center md:justify-normal" role="tablist"
                            data-tabs-toggle="#tabs-content">
                            <li class="mr-2" role="presentation">
                                <button id="tab-ativos"
                                    class="inline-block px-4 py-2 font-medium text-primary border-b-2 border-blue-600"
                                    data-tabs-target="#ativos" type="button" role="tab" aria-controls="ativos"
                                    aria-selected="true">
                                    Usuários Ativos
                                </button>
                            </li>
                            <li role="presentation">
                                <button id="tab-inativos"
                                    class="inline-block px-4 py-2 font-medium border-b-2 text-gray-600"
                                    data-tabs-target="#inativos" type="button" role="tab" aria-controls="inativos"
                                    aria-selected="false">
                                    Usuários Inativos
                                </button>
                            </li>
                        </ul>

                        <div id="tabs-content">
                            <div id="ativos" class="p-4 bg-white rounded-b-lg transition-opacity duration-300"
                                role="tabpanel" aria-labelledby="tab-ativos">

                                @if ($activeUsers->isEmpty())
                                    <p class="text-gray-600">Nenhum usuário ativo.</p>
                                @else
                                    <div class="grid grid-cols-2 gap-3 mb-6 md:flex md:flex-wrap md:gap-3">
                                        <a href="{{ route('users.export.pdf') }}"
                                            class="flex items-center bg-white border border-gray-300 rounded px-4 py-2 hover:bg-primary hover:text-white duration-400 cursor-pointer">
                                            <i class="fa-solid fa-file-pdf mr-1"></i>
                                            Gerar PDF
                                        </a>
                                        <a href="{{ route('users.export.excel') }}"
                                            class="flex items-center bg-white border border-gray-300 rounded px-4 py-2 hover:bg-primary hover:text-white duration-400 cursor-pointer">
                                            <i class="fa-solid fa-file-excel mr-1"></i>
                                            Gerar Excel
                                        </a>
                                        <a href="{{ route('users.export.csv') }}"
                                            class="flex items-center bg-white border border-gray-300 rounded px-4 py-2 hover:bg-primary hover:text-white duration-400 cursor-pointer">
                                            <i class="fa-solid fa-file-csv mr-1"></i>
                                            Gerar CSV
                                        </a>
                                        <a href="{{ route('users.print') }}"
                                            class="flex items-center bg-white border border-gray-300 rounded px-4 py-2 hover:bg-primary hover:text-white duration-400 cursor-pointer">
                                            <i class="fa-solid fa-print mr-1"></i>
                                            Imprimir
                                        </a>
                                    </div>

                                    <table id="table">
                                        <thead>
                                            <tr>
                                                <th class="py-2 text-left bg-primary text-white rounded-s-lg">
                                                    Nome</th>
                                                <th class="py-2 text-left bg-primary text-white ">
                                                    Matrícula</th>
                                                <th class="py-2 text-left bg-primary text-white ">
                                                    Nível</th>
                                                <th class="py-2 text-left bg-primary rounded-e-lg text-white">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @foreach ($activeUsers as $user)
                                                <tr>
                                                    <td class="py-2 text-gray-700">
                                                        {{ $user->dependent ? $user->dependent->name : ($user->member ? $user->member->name : $user->nickname) }}
                                                    </td>
                                                    <td class="py-2 text-gray-700">
                                                        {{ $user->dependent ? $user->dependent->registration_number : ($user->member ? $user->member->registration_number : 'Não possui') }}
                                                    </td>
                                                    <td class="py-2 text-gray-700">
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium
                                                            {{ $user->role === 'admin'
                                                                ? 'bg-red-100 text-red-800'
                                                                : ($user->role === 'management'
                                                                    ? 'bg-yellow-100 text-yellow-800'
                                                                    : ($user->role === 'member'
                                                                        ? 'bg-green-100 text-green-800'
                                                                        : ($user->role === 'dependent'
                                                                            ? 'bg-blue-100 text-blue-800'
                                                                            : 'bg-gray-100 text-gray-800'))) }}">
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
                                                    </td>

                                                    <td class="py-2 flex space-x-3">
                                                        <a href="{{ route('users.edit', $user->id) }}"
                                                            data-tooltip="Editar Usuário" data-tooltip-position="top"
                                                            class="text-gray-700 duration-200 hover:text-gray-900 tooltip-trigger">
                                                            <i class="fa-solid fa-pencil"></i>
                                                        </a>

                                                        <button data-tooltip="Suspender Usuário"
                                                            data-tooltip-position="top" data-id="{{ $user->id }}"
                                                            data-name="{{ $user->name }}" data-act="suspend"
                                                            data-url-base="{{ route('users.suspend', $user->id) }}"
                                                            data-modal-target="popup-modal-suspend"
                                                            data-modal-toggle="popup-modal-suspend"
                                                            class="text-gray-700 duration-200 hover:text-gray-900 open-modal cursor-pointer tooltip-trigger">
                                                            <i class="fa-solid fa-user-slash"></i>
                                                        </button>

                                                        <button data-tooltip="Deletar Usuário"
                                                            data-tooltip-position="top" data-id="{{ $user->id }}"
                                                            data-name="{{ $user->name }}" data-act="delete"
                                                            data-url-base="{{ route('users.destroy', $user->id) }}"
                                                            data-modal-target="popup-modal-delete"
                                                            data-modal-toggle="popup-modal-delete"
                                                            class="text-gray-700 duration-200 hover:text-gray-900 open-modal cursor-pointer tooltip-trigger">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>

                        <div id="inativos" class="hidden p-4 bg-white rounded-b-lg transition-opacity duration-300"
                            role="tabpanel" aria-labelledby="tab-inativos">
                            @if ($inactiveUsers->isEmpty())
                                <p class="text-gray-600">Nenhum usuário inativo.</p>
                            @else
                                <table class="w-full text-sm text-gray-700">
                                    <thead>
                                        <tr class="border-b">
                                            <th class="py-2 text-left">Nome</th>
                                            <th class="py-2 text-left">Matrícula</th>
                                            <th class="py-2 text-left">Nível</th>
                                            <th class="py-2 text-left">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($inactiveUsers as $inactiveUser)
                                            <tr>
                                                <td class="py-2">
                                                    {{ $inactiveUser->dependent ? $inactiveUser->dependent->name : ($inactiveUser->member ? $inactiveUser->member->name : $inactiveUser->nickname) }}
                                                </td>
                                                <td class="py-2">
                                                    {{ $inactiveUser->dependent ? $inactiveUser->dependent->registration_number : ($inactiveUser->member ? $inactiveUser->member->registration_number : 'Não possui') }}
                                                </td>
                                                <td class="py-2">
                                                    {{ $inactiveUser->role === 'admin'
                                                        ? 'Administrador'
                                                        : ($inactiveUser->role === 'management'
                                                            ? 'Gerência'
                                                            : ($inactiveUser->role === 'member'
                                                                ? 'Associado'
                                                                : ($inactiveUser->role === 'dependent'
                                                                    ? 'Dependente'
                                                                    : 'Não possui'))) }}
                                                </td>
                                                <td class="py-2 flex space-x-3">
                                                    <form action="{{ route('users.reactivate', $inactiveUser->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button data-tooltip="Reativar Usuário"
                                                            data-tooltip-position="top" type="submit"
                                                            class="text-gray-600 hover:text-gray-800 cursor-pointer tooltip-trigger">
                                                            <i class="fa-solid fa-undo"></i>
                                                        </button>
                                                    </form>

                                                    <button data-tooltip="Deletar Usuário" data-tooltip-position="top"
                                                        data-id="{{ $inactiveUser->id }}"
                                                        data-name="{{ $inactiveUser->name }}" data-act="delete"
                                                        data-url-base="{{ route('users.destroy', $inactiveUser->id) }}"
                                                        data-modal-target="popup-modal-delete"
                                                        data-modal-toggle="popup-modal-delete"
                                                        class="text-gray-600 hover:text-gray-800 open-modal cursor-pointer tooltip-trigger">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

                        </div>
                    </div>
                </div>
            </main>

            <x-base-tooltip />

            <x-modal-confirmation titleModal="Você tem certeza que deseja suspender" act="suspend" />
            <x-modal-confirmation titleModal="Você tem certeza que deseja deletar" act="delete" />
</x-layouts.layout>
