<x-layouts.layout title="Redefinir Senha - Sistema Petros">
    <div class="flex flex-col lg:flex-row h-screen w-full bg-white items-center justify-center">
        <!-- Left side (image) -->
        <div class="hidden lg:flex w-1/2 h-full">
            <img src="{{ asset('images/fundo-gremio-petros-login.jpg') }}" alt="Grêmio Petros"
                class="object-cover w-full h-full" />
        </div>

        <!-- Right side (form) -->
        <div class="flex items-center justify-center w-full lg:w-1/2">
            <div class="w-full max-w-lg px-10">
                <div class="flex flex-col items-center space-y-2 mb-4">
                    <img src="{{ asset('images/logo.png') }}" class="w-44 md:w-52" alt="Logo">
                </div>

                <form class="w-full space-y-4">
                    <div>
                        <label for="matricula" class="block text-sm font-medium text-gray-700">Matrícula*</label>
                        <input type="text" id="matricula" name="matricula" placeholder="Digite sua matrícula"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-3 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none" />
                    </div>

                    <div>
                        <label for="nova_senha" class="block text-sm font-medium text-gray-700">Nova Senha*</label>
                        <div class="relative">
                            <input type="password" id="nova_senha" name="nova_senha" placeholder="Digite a nova senha"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-3 pr-12 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none" />
                            <button type="button" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="confirmar_senha" class="block text-sm font-medium text-gray-700">Confirmar Nova
                            Senha*</label>
                        <div class="relative">
                            <input type="password" id="confirmar_senha" name="confirmar_senha"
                                placeholder="Confirme a nova senha"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-3 pr-12 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none" />
                            <button type="button" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-primary text-white rounded-md hover:bg-[#057391ee] duration-300 cursor-pointer font-semibold text-base">
                        Redefinir Senha
                    </button>
                </form>

                <div class="mt-6 text-base">
                    <a href="#" class="text-primary hover:underline"><i
                            class="fa-solid fa-arrow-left mr-1"></i>Voltar para login</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.layout>
