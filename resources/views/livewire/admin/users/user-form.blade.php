<div>
    @php
        use App\Enums\MilitaryRank;
        use App\Enums\FunctionsObserver;
    @endphp
    <x-layout.breadcrumb>
        <x-slot name="left">
            <h3 class="text-2xl font-bold cursor-pointer tracki dark:text-gray-50">
                {{ $breadcrumb }}
            </h3>
            <x-layout.button-back route="{{ $back }}"></x-layout.button-back>
        </x-slot>
    </x-layout.breadcrumb>
    <form>
        <x-layout.tabs>
            <x-slot name="nav">
                <x-layout.tabs-nav tab="tab1">
                    <x-slot name="svg">
                        <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g id="Complete">
                                <g id="info-circle">
                                    <g>

                                        <circle cx="12" cy="12" data-name="--Circle" fill="none"
                                            id="_--Circle" r="10" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" />

                                        <line fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" x1="12" x2="12"
                                            y1="12" y2="16" />

                                        <line fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" x1="12" x2="12"
                                            y1="8" y2="8" />
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </x-slot>
                    <x-slot name="title">Dados usuário</x-slot>
                </x-layout.tabs-nav>
                @if ($id)
                    <x-layout.tabs-nav tab="tab6">
                        <x-slot name="svg">
                            <svg fill="currentColor"
                                class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                                xmlns="http://www.w3.org/2000/svg" stroke="currentColor" viewBox="0 0 16 16"
                                version="1.1" id="svg8">
                                <path d="M8 1C3 1 3 7 3 7H2v8h12V7h-1s0-6-5-6zm0 2c3 0 3 4 3 4H5s0-4 3-4z" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">Dados pessoais</x-slot>
                    </x-layout.tabs-nav>
                    <x-layout.tabs-nav tab="tab2">
                        <x-slot name="svg">
                            <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.6471 16.375L12.0958 14.9623C11.3351 14.2694 10.9547 13.923 10.5236 13.7918C10.1439 13.6762 9.73844 13.6762 9.35878 13.7918C8.92768 13.923 8.5473 14.2694 7.78652 14.9623L4.92039 17.5575M13.6471 16.375L13.963 16.0873C14.7238 15.3944 15.1042 15.048 15.5352 14.9168C15.9149 14.8012 16.3204 14.8012 16.7 14.9168C17.1311 15.048 17.5115 15.3944 18.2723 16.0873L19.4237 17.0896M13.6471 16.375L17.0469 19.4528M17 9C17 10.1046 16.1046 11 15 11C13.8954 11 13 10.1046 13 9C13 7.89543 13.8954 7 15 7C16.1046 7 17 7.89543 17 9ZM21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">Foto</x-slot>
                    </x-layout.tabs-nav>
                    <x-layout.tabs-nav tab="tab3">
                        <x-slot name="svg">
                            <svg fill="currentColor"
                                class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                                xmlns="http://www.w3.org/2000/svg" stroke="currentColor" viewBox="0 0 16 16"
                                version="1.1" id="svg8">

                                <path d="M8 1C3 1 3 7 3 7H2v8h12V7h-1s0-6-5-6zm0 2c3 0 3 4 3 4H5s0-4 3-4z" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">Acessos</x-slot>
                    </x-layout.tabs-nav>
                    <x-layout.tabs-nav tab="tab4">
                        <x-slot name="svg">
                            <svg fill="currentColor"
                                class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                                xmlns="http://www.w3.org/2000/svg" stroke="currentColor" viewBox="0 0 16 16"
                                version="1.1" id="svg8">

                                <path d="M8 1C3 1 3 7 3 7H2v8h12V7h-1s0-6-5-6zm0 2c3 0 3 4 3 4H5s0-4 3-4z" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">Autorizações</x-slot>
                    </x-layout.tabs-nav>
                    <x-layout.tabs-nav tab="tab5">
                        <x-slot name="svg">
                            <svg fill="currentColor"
                                class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                                xmlns="http://www.w3.org/2000/svg" stroke="currentColor" viewBox="0 0 16 16"
                                version="1.1" id="svg8">

                                <path d="M8 1C3 1 3 7 3 7H2v8h12V7h-1s0-6-5-6zm0 2c3 0 3 4 3 4H5s0-4 3-4z" />
                            </svg>
                        </x-slot>
                        <x-slot name="title">Companhias</x-slot>
                    </x-layout.tabs-nav>
                @endif
            </x-slot>
            <x-slot name="content">
                <div id="tab1" x-show="activeTab === '#tab1'" class="block">
                    <div role="tabpanel"
                        class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                        <div class="grid gap-4 mb-1 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                            <div class="col-span-2 sm:col-span-1">
                                <label for="name" class="block text-sm font-medium text-gray-900 dark:text-white">
                                    Nome</label>
                                <input type="text" wire:model="name" placeholder="Nome" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="email" class="block text-sm font-medium text-gray-900 dark:text-white">
                                    Email</label>
                                <input type="email" wire:model="email" placeholder="Email" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('email')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="password" class="block text-sm font-medium text-gray-900 dark:text-white">
                                    Senha</label>
                                <input type="password" wire:model="password" placeholder="Senha" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('email')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="userGroups"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">
                                    Níveis de acesso
                                </label>
                                @foreach ($groups as $group)
                                    <div class="form-control">
                                        <label class="cursor-pointer label">
                                            <span
                                                class="text-gray-900 label-text dark:text-white">{{ $group->label() }}</span>
                                            <input wire:model="userGroups" type="checkbox"
                                                value="{{ $group->value }}" checked="checked"
                                                class="checkbox checkbox-accent" />
                                        </label>
                                    </div>
                                @endforeach
                                @error('userGroups')
                                    <span class="error">Necessário ao menos um nível de acesso</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                @if ($id)
                    <div id="tab6" x-show="activeTab === '#tab6'">
                        <div role="tabpanel"
                            class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                            <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">

                                <div class="col-span-full sm:col-span-2 ">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                        for="title">
                                        Posto / Graduação</label>
                                    <select wire:model="posto_grad"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option value="">Selecione...</option>
                                        @foreach (MilitaryRank::cases() as $item)
                                            <option value="{{ $item->value }}">{{ $item->label() }}</option>
                                        @endforeach
                                    </select>
                                    @error('posto_grad')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-span-full sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                        for="title">
                                        Nome guerra</label>
                                    <input type="text" wire:model="nick"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    @error('nick')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-span-full sm:col-span-1 ">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                        for="sex">
                                        Sexo</label>
                                    <select wire:model="sex"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option value="Selecione">...</option>
                                        <option value="M">M</option>
                                        <option value="F">F</option>
                                    </select>
                                    @error('sex')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-span-full sm:col-span-2 ">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                        for="title">
                                        Função</label>
                                    <select wire:model="function"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option value="">Selecione...</option>
                                        @foreach (FunctionsObserver::cases() as $item)
                                            <option value="{{ $item->value }}">{{ $item->label() }}</option>
                                        @endforeach
                                    </select>
                                    @error('function')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab2" x-show="activeTab === '#tab2'" class="block">
                        <div role="tabpanel"
                            class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                            @livewire('admin.users.user-upload-image', ['id' => $user->id])
                        </div>
                    </div>
                    <div id="tab3" x-show="activeTab === '#tab3'" class="block">
                        <div role="tabpanel"
                            class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                            @livewire('admin.users.user-accesses', ['user' => $user], key($user->id))
                        </div>
                    </div>
                    <div id="tab4" x-show="activeTab === '#tab4'" class="block">
                        <div role="tabpanel"
                            class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                            @livewire('admin.users.user-crud', ['user' => $user], key($user->id))
                        </div>
                    </div>
                    <div id="tab5" x-show="activeTab === '#tab5'" class="block">
                        <div role="tabpanel"
                            class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                            @livewire('admin.users.user-companies', ['user' => $user], key($user->id))
                        </div>
                    </div>
                @endif
            </x-slot>
        </x-layout.tabs>

    </form>
    <div class="px-4 text-right">
        <button type="submit" wire:click="save"
            class="text-white
                        bg-blue-700 hover:bg-blue-800
                        focus:ring-4 focus:outline-none focus:ring-blue-300
                        font-medium rounded-lg text-sm px-5 py-2.5
                        text-center dark:bg-blue-600 dark:hover:bg-blue-700
                        dark:focus:ring-blue-800">
            Salvar
        </button>
        <button type="submit" wire:click="save_out"
            class="text-white
                        bg-green-700 hover:bg-green-800
                        focus:ring-4 focus:outline-none focus:ring-green-300
                        font-medium rounded-lg text-sm px-5 py-2.5
                        text-center dark:bg-green-600 dark:hover:bg-green-700
                        dark:focus:ring-green-800">
            Salvar e sair
        </button>
    </div>
</div>
