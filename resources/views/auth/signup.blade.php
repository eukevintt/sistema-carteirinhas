<x-layouts.layout title="Cadastro - Sistema Petros">
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
                        <label for="usuario" class="block text-sm font-medium text-gray-700">Usuário*</label>
                        <input type="text" id="usuario" name="usuario" placeholder="Digite um nome de usuário"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-3 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none" />
                    </div>

                    <div>
                        <label for="matricula" class="block text-sm font-medium text-gray-700">Matrícula*</label>
                        <input type="text" id="matricula" name="matricula" placeholder="Digite sua matrícula"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-3 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none" />
                        <p class="text-xs text-gray-500 mt-1">Se não souber sua matrícula, consulte a gerência.</p>
                    </div>

                    <div>
                        <label for="nascimento" class="block text-sm font-medium text-gray-700">Data de
                            Nascimento*</label>
                        <div class="relative">
                            <input type="date" id="nascimento" name="nascimento" placeholder="dd/mm/aaaa"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-3 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none" />
                        </div>
                    </div>

                    <div>
                        <label for="senha" class="block text-sm font-medium text-gray-700">Senha*</label>
                        <div class="relative">
                            <input type="password" id="senha" name="senha" placeholder="Crie uma senha"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-3 pr-12 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none" />
                            <button type="button" class="absolute inset-y-0 right-3 flex items-center text-primary">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="senha_confirmation" class="block text-sm font-medium text-gray-700">Confirmar
                            Senha*</label>
                        <div class="relative">
                            <input type="password" id="senha_confirmation" name="senha_confirmation"
                                placeholder="Confirme sua senha"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-3 pr-12 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none" />
                            <button type="button" class="absolute inset-y-0 right-3 flex items-center text-primary">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="foto" class="block text-sm font-medium text-gray-700">Foto de Perfil
                            (Obrigatório)*</label>
                        <input type="file" id="foto" name="foto"
                            class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-gray-100 file:text-sm file:font-semibold" />
                        <p class="text-xs text-gray-500 mt-1">OBS: Adicione uma foto em que o seu rosto apareça
                            nitidamente.</p>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-primary text-white rounded-md hover:bg-[#057391ee] duration-300 font-semibold text-base cursor-pointer">
                        Criar Conta
                    </button>
                </form>

                <div class="mt-6 text-base">
                    <a href="#" class="text-primary hover:underline"><i class="fa-solid fa-arrow-left mr-1"></i>Já
                        tenho conta</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.layout>
