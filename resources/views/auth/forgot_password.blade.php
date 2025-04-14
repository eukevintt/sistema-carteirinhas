<x-layouts.layout title="Esqueci Minha Senha - Sistema Petros">
    <div class="h-screen flex flex-row">
        <div class="hidden lg:block w-2/3 relative overflow-hidden">
            <img src="{{ asset('images/fundo-gremio-petros-login.jpg') }}"
                alt="Fundo de Login do Grêmio Petros, uma sala com uma mesa de sinuca e uma televisão"
                class="object-cover w-full h-full">
        </div>

        <div class="w-full lg:w-1/3 flex flex-col justify-center px-8 py-10 bg-white">
            <div class="flex justify-center mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Logo do Grêmio Petros" class="w-44">
            </div>

            <div class="mb-6 flex flex-col items-center">
                <h1 class="text-3xl font-bold text-gray-800">Esqueci Minha Senha</h1>
                <p class="text-gray-500 mt-1">Redefina sua senha</p>
            </div>

            <form action="{{ route('auth.password.reset') }}" method="POST" class="space-y-4">
                @csrf

                <div class="mb-4">
                    <label for="registration_number" class="block mb-1 text-sm font-medium text-gray-700">
                        Matrícula*
                    </label>
                    <input type="text" name="registration_number" id="registration_number" required
                        class="rounded-md w-full py-2 px-3 bg-gray-200 border border-gray-300 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none"
                        placeholder="Digite sua matrícula">
                </div>

                <div class="mb-4">
                    <label for="new_password" class="block mb-1 text-sm font-medium text-gray-700">
                        Nova Senha*
                    </label>
                    <div class="relative">
                        <input type="password" name="new_password" id="new_password" required
                            class="rounded-md w-full py-2 px-3 bg-gray-200 border border-gray-300 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none"
                            placeholder="Digite a nova senha">
                        <button type="button" class="absolute inset-y-0 right-3 flex items-center">
                            <i class="fa-solid fa-eye text-gray-500"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="confirm_password" class="block mb-1 text-sm font-medium text-gray-700">
                        Confirmar Nova Senha*
                    </label>
                    <div class="relative">
                        <input type="password" name="confirm_password" id="confirm_password" required
                            class="rounded-md w-full py-2 px-3 bg-gray-200 border border-gray-300 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none"
                            placeholder="Confirme a nova senha">
                        <button type="button" class="absolute inset-y-0 right-3 flex items-center">
                            <i class="fa-solid fa-eye text-gray-500"></i>
                        </button>
                    </div>

                </div>

                <div class="mb-4">
                    <button type="submit"
                        class="bg-primary text-white w-full py-2 rounded-md hover:bg-primary-300 duration-300 transition-colors cursor-pointer font-semibold text-base">
                        Redefinir Senha
                    </button>
                </div>
            </form>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-primary hover:underline">
                    <i class="fa-solid fa-arrow-left mr-1"></i>Voltar para login
                </a>
            </div>

            <div class="mt-8 text-center text-gray-400 text-xs">
                <a href="https://aceleraae.com.br/" target="_blank" class="hover:underline">Criado por AceleraAe</a>
            </div>
        </div>
    </div>
</x-layouts.layout>
