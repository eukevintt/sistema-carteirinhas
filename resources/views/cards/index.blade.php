<x-layouts.layout title="Carteirinhas - Sistema Petros">

    <div class="min-h-screen flex flex-col md:flex-row">
        <x-sidebar-menu />
        <div class="flex-1 flex flex-col relative">
            <x-menu-mobile menuTitle="Carteirinhas" />

            <main class="p-6 flex-1 space-y-6 bg-gray-50">
                <x-profile-photo-menu h1="Carteirinhas" />

                @if ($cards->isEmpty())
                    <div class="flex justify-center md:justify-start mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 ">
                            Nenhuma carteirinha encontrada
                        </h2>
                    </div>
                @else
                    <div id="accordion-cards" data-accordion="collapse">
                        @php
                            $cardsGrouped = $cards->groupBy(function ($card) {
                                return $card->member_id
                                    ? "member_{$card->member_id}"
                                    : "dependent_{$card->dependent_id}";
                            });
                        @endphp

                        @foreach ($cardsGrouped as $key => $group)
                            @php
                                $first = $group->first();

                                $owner = $first->member ?? $first->dependent;

                                if (!$owner || (method_exists($owner, 'trashed') && $owner->trashed())) {
                                    continue;
                                }

                                $label = "{$owner->name} ({$owner->registration_number})";
                            @endphp


                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-semibold text-gray-800">
                                    {{ $label }}
                                </h2>
                                <a href="{{ route('cards.create', ['member_id' => $first->member_id, 'dependent_id' => $first->dependent_id]) }}"
                                    class="text-blue-600 hover:underline tooltip-trigger"
                                    data-tooltip="Adicionar nova carteirinha" data-tooltip-position="top">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                                <h2 id="heading-{{ $key }}">
                                    <button type="button"
                                        class="flex items-center justify-between w-full p-4 font-medium text-left text-gray-700 bg-white border border-gray-200 hover:bg-gray-100 rounded-lg cursor-pointer"
                                        data-accordion-target="#body-{{ $key }}" aria-expanded="false"
                                        aria-controls="body-{{ $key }}">
                                        <span>{{ $label }}</span>
                                        <svg data-accordion-icon class="w-6 h-6 rotate-180" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1
                                 1 0 111.414 1.414l-4 4a1 1 0 01-1.414
                                 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    </button>
                                </h2>

                                <div id="body-{{ $key }}"
                                    class="hidden p-4 bg-gray-50 border border-t-0 border-gray-200"
                                    aria-labelledby="heading-{{ $key }}" data-accordion-body>
                                    <table class="min-w-full text-sm text-left text-gray-600">
                                        <thead class="bg-gray-200 uppercase text-xs text-gray-700">
                                            <tr>
                                                <th class="px-4 py-2">Emissão</th>
                                                <th class="px-4 py-2">Validade</th>
                                                <th class="px-4 py-2">Status</th>
                                                <th class="px-4 py-2">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($group as $card)
                                                <tr class="bg-white border-b">
                                                    <td class="px-4 py-2">{{ $card->issued_at->format('d/m/Y') }}</td>
                                                    <td class="px-4 py-2">
                                                        {{ $card->expires_at->copy()->subDay()->format('d/m/Y') }}</td>
                                                    <td class="px-4 py-2">
                                                        <span
                                                            class="{{ $card->expires_at > now() ? 'bg-green-100 text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 ' : 'bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300' }}">
                                                            {{ $card->expires_at > now() ? 'Ativa' : 'Expirada' }}
                                                        </span>
                                                    </td>
                                                    @if (!$card->trashed())
                                                        <td class="px-4 py-2 space-x-2">
                                                            <a href="{{ route('users.cards', $card->member ? $card->member->user->id : $card->dependent->user->id) }}"
                                                                class="px-2 py-1 text-blue-600 hover:underline tooltip-trigger"
                                                                data-tooltip="Detalhes" data-tooltip-position="top">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </a>
                                                            <form action="{{ route('cards.destroy', $card->id) }}"
                                                                method="POST" class="inline">
                                                                @csrf @method('DELETE')
                                                                <button type="submit"
                                                                    data-tooltip="Deletar Carteirinha (Ação Irreversível)"
                                                                    data-tooltip-position="top"
                                                                    class="px-2 py-1 text-red-600 hover:underline tooltip-trigger cursor-pointer">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        @endforeach
                    </div>
                    @if (session('success'))
                        <x-toasts.confirmation-toast msg="{{ session('success') }}" />
                    @endif
                @endif
            </main>

        </div>
    </div>
    <x-base-tooltip />
    <x-modal-confirmation titleModal="Você tem certeza que deseja deletar" act="delete" />

</x-layouts.layout>
