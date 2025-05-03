<div class="fixed bottom-5 right-5 z-50">
    <div id="toast-success"
        class="flex items-center w-full max-w-xs p-4 mb-4 text-white rounded-lg shadow bg-primary font-medium"
        role="alert">
        <div
            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 rounded-lg dark:text-green-200">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
        </div>
        <div class="ml-3 text-sm font-normal">{{ $msg }}</div>
        <button type="button"
            class="ml-auto -mx-1.5 -my-1.5 text-white rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 inline-flex items-center justify-center h-8 w-8 dark:hover:text-white cursor-pointer"
            onclick="this.parentElement.parentElement.remove()" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
</div>

<audio id="toast-sound" src="{{ asset('sounds/success.mp3') }}" preload="auto"></audio>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toast = document.getElementById('toast-success');
        const sound = document.getElementById('toast-sound');
        if (toast && sound) {
            sound.volume = 1;
            sound.play().catch(e => console.warn("Erro ao tocar som:", e));
        }

        setTimeout(() => {
            toast?.remove();
        }, 10000);
    });
</script>
