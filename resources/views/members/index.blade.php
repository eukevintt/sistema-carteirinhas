<x-layouts.layout title="Associados - Sistema Petros">
    <div x-data="{ openMenu: false }" class="min-h-screen flex flex-col md:flex-row">
        <x-sidebar-menu />
        <div class="flex-1 flex flex-col relative">
            <x-menu-mobile menuTitle="Associados" />

            <main class="p-6 flex-1 space-y-6 bg-gray-50">
                <x-profile-photo-menu h1="Associados" />

                <div class="space-y-6">

                    <div class="flex flex-col md:flex-row md:justify-start md:items-center gap-4">
                        <a href="{{ route('members.create') }}" type="button"
                            class="bg-primary hover:bg-primary-300 text-white font-medium px-6 py-3 rounded cursor-pointer text-center">
                            Adicionar Associado
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
                                    Associados Ativos
                                </button>
                            </li>
                            <li role="presentation">
                                <button id="tab-inativos"
                                    class="inline-block px-4 py-2 font-medium border-b-2 text-gray-600"
                                    data-tabs-target="#inativos" type="button" role="tab" aria-controls="inativos"
                                    aria-selected="false">
                                    Associados Inativos
                                </button>
                            </li>
                        </ul>

                        <div id="tabs-content">
                            <div id="ativos" class="p-4 bg-white rounded-b-lg transition-opacity duration-300"
                                role="tabpanel" aria-labelledby="tab-ativos">

                                @if ($activeMembers->isEmpty())
                                    <p class="text-gray-600">Nenhum associado ativo.</p>
                                @else
                                    <div class="grid grid-cols-2 gap-3 mb-6 md:flex md:flex-wrap md:gap-3">
                                        <a href="{{ route('members.export.pdf') }}"
                                            class="flex items-center bg-white border border-gray-300 rounded px-4 py-2 hover:bg-primary hover:text-white duration-400 cursor-pointer">
                                            <i class="fa-solid fa-file-pdf mr-1"></i>
                                            Gerar PDF
                                        </a>
                                        <a href="{{ route('members.export.excel') }}"
                                            class="flex items-center bg-white border border-gray-300 rounded px-4 py-2 hover:bg-primary hover:text-white duration-400 cursor-pointer">
                                            <i class="fa-solid fa-file-excel mr-1"></i>
                                            Gerar Excel
                                        </a>
                                        <a href="{{ route('members.export.csv') }}"
                                            class="flex items-center bg-white border border-gray-300 rounded px-4 py-2 hover:bg-primary hover:text-white duration-400 cursor-pointer">
                                            <i class="fa-solid fa-file-csv mr-1"></i>
                                            Gerar CSV
                                        </a>
                                        <a href="{{ route('members.print') }}"
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
                                                <th class="py-2 text-left bg-primary rounded-e-lg text-white">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @foreach ($activeMembers as $member)
                                                <tr>
                                                    <td class="py-2 text-gray-700">{{ $member->name }}</td>
                                                    <td class="py-2 text-gray-700">
                                                        {{ $member->registration_number }}
                                                    </td>
                                                    <td class="py-2 flex space-x-3">
                                                        <a href="{{ route('members.edit', $member->id) }}"
                                                            data-tooltip="Editar Associado" data-tooltip-position="top"
                                                            class="text-gray-700 duration-200 hover:text-gray-900 tooltip-trigger">
                                                            <i class="fa-solid fa-pencil"></i>
                                                        </a>

                                                        <button data-tooltip="Suspender Associado"
                                                            data-tooltip-position="top" data-id="{{ $member->id }}"
                                                            data-name="{{ $member->name }}" data-act="suspend"
                                                            data-url-base="{{ route('members.suspend', $member->id) }}"
                                                            data-modal-target="popup-modal-suspend"
                                                            data-modal-toggle="popup-modal-suspend"
                                                            class="text-gray-700 duration-200 hover:text-gray-900 open-modal cursor-pointer tooltip-trigger">
                                                            <i class="fa-solid fa-user-slash"></i>
                                                        </button>

                                                        <button data-tooltip="Deletar Associado"
                                                            data-tooltip-position="top" data-id="{{ $member->id }}"
                                                            data-name="{{ $member->name }}" data-act="delete"
                                                            data-url-base="{{ route('members.destroy', $member->id) }}"
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
                            @if ($inactiveMembers->isEmpty())
                                <p class="text-gray-600">Nenhum associado inativo.</p>
                            @else
                                <table class="w-full text-sm text-gray-700">
                                    <thead>
                                        <tr class="border-b">
                                            <th class="py-2 text-left">Nome</th>
                                            <th class="py-2 text-left">Matrícula</th>
                                            <th class="py-2 text-left">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($inactiveMembers as $inactiveMember)
                                            <tr>
                                                <td class="py-2">{{ $inactiveMember->name }}</td>
                                                <td class="py-2">{{ $inactiveMember->registration_number }}
                                                </td>
                                                <td class="py-2 flex space-x-3">
                                                    <form
                                                        action="{{ route('members.reactivate', $inactiveMember->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button data-tooltip="Reativar Associado"
                                                            data-tooltip-position="top" type="submit"
                                                            class="text-gray-600 hover:text-gray-800 cursor-pointer tooltip-trigger">
                                                            <i class="fa-solid fa-undo"></i>
                                                        </button>
                                                    </form>

                                                    <button data-tooltip="Deletar Associado"
                                                        data-tooltip-position="top"
                                                        data-id="{{ $inactiveMember->id }}"
                                                        data-name="{{ $inactiveMember->name }}" data-act="delete"
                                                        data-url-base="{{ route('members.destroy', $inactiveMember->id) }}"
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

                @if (session('success'))
                    <x-toasts.confirmation-toast msg="{{ session('success') }}" />
                @endif
            </main>

            <x-base-tooltip />

            <x-modal-confirmation titleModal="Você tem certeza que deseja suspender" act="suspend" />
            <x-modal-confirmation titleModal="Você tem certeza que deseja deletar" act="delete" />
</x-layouts.layout>
