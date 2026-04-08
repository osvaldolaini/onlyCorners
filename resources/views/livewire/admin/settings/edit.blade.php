<div>

    <x-breadcrumb>
        <div class="grid grid-cols-8 gap-4 text-gray-600 ">
            <div class="col-span-6 justify-items-start">
                <h3 class="text-2xl font-bold tracki dark:text-gray-50">
                    Configurações
                </h3>
            </div>
        </div>
    </x-breadcrumb>
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
                    <x-slot name="title">Dados Gerais</x-slot>
                </x-layout.tabs-nav>
                <x-layout.tabs-nav tab="tab2">
                    <x-slot name="svg">
                        <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M13.6471 16.375L12.0958 14.9623C11.3351 14.2694 10.9547 13.923 10.5236 13.7918C10.1439 13.6762 9.73844 13.6762 9.35878 13.7918C8.92768 13.923 8.5473 14.2694 7.78652 14.9623L4.92039 17.5575M13.6471 16.375L13.963 16.0873C14.7238 15.3944 15.1042 15.048 15.5352 14.9168C15.9149 14.8012 16.3204 14.8012 16.7 14.9168C17.1311 15.048 17.5115 15.3944 18.2723 16.0873L19.4237 17.0896M13.6471 16.375L17.0469 19.4528M17 9C17 10.1046 16.1046 11 15 11C13.8954 11 13 10.1046 13 9C13 7.89543 13.8954 7 15 7C16.1046 7 17 7.89543 17 9ZM21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </x-slot>
                    <x-slot name="title">Logo</x-slot>
                </x-layout.tabs-nav>
            </x-slot>
            <x-slot name="content">
                <div id="tab1" x-show="activeTab === '#tab1'" class="block">
                    <div role="tabpanel"
                        class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                        <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
                            <div class="col-span-4">
                                <label for="name" class="block text-sm font-medium text-gray-900 dark:text-white">
                                    Nome</label>
                                <input type="text" wire:model="name" placeholder="Nome" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-1">
                                <label for="nick" class="block text-sm font-medium text-gray-900 dark:text-white">
                                    Sigla</label>
                                <input type="text" wire:model="nick" placeholder="Sigla"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('nick')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-1 ">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                    for="postalCode">CEP</label>
                                <input x-mask="99999-999"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    maxlength="10" placeholder="CEP" wire:model.lazy="postalCode">
                            </div>
                            {{-- <div class="col-span-2 ">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                    for="cpf_cnpj">CNPJ</label>
                                <input x-mask="99.999.999/9999-99"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    maxlength="20" placeholder="00.000.000/0000-00" wire:model.lazy="cpf_cnpj">
                            </div> --}}


                            <div class="col-span-full sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                    for="address">Rua</label>
                                <input
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Rua, Av, Travessa, etc" wire:model="address">
                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                    for="about">Bairro</label>
                                <input
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Bairro" wire:model="district">
                            </div>
                            <div class="col-span-full sm:col-span-1">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                    for="number">Número</label>
                                <input
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="nº" wire:model="number">
                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                    for="city">Cidade</label>
                                <input
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Cidade" wire:model="city">
                            </div>

                            <div class="col-span-full sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                    for="state">Estado</label>
                                <input
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="UF" x-mask="aa" wire:model="state" maxlength="2">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab2" x-show="activeTab === '#tab2'" class="block">
                    <div role="tabpanel"
                        class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                        <x-layout.action-loading></x-layout.action-loading>
                        <div class="col-span-full sm:col-span-3">
                            <label for="acronym">Logo e Favicon (500 x 500)</label>
                            @if ($uploadimage)
                                <img src="{{ $uploadimage->temporaryUrl() }}">
                                <div class="flex justify-between space-x-1">
                                    <button wire:click="excluirTemp()" type="button"
                                        class="text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Excluir
                                    </button>
                                </div>
                            @elseif ($logo)
                                <img src="{{ url('storage/logos-school/' . $this->logo_path) }}"
                                    wire:model="logo_path">
                                <div class="flex justify-end space-x-1">
                                    <button wire:click="excluirLogo()" type="button"
                                        class="text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Excluir
                                    </button>
                                </div>
                            @else
                                <div class="col-span-full sm:col-span-3">
                                    <form wire:submit.prevent="#">
                                        <div class="flex items-center justify-center w-full">
                                            <label for="dropzone-file"
                                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 20 16">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                    </svg>
                                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                            class="font-semibold">Clique
                                                            ou </span> arraste e solte</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or
                                                        JPEG (MAX.
                                                        500x500px)</p>
                                                </div>
                                                <div class="col-span-1" x-data="{ isUploading: false, progress: 0 }"
                                                    x-on:livewire-upload-start="isUploading = true"
                                                    x-on:livewire-upload-finish="isUploading = false"
                                                    x-on:livewire-upload-error="isUploading = false"
                                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                    <!-- File Input -->
                                                    <input id="dropzone-file" type="file" class="hidden"
                                                        wire:model="uploadimage" />

                                                    @error('uploadimage')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror

                                                    <!-- Progress Bar -->
                                                    <div x-show="isUploading">
                                                        <progress x-bind:value="progress"
                                                            class="w-56 progress progress-primary" value="0"
                                                            max="100"></progress>
                                                    </div>
                                                    <div wire:loading wire:target="uploadimage">Enviando...</div>
                                                </div>
                                                <input id="dropzone-file" type="file" class="hidden" />
                                            </label>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

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
