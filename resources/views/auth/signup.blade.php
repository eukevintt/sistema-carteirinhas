<x-layouts.layout title="Cadastro - Sistema Petros">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <div class="hidden lg:block w-2/3 relative overflow-hidden">
            <img src="{{ asset('images/fundo-gremio-petros-login.jpg') }}" alt="Fundo do Grêmio Petros"
                class="object-cover w-full h-full">
        </div>

        <div class="w-full lg:w-1/3 flex flex-col justify-center px-8 py-10 bg-white overflow-y-auto">
            <div class="flex justify-center mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Logo do Grêmio Petros" class="w-44">
            </div>

            <div class="mb-6 flex flex-col items-center">
                <h1 class="text-3xl font-bold text-gray-800">Criar Conta</h1>
                <p class="text-gray-500 mt-1">Cadastre-se no sistema</p>
            </div>

            <form action="{{ route('auth.register') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label for="username" class="block mb-1 text-sm font-medium text-gray-700">Usuário*</label>
                    <input type="text" name="username" id="username" required
                        class="rounded-md w-full py-2 px-3 bg-gray-200 border border-gray-300 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none"
                        placeholder="Digite seu nome de usuário">
                </div>

                <div>
                    <label for="matricula" class="block mb-1 text-sm font-medium text-gray-700">Matrícula*</label>
                    <input type="text" name="matricula" id="matricula" required
                        class="rounded-md w-full py-2 px-3 bg-gray-200 border border-gray-300 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none"
                        placeholder="Digite sua matrícula">
                    <p class="text-xs text-gray-500 mt-1">Se não souber sua matrícula, consulte a gerência.</p>
                </div>

                <div>
                    <label for="birthdate" class="block mb-1 text-sm font-medium text-gray-700">Data de
                        Nascimento*</label>
                    <input type="date" name="birthdate" id="birthdate" required
                        class="rounded-md w-full py-2 px-3 bg-gray-200 border border-gray-300 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none cursor-pointer">
                </div>

                <div>
                    <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Senha*</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="rounded-md w-full py-2 px-3 pr-12 bg-gray-200 border border-gray-300 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none"
                            placeholder="Digite sua senha">
                        <button type="button" class="absolute inset-y-0 right-3 flex items-center">
                            <i class="fa-solid fa-eye text-gray-500"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block mb-1 text-sm font-medium text-gray-700">Confirmar
                        Senha*</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="rounded-md w-full py-2 px-3 pr-12 bg-gray-200 border border-gray-300 shadow-sm focus:ring-2 focus:ring-primary focus:outline-none"
                            placeholder="Confirme sua senha">
                        <button type="button" class="absolute inset-y-0 right-3 flex items-center">
                            <i class="fa-solid fa-eye text-gray-500"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="photo" class="block mb-1 text-sm font-medium text-gray-700">Foto de Perfil*</label>
                    <input type="file" name="photo" id="photo" accept="image/*" required
                        class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-gray-100 file:text-sm file:font-semibold cursor-pointer file:cursor-pointer">
                    <p class="text-xs text-gray-500 mt-1">OBS: Adicione uma foto em que o seu rosto apareça nitidamente.
                    </p>
                </div>

                <div>
                    <button type="submit"
                        class="bg-primary text-white w-full py-2 rounded-md hover:bg-primary-300 duration-300 transition-colors cursor-pointer font-semibold text-base">
                        Criar Conta
                    </button>
                </div>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-primary hover:underline">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Já tenho conta
                </a>
            </div>

            <div class="mt-8 text-center text-gray-400 text-xs">
                <a href="https://aceleraae.com.br/" target="_blank" class="hover:underline">Criado por AceleraAe</a>
            </div>
        </div>
    </div>
</x-layouts.layout>
