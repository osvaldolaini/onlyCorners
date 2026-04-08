<footer class="bg-gray-900 text-white mt-auto py-8">
    <div class="container mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">

        <div>
            <h3 class="font-semibold mb-3">Sobre Nós</h3>
            <p class="text-gray-400 text-sm">
                Empresa especialista em contabilidade com transparência e agilidade.
            </p>
        </div>

        <div>
            <h3 class="font-semibold mb-3">Contato</h3>
            <ul class="text-gray-400 text-sm space-y-1">
                <li>📞 {{ $contact->phone ?? '(00) 0000-0000' }}</li>
                <li>✉️ {{ $contact->email ?? 'contato@empresa.com' }}</li>
                <li>📍 {{ $contact->address ?? 'Endereço não informado' }}</li>
            </ul>
        </div>

        <div>
            <h3 class="font-semibold mb-3">Redes Sociais</h3>
            <ul class="flex space-x-4">
                <li><a href="{{ $social->facebook ?? '#' }}" target="_blank" class="hover:text-blue-500">Facebook</a></li>
                <li><a href="{{ $social->twitter ?? '#' }}" target="_blank" class="hover:text-sky-400">Twitter</a></li>
                <li><a href="{{ $social->instagram ?? '#' }}" target="_blank" class="hover:text-pink-500">Instagram</a>
                </li>
            </ul>
        </div>

        <div>
            <h3 class="font-semibold mb-3">Newsletter</h3>
            <form class="flex flex-col sm:flex-row gap-2" method="POST" action="#">
                @csrf
                <input type="email" name="email" placeholder="Seu e-mail" required
                    class="rounded px-3 py-2 text-gray-900 flex-grow" />
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white rounded px-4 py-2">Assinar</button>
            </form>
        </div>

    </div>

    <div class="text-center text-xs text-gray-500 mt-8">
        &copy; {{ date('Y') }} {{ $settings->title ?? 'Minha Empresa' }}. Todos os direitos reservados.
    </div>
</footer>
