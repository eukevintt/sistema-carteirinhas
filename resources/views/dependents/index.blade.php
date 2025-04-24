<x-layouts.layout title="Dependentes - Sistema Petros">
    <div x-data="{ openMenu: false }" class="min-h-screen flex flex-col md:flex-row">
        <x-sidebar-menu />
        <div class="flex-1 flex flex-col relative">
            <x-menu-mobile menuTitle="Dependentes" />

            <main class="p-6 flex-1 space-y-6 bg-gray-50">
                <x-profile-photo-menu h1="Dependentes" />

                <div class="space-y-6">

                    <div class="flex flex-col md:flex-row md:justify-start md:items-center gap-4">
                        <button type="button"
                            class="bg-primary hover:bg-primary-300 text-white font-medium px-6 py-3 rounded cursor-pointer">
                            Adicionar Dependente
                        </button>
                    </div>

                    <div>
                        <ul class="flex border-b border-gray-200" role="tablist" data-tabs-toggle="#tabs-content">
                            <li class="mr-2" role="presentation">
                                <button id="tab-ativos"
                                    class="inline-block px-4 py-2 font-medium text-primary border-b-2 border-blue-600"
                                    data-tabs-target="#ativos" type="button" role="tab" aria-controls="ativos"
                                    aria-selected="true">
                                    Dependentes Ativos
                                </button>
                            </li>
                            <li role="presentation">
                                <button id="tab-inativos"
                                    class="inline-block px-4 py-2 font-medium border-b-2 text-gray-600"
                                    data-tabs-target="#inativos" type="button" role="tab" aria-controls="inativos"
                                    aria-selected="false">
                                    Dependentes Inativos
                                </button>
                            </li>
                        </ul>

                        <div id="tabs-content">
                            <div id="ativos" class="p-4 bg-white rounded-b-lg transition-opacity duration-300"
                                role="tabpanel" aria-labelledby="tab-ativos">

                                <div class="flex flex-wrap gap-3 mb-6">
                                    <a href="{{ route('dependents.export.pdf') }}"
                                        class="flex items-center bg-white border border-gray-300 rounded px-4 py-2 hover:bg-primary hover:text-white duration-400 cursor-pointer">
                                        <i class="fa-solid fa-file-pdf mr-1"></i>
                                        Gerar PDF
                                    </a>
                                    <a href="{{ route('dependents.export.excel') }}"
                                        class="flex items-center bg-white border border-gray-300 rounded px-4 py-2 hover:bg-primary hover:text-white duration-400 cursor-pointer">
                                        <i class="fa-solid fa-file-excel mr-1"></i>
                                        Gerar Excel
                                    </a>
                                    <a href="{{ route('dependents.export.csv') }}"
                                        class="flex items-center bg-white border border-gray-300 rounded px-4 py-2 hover:bg-primary hover:text-white duration-400 cursor-pointer">
                                        <i class="fa-solid fa-file-csv mr-1"></i>
                                        Gerar CSV
                                    </a>
                                    <a href="{{ route('dependents.print') }}"
                                        class="flex items-center bg-white border border-gray-300 rounded px-4 py-2 hover:bg-primary hover:text-white duration-400 cursor-pointer">
                                        <i class="fa-solid fa-print mr-1"></i>
                                        Imprimir
                                    </a>
                                </div>


                                @if ($dependents->isEmpty())
                                    <p class="text-gray-600">Nenhum dependente Ativo.</p>
                                @else
                                    <div id="accordion-ativos" data-accordion="collapse">
                                        @foreach ($membersWithDependents as $member)
                                            <h2 id="accordion-heading-{{ $member->id }}">
                                                <button type="button"
                                                    class="flex items-center justify-between w-full p-4 font-medium text-white bg-primary border border-b-0 border-gray-200 rounded-t-lg cursor-pointer"
                                                    data-accordion-target="#accordion-body-{{ $member->id }}"
                                                    aria-expanded="true"
                                                    aria-controls="accordion-body-{{ $member->id }}">
                                                    {{ $member->name }} ({{ $member->registration_number }})
                                                    <svg data-accordion-icon class="w-6 h-6 shrink-0"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.58l3.71-4.35a.75.75 0 111.14.98l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </h2>


                                            <div id="accordion-body-{{ $member->id }}"
                                                class="p-4 border border-t-0 border-gray-200 bg-white rounded-b-lg"
                                                aria-labelledby="accordion-heading-{{ $member->id }}">
                                                <table class="w-full text-sm text-gray-700">
                                                    <thead>
                                                        <tr class="border-b">
                                                            <th class="py-2 text-left">Nome</th>
                                                            <th class="py-2 text-left">Matrícula</th>
                                                            <th class="py-2 text-left">Ações</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-gray-100">
                                                        @foreach ($member->dependents as $dependent)
                                                            <tr>
                                                                <td class="py-2">{{ $dependent->name }}</td>
                                                                <td class="py-2">
                                                                    {{ $dependent->registration_number }}
                                                                </td>
                                                                <td class="py-2 flex space-x-3">
                                                                    <button class="text-gray-600 hover:text-gray-800">
                                                                        <i class="fa-solid fa-pencil"></i>
                                                                    </button>
                                                                    <button data-id="{{ $dependent->id }}"
                                                                        data-name="{{ $dependent->name }}"
                                                                        data-act="suspend"
                                                                        data-url-base="{{ route('dependents.suspend', $dependent->id) }}"
                                                                        data-modal-target="popup-modal-suspend"
                                                                        data-modal-toggle="popup-modal-suspend"
                                                                        class="text-gray-600 hover:text-gray-800 open-modal">
                                                                        <i class="fa-solid fa-user-slash"></i>
                                                                    </button>
                                                                    <button data-id="{{ $dependent->id }}"
                                                                        data-name="{{ $dependent->name }}"
                                                                        data-act="delete"
                                                                        data-url-base="{{ route('dependents.destroy', $dependent->id) }}"
                                                                        data-modal-target="popup-modal-delete"
                                                                        data-modal-toggle="popup-modal-delete"
                                                                        class="text-gray-600 hover:text-gray-800 open-modal">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-3">
                                        {{ $membersWithDependents->links() }}
                                    </div>
                                @endif
                            </div>

                            <div id="inativos" class="hidden p-4 bg-white rounded-b-lg transition-opacity duration-300"
                                role="tabpanel" aria-labelledby="tab-inativos">
                                @if ($inactiveDependents->isEmpty())
                                    <p class="text-gray-600">Nenhum dependente inativo.</p>
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
                                            @foreach ($inactiveDependents as $inactiveDependent)
                                                <tr>
                                                    <td class="py-2">{{ $inactiveDependent->name }}</td>
                                                    <td class="py-2">{{ $inactiveDependent->registration_number }}
                                                    </td>
                                                    <td class="py-2 flex space-x-3">
                                                        <form
                                                            action="{{ route('dependents.reactivate', $inactiveDependent->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                class="text-gray-600 hover:text-gray-800">
                                                                <i class="fa-solid fa-undo"></i>
                                                            </button>
                                                        </form>

                                                        <button data-id="{{ $inactiveDependent->id }}"
                                                            data-name="{{ $inactiveDependent->name }}"
                                                            data-act="delete"
                                                            data-url-base="{{ route('dependents.destroy', $inactiveDependent->id) }}"
                                                            data-modal-target="popup-modal-delete"
                                                            data-modal-toggle="popup-modal-delete"
                                                            class="text-gray-600 hover:text-gray-800 open-modal">
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
                </div>
            </main>


            <x-modal-confirmation titleModal="Você tem certeza que deseja suspender" act="suspend" />
            <x-modal-confirmation titleModal="Você tem certeza que deseja deletar" act="delete" />
</x-layouts.layout>
