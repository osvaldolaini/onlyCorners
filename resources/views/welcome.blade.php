<x-layouts.page>

    @section('title', 'Página Inicial - Minha Empresa')
    @section('meta_description', 'Serviços contábeis especializados para pequenas empresas.')
    @section('meta_keywords', 'contabilidade, empresa, impostos')
    @section('meta_image', asset('images/home-banner.jpg'))



    <body class="relative h-screen antialiased text-white bg-gray-400 bg-cover">
        <div class="h-screen dark:bg-black">
            {{-- @livewire('navigation-menu') --}}
            <!-- Page Content -->
            <main class="h-screen dark:bg-gray-800">
                <div class="h-screen ">
                    <header class="z-30 flex items-center w-full h-24 sm:h-24">
                        <div class="container flex items-center justify-between px-6 mx-auto">
                            <div class="text-xl font-black text-gray-800 uppercase ">
                                {{ env('APP_NAME') }}
                            </div>
                        </div>
                    </header>
                    <div class="z-20 flex items-center dark:bg-gray-800">
                        <div class="container relative flex px-6 pt-10 pb-16 mx-auto">
                            <div class="relative z-20 flex flex-col sm:w-2/3 lg:w-2/5">
                                <span class="w-20 h-2 mb-12 bg-blue-800 ">
                                </span>
                                <h1 style="color:#4db17d;"
                                    class="flex flex-col font-black leading-none  uppercase text-7xl font-bebas-neue sm:text-8xl ">
                                    Only
                                    <span class="text-6xl text-blue-800 sm:text-7xl">
                                        Corners
                                    </span>
                                </h1>
                                <p class="text-lg text-black sm:text-base ">
                                    Ferramenta de análise de ESCANTEIOS
                                </p>
                                <div class="flex mt-8">
                                    <a href="{{ route('login') }}"
                                        class="px-4 py-2 mr-4 text-white uppercase bg-blue-800 border-2 border-transparent rounded-lg text-md hover:bg-blue-400">
                                        Entre
                                    </a>
                                    {{-- <a href="{{ route('register') }}"
                                        class="px-4 py-2 text-blue-800 uppercase bg-transparent border-2 border-blue-800 rounded-lg hover:bg-blue-800 hover:text-white text-md">
                                        Registre-se
                                    </a> --}}
                                </div>
                            </div>
                            <div class="relative hidden sm:block sm:w-1/3 lg:w-3/5">
                                <img src="{{ url('storage/logos/logo.png') }}" class="max-w-xs m-auto md:max-w-sm" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- @livewire('page.teste') --}}
            </main>
        </div>


        @stack('modals')

        @livewireScripts

        <script>
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/sw.js')
                    .then(() => console.log('Service Worker registrado'))
                    .catch((error) => console.log('Erro ao registrar Service Worker', error));
            }
        </script>
    </body>



</x-layouts.page>
