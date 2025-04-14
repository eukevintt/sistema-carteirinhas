<x-layouts.layout title="Login - Sistema Petros">
    <div class="h-screen flex flex-row">
        <div class="hidden lg:block w-2/3 relative overflow-hidden">
            <img src="{{ asset('images/fundo-gremio-petros-login.jpg') }}"
                alt="Fundo de Login do Grêmio Petros, uma sala com uma mesa de sinuca e uma televisão"
                class="object-cover w-full h-full ">
        </div>

        <div class="w-full lg:w-1/3 flex flex-col justify-center px-8 py-10 bg-white">
            <div class="flex justify-center mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Logo do Grêmio Petros" class="w-44">
            </div>

            <div class="mb-6 flex flex-col items-center">
                <h1 class="text-3xl font-bold text-gray-800">Olá, como vai?</h1>
                <p class="text-gray-500 mt-1">Bem-vindo ao Sistema Petros</p>
            </div>

            <form>
                @csrf
                <div class="mb-4">
                    <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Usuário ou
                        Matrícula</label>
                    <input type="text" name="email" id="email" required
                        class="rounded-md w-full py-2 px-3 bg-gray-200 border border-gray-300 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none"
                        placeholder="Digite seu usuário ou matrícula">
                </div>

                <div class="mb-4">
                    <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Senha</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="bg-gray-200 border border-gray-300 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none rounded-md w-full py-2 px-3"
                            placeholder="Digite sua senha">
                        <button type="button" class="absolute inset-y-0 right-3 flex items-center">
                            <i class="fa-solid fa-eye text-gray-500"></i>
                        </button>
                    </div>

                </div>

                <div class="flex items-center justify-between mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="h-4 w-4 text-priamry border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-600">Lembre-me</span>
                    </label>
                    <a href="{{ route('auth.password.forgot.form') }}" class="text-sm text-primary hover:underline">
                        Esqueceu a senha?
                    </a>
                </div>

                <div class="mb-4">
                    <button type="submit"
                        class="bg-primary text-white w-full py-2 rounded-md hover:bg-primary-300 duration-300 transition-colors cursor-pointer font-semibold">
                        Entrar
                    </button>
                </div>
            </form>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Não tem conta?
                    <a href="{{ route('auth.register.form') }}" class="text-primary hover:underline">
                        Cadastre-se
                    </a>
                </p>
            </div>

            <div class="mt-8 text-center text-gray-400 text-xs">
                <a href="https://aceleraae.com.br/" target="_blank" class="hover:underline">Criado por AceleraAe</a>
            </div>
        </div>
    </div>
</x-layouts.layout>
