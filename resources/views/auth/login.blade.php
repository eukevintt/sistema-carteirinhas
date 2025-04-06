<x-layouts.layout title="Login - Sistema Petros">
    <div class="flex flex-col lg:flex-row h-screen w-full bg-white items-center justify-center">
        <!-- Left side (image) -->
        <div class="hidden lg:flex w-1/2 h-full">
            <img src="{{ asset('images/fundo-gremio-petros-login.jpg') }}" alt="Grêmio Petros"
                class="object-cover w-full h-full" />
        </div>

        <!-- Right side (form) -->
        <div class="flex items-center justify-center w-full lg:w-1/2">
            <div class="w-full max-w-lg px-10">
                <div class="flex flex-col items-center space-y-2">
                    <img src="{{ asset('images/logo.png') }}" class="w-44 md:w-52" alt="Logo">
                </div>
                <form class="w-full space-y-4 mt-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Login</label>
                        <input type="text" id="email"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-3 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none"
                            placeholder="Matrícula ou Usuário" />
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                        <div class="relative">
                            <input type="password" id="password"
                                class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-3 pr-12 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none"
                                placeholder="Digite sua senha" />
                            <button type="button"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700 cursor-pointer">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-primary text-white rounded-md hover:bg-[#057391ee] duration-300 cursor-pointer font-semibold text-base">Entrar</button>
                </form>
                <div class="flex items-center justify-between mt-6">
                    <a href="#" class="text-sm text-primary hover:underline">Esqueci minha senha</a>
                    <p class="text-center text-sm text-gray-600">Não tem uma conta? <a href="#"
                            class="text-primary hover:underline">Cadastre-se agora</a></p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.layout>
