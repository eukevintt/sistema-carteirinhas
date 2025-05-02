<div id="popup-modal-{{ $act }}" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative rounded-lg shadow-s bg-primary">
            <button type="button"
                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                data-modal-hide="popup-modal-{{ $act }}">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Fechar</span>
            </button>

            <div class="p-4 md:p-5 text-center text-white">
                <i class="fa-solid fa-triangle-exclamation text-5xl mb-4"></i>
                <h3 class="mb-3 text-lg font-normal">{{ $titleModal }} o usuário(a) <strong
                        id="modal-name-{{ $act }}"></strong>?</h3>
                @if ($act == 'delete')
                    <div class="flex items-center justify-center p-4 mb-4 text-sm text-red-500 rounded-lg bg-[#056079c2] dark:text-red-400"
                        role="alert">
                        <i class="fa-solid fa-circle-info mr-2"></i>
                        <div>
                            <span class="font-medium">Cuidado!</span> Essa ação não pode ser desfeita.
                        </div>
                    </div>

                    <form id="modal-form-{{ $act }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2 cursor-pointer">
                            Sim, eu tenho certeza
                        </button>

                        <button data-modal-hide="popup-modal-{{ $act }}" type="button"
                            class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-700 focus:z-10 focus:ring-4 focus:ring-gray-100 cursor-pointer">
                            Não, cancelar
                        </button>
                    </form>
                @else
                    <form id="modal-form-{{ $act }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2 cursor-pointer">
                            Sim, eu tenho certeza
                        </button>

                        <button data-modal-hide="popup-modal-{{ $act }}" type="button"
                            class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-700 focus:z-10 focus:ring-4 focus:ring-gray-100 cursor-pointer">
                            Não, cancelar
                        </button>
                    </form>
                @endif



            </div>
        </div>
    </div>
</div>
