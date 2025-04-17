<div class="hidden md:flex items-center justify-between ">
    <h1 class="text-2xl font-semibold">{{ $h1 }}</h1>

    <a href="{{ route('profile.view') }}">
        <div
            class="flex items-center space-x-2 bg-gray-100 rounded-lg p-2 hover:scale-102  hover:bg-gray-200 duration-75">
            <img src="{{ route('users.photo', ['user' => auth()->user()->id]) }}"
                class="w-11 h-11 rounded-full object-cover" alt="Foto do usuário">

            <p class="text-lg font-medium">{{ Auth::user()->nickname }}</p>

            <i class="fa-solid fa-chevron-right text-sm"></i>
        </div>
    </a>
</div>
