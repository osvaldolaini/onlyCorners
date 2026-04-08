<div id="main-header" class="bg-white/80 shadow transition duration-300">
    <div class="container mx-auto flex items-center justify-between px-4 py-8">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="text-xl font-bold text-indigo-600">
            {{ $settings->title ?? 'Minha Empresa' }}
        </a>

        {{-- Menu Desktop --}}
        <nav class="hidden md:flex space-x-6">
            <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600">Início</a>
            <a href="{{ url('/sobre') }}" class="text-gray-700 hover:text-indigo-600">Sobre</a>
            <a href="{{ url('/contato') }}" class="text-gray-700 hover:text-indigo-600">Contato</a>
        </nav>

        {{-- Botão menu mobile --}}
        <div class="md:hidden">
            <button id="btn-open-menu" aria-label="Abrir menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Fundo escuro para menu mobile --}}
    <div id="backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300"></div>

    {{-- Menu lateral mobile --}}
    <nav id="mobile-menu"
        class="fixed top-0 left-0 w-64 h-full bg-white z-50 shadow-lg transform -translate-x-full transition-transform duration-300 p-6 space-y-4">
        <div class="flex justify-between items-center mb-4">
            <span class="font-bold text-lg text-indigo-600">Menu</span>
            <button id="btn-close-menu" aria-label="Fechar menu" class="text-gray-700 hover:text-red-600">
                ✕
            </button>
        </div>
        <a href="{{ url('/') }}" class="block text-gray-700 hover:text-indigo-600">Início</a>
        <a href="{{ url('/sobre') }}" class="block text-gray-700 hover:text-indigo-600">Sobre</a>
        <a href="{{ url('/contato') }}" class="block text-gray-700 hover:text-indigo-600">Contato</a>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openBtn = document.getElementById('btn-open-menu');
            const closeBtn = document.getElementById('btn-close-menu');
            const menu = document.getElementById('mobile-menu');
            const backdrop = document.getElementById('backdrop');
            const header = document.getElementById('main-header');

            function openMenu() {
                menu.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                header.classList.add('bg-white');
            }

            function closeMenu() {
                menu.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                header.classList.remove('bg-white'); // se quiser manter transparente em desktop
            }

            openBtn.addEventListener('click', openMenu);
            closeBtn.addEventListener('click', closeMenu);
            backdrop.addEventListener('click', closeMenu);
        });
    </script>
</div>
