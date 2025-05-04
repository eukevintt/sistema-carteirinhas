<x-layouts.layout title="Detalhes do Usuário - Sistema Petros">
    <div x-data="{ openMenu: false }" class="min-h-screen flex flex-col md:flex-row">
        <x-sidebar-menu />
        <div class="flex-1 flex flex-col relative">
            <x-menu-mobile menuTitle="Detalhes do Usuário" />

            <main class="p-6 flex-1 space-y-6 bg-gray-50">
                <x-profile-photo-menu h1="Detalhes do Usuário" />

                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center text-gray-600 hover:text-gray-800 mb-4">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar
                </a>

                @if (session('error'))
                    <div class="mt-3 p-4 rounded-lg bg-red-100 border border-red-300 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <div x-data="formHandler()" x-init="init()">
                    <form x-data="{ role: 'none', option: '' }" action="{{ route('users.store') }}" method="POST"
                        enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf

                        <!-- Coluna Esquerda -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow p-6 space-y-6">
                            <h2 class="text-lg font-medium">Dados do Usuário</h2>

                            <div>
                                <label for="nickname"
                                    class="block text-sm font-medium text-gray-700 mb-1">Nickname</label>
                                <input type="text" name="nickname" id="nickname"
                                    class="block w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:ring-primary focus:outline-none" />
                                @error('nickname')
                                    <div class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Data de
                                    Nascimento</label>
                                <input type="date" name="birth_date" id="birth_date"
                                    class="block w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:ring-primary focus:outline-none" />
                                @error('birth_date')
                                    <div class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password"
                                        placeholder="Deixe em branco para manter a senha atual"
                                        class="block w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:ring-primary focus:outline-none" />

                                    <button type="button" class="absolute inset-y-0 right-3 flex items-center"
                                        onclick="togglePassword('password', 'togglePasswordIcon')">
                                        <i class="fa-solid fa-eye text-gray-500 cursor-pointer"
                                            id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700 mb-1">Confirme a Senha</label>

                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        placeholder="Deixe em branco para manter a senha atual"
                                        class="block w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:ring-primary focus:outline-none" />

                                    <button type="button" class="absolute inset-y-0 right-3 flex items-center"
                                        onclick="togglePassword('password_confirmation', 'togglePasswordIcon1')">
                                        <i class="fa-solid fa-eye text-gray-500 cursor-pointer"
                                            id="togglePasswordIcon1"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <div class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Nível</label>
                                <select name="role" id="role" x-model="role"
                                    class="block w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring focus:ring-primary">
                                    <option value="none">Selecione um Nível</option>
                                    @can('admin')
                                        <option value="admin">Administrador</option>
                                    @endcan
                                    <option value="management">Gerência</option>
                                    <option value="member">Associado</option>
                                    <option value="dependent">Dependente</option>
                                </select>
                                @error('role')
                                    <div class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <label for="photo" class="block mb-1 text-sm font-medium text-gray-700">Foto de
                                    Perfil</label>
                                <input type="file" name="photo" id="photo" accept="image/*"
                                    class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-gray-100 file:text-sm file:font-semibold cursor-pointer" />
                                @error('photo')
                                    <div class="text-red-500 text-sm mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Coluna Direita -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow p-6 space-y-4">
                            <h2 class="text-lg font-medium">Deseja vincular?</h2>

                            <div class="space-y-3">
                                <div class="flex items-start space-x-3">
                                    <input id="option" name="option" type="radio" x-model="option" value="none"
                                        class="mt-1 text-primary focus:ring-primary" checked>
                                    <label for="none" class="text-gray-700">Não vincular a um associado ou
                                        dependente</label>


                                </div>

                                <template x-if="role === 'none'">
                                    <div class="text-gray-500 text-sm mt-1">
                                        <p>Para vincular, é necessário selecionar algum nível para aparecer outras
                                            opções.</p>
                                    </div>
                                </template>

                                <!-- Associado -->
                                <template x-if="['admin', 'management', 'member'].includes(role)">
                                    <div class="space-y-3">
                                        <div class="flex items-start space-x-3">
                                            <input id="option" name="option" type="radio" x-model="option"
                                                value="new_member" class="mt-1 text-primary focus:ring-primary">
                                            <label for="new_member" class="text-gray-700">Criar um novo
                                                associado</label>
                                        </div>
                                        <div x-show="option === 'new_member'" class="space-y-2">
                                            <div>
                                                <input type="text" name="member_name" id="member_name"
                                                    class="block w-full rounded-lg border border-gray-300 px-2 py-2 focus:border-primary focus:ring-primary focus:outline-none"
                                                    placeholder="Digite o nome do Associado" />
                                                @error('member_name')
                                                    <div class="text-red-500 text-sm mt-1">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div>
                                                <input type="text" name="member_registration_number"
                                                    id="member_registration_number"
                                                    class="block w-full rounded-lg border border-gray-300 px-2 py-2 focus:border-primary focus:ring-primary focus:outline-none"
                                                    placeholder="Digite a matrícula do Associado" />
                                                @error('member_registration_number')
                                                    <div class="text-red-500 text-sm mt-1">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="flex items-start space-x-3">
                                            <input id="option" name="option" type="radio" x-model="option"
                                                value="existing_member" class="mt-1 text-primary focus:ring-primary">
                                            <label for="existing" class="text-gray-700">Vincular a um associado
                                                existente</label>
                                        </div>
                                        <div x-show="option === 'existing_member'">
                                            <select name="member_id" x-effect="initSelect2($el)"
                                                class="select2 w-full border rounded px-2 py-2">
                                                <option disabled value="none">Selecione um Associado</option>
                                                @foreach ($availableMembers as $member)
                                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('member_id')
                                                <div class="text-red-500 text-sm mt-1">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </template>

                                <!-- Dependente -->
                                <template x-if="role === 'dependent'">
                                    <div class="space-y-3">
                                        <div class="flex items-start space-x-3">
                                            <input id="option" name="option" type="radio" x-model="option"
                                                value="new_dependent" class="mt-1 text-primary focus:ring-primary">
                                            <label for="new_dependent" class="text-gray-700">Criar um novo
                                                dependente</label>
                                        </div>
                                        <div x-show="option === 'new_dependent'" class="space-y-2">
                                            <div>
                                                <input type="text" name="dependent_name" id="dependent_name"
                                                    class="block w-full rounded-lg border border-gray-300 px-2 py-2 focus:border-primary focus:ring-primary focus:outline-none"
                                                    placeholder="Nome do dependente" />
                                                @error('dependent_name')
                                                    <div class="text-red-500 text-sm mt-1">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div>
                                                <select name="dependent_member_id" x-effect="initSelect2($el)"
                                                    class="select2 w-full border rounded px-4 py-2">
                                                    <option disabled value="none">Selecione um Associado</option>
                                                    @foreach ($members as $member)
                                                        <option value="{{ $member->id }}">{{ $member->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('dependent_member_id')
                                                    <div class="text-red-500 text-sm mt-1">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="flex items-start space-x-3">
                                            <input id="option" name="option" type="radio" x-model="option"
                                                value="existing_dependent"
                                                class="mt-1 text-primary focus:ring-primary">
                                            <label for="existing_dependent" class="text-gray-700">Vincular a um
                                                dependente
                                                existente</label>
                                        </div>
                                        <div x-show="option === 'existing_dependent'">
                                            <select name="dependent_id" x-effect="initSelect2($el)"
                                                class="select2 w-full border rounded px-4 py-2">
                                                <option disabled value="none">Selecione um Dependente</option>
                                                @foreach ($availableDependents as $dependent)
                                                    <option value="{{ $dependent->id }}">{{ $dependent->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('dependent_id')
                                                <div class="text-red-500 text-sm mt-1">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </template>
                            </div>

                            @error('option')
                                <div class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Botões -->
                        <div class="md:col-span-2 flex justify-between md:justify-start md:gap-2 mt-2">
                            <button type="submit"
                                class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-300 transition cursor-pointer">
                                Criar Usuário
                            </button>
                        </div>
                    </form>
                </div>

                @if (session('success'))
                    <x-toasts.confirmation-toast msg="{{ session('success') }}" />
                @endif
            </main>
        </div>
    </div>


    <script>
        function formHandler() {
            return {
                role: 'none',
                option: 'none',

                init() {
                    // primeira inicialização em todos selects
                    this.$nextTick(() => {
                        this.initSelect2(this.$refs.memberSelect)
                        this.initSelect2(this.$refs.dependentSelect)
                    })
                },

                initSelect2(el) {
                    if (!el) return
                    // evita reinicializar se já tiver sido inicializado
                    if (!el.classList.contains('select2-hidden-accessible')) {
                        $(el).select2({
                            theme: 'tailwindcss-4',
                            // placeholder: 'Selecione uma opção.',
                            allowClear: true,
                            width: '100%',
                            language: {
                                noResults: function() {
                                    return 'Nenhum resultado encontrado.';
                                }
                            }
                        })
                    }
                }
            }
        }
    </script>
</x-layouts.layout>
