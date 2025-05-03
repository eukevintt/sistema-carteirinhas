<x-layouts.layout title="Editar Usuário - Sistema Petros">
    <div x-data="{ openMenu: false }" class="min-h-screen flex flex-col md:flex-row">
        <x-sidebar-menu />
        <div class="flex-1 flex flex-col relative">
            <x-menu-mobile menuTitle="Editar Usuário" />

            <main class="p-6 flex-1 space-y-6 bg-gray-50">
                <x-profile-photo-menu h1="Editar Usuário" />

                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center text-gray-600 hover:text-gray-800 mb-4">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
                </a>

                <div class="bg-slate-100 backdrop-blur-sm border border-gray-100 rounded-lg p-4 mb-6">
                    <div class="flex items-center space-x-6">
                        <img src="{{ route('users.photo', ['user' => $user->id]) }}"
                            alt="Foto de {{ $user->member ? $user->member->name : ($user->dependent ? $user->dependent->name : '') }}"
                            class="w-25 h-25 rounded-xl object-cover" />
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-900">
                                {{ $user->member ? $user->member->name : ($user->dependent ? $user->dependent->name : '') }}
                            </h2>
                            <p class="mt-1 text-xl text-gray-500">
                                Data de Nascimento: {{ optional($user->birth_date)->format('d/m/Y') }}
                            </p>
                            <p class="mt-1 text-xl text-gray-500">
                                Matrícula:
                                {{ $user->member ? $user->member->registration_number : ($user->dependent ? $user->dependent->registration_number : 'Não possui') }}
                            </p>
                        </div>
                    </div>
                </div>

                @if ($user->member)
                    <p class="text-sm text-gray-500 mb-6 text-center">Altere as informações do usuário abaixo e
                        clique em salvar. Se deseja alterar outras informações deste usuário, <a
                            class="text-primary hover:underline hover:text-primary-300 duration-200"
                            href="{{ route('members.edit', $user->member->id) }}">Clique aqui!</a>
                    </p>
                @elseif ($user->dependent)
                    <p class="text-sm text-gray-500 mb-6 text-center">Altere as informações do usuário abaixo e
                        clique em salvar. Se deseja alterar outras informações deste usuário, <a
                            class="text-primary hover:underline hover:text-primary-300 duration-200"
                            href="{{ route('dependents.edit', $user->dependent->id) }}">Clique aqui!</a>
                    </p>
                @endif

                <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nickname" class="block text-sm font-medium text-gray-700 mb-1">Nickname</label>
                        <input type="text" name="nickname" id="nickname"
                            value="{{ old('nickname', $user->nickname) }}"
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
                            value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}"
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
                                <i class="fa-solid fa-eye text-gray-500 cursor-pointer" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirme
                            a Senha</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Deixe em branco para manter a senha atual"
                                class="block w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:ring-primary focus:outline-none" />

                            <button type="button" class="absolute inset-y-0 right-3 flex items-center"
                                onclick="togglePassword('password_confirmation', 'togglePasswordIcon2')">
                                <i class="fa-solid fa-eye text-gray-500 cursor-pointer" id="togglePasswordIcon2"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div x-data="{ role: '{{ old('role', $user->role) }}' }">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Nível</label>

                        <select name="role" id="role" x-model="role"
                            class="block w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:ring-primary focus:outline-none">
                            @can('admin')
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador
                                </option>
                            @endcan
                            <option value="management" {{ $user->role === 'management' ? 'selected' : '' }}>Gerência
                            </option>
                            <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Associado
                            </option>
                            <option value="dependent" {{ $user->role === 'dependent' ? 'selected' : '' }}>
                                Dependente
                            </option>
                        </select>

                        <div x-show="role === 'member' || role === 'management' || role === 'admin'" class="mt-4"
                            x-transition>
                            <label for="member_id" class="block text-sm font-medium text-gray-700 mb-1">Associado
                                Vinculado</label>
                            <select name="member_id" id="member_id"
                                class="select2 block w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:ring-primary focus:outline-none"
                                x-ref="memberSelect"
                                :disabled="role !== 'member' && role != 'management' && role != 'admin'">
                                <option value="" {{ old('member_id', $user->member_id) ? '' : 'selected' }}>
                                    Selecione um associado ou deixe vazio
                                </option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}"
                                        {{ old('member_id', $user->member_id) == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }} ({{ $member->registration_number }})
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div x-show="role === 'dependent'" class="mt-4" x-transition>
                            <label for="dependent_id" class="block text-sm font-medium text-gray-700 mb-1">Dependente
                                Vinculado</label>
                            <select name="dependent_id" id="dependent_id"
                                class="select2 block w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-primary focus:ring-primary focus:outline-none"
                                x-ref="dependentSelect" :disabled="role !== 'dependent'">
                                <option value=""
                                    {{ old('dependent_id', $user->dependent_id) ? '' : 'selected' }}>
                                    Selecione um dependente ou deixe vazio
                                </option>
                                @foreach ($dependents as $dependent)
                                    <option value="{{ $dependent->id }}"
                                        {{ old('dependent_id', $user->dependent_id) == $dependent->id ? 'selected' : '' }}>
                                        {{ $dependent->name }} ({{ $dependent->registration_number }})
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        @error('password_confirmation')
                            <div class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label for="photo" class="block mb-1 text-sm font-medium text-gray-700">Foto de
                            Perfil*</label>
                        <input type="file" name="photo" id="photo" accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-gray-100 file:text-sm file:font-semibold cursor-pointer file:cursor-pointer">
                        <p class="text-xs text-gray-500 mt-1">
                        </p>

                        @error('photo')
                            <div class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full bg-primary hover:bg-primary-300 text-white font-medium text-lg px-6 py-4 rounded-lg transition cursor-pointer">
                            Salvar Alterações
                        </button>
                    </div>
                </form>

                @if (session('success'))
                    <x-toasts.confirmation-toast msg="{{ session('success') }}" />
                @endif
            </main>
        </div>
    </div>
</x-layouts.layout>
