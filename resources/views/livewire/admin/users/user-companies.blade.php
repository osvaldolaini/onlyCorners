<div id="companies-checkbox">
    <x-user-accesses-section title="Todos" description="Acesso a todos os formulários">
        <div class="col-span-full lg:col-span-3">
            <ul
                class="grid items-center w-full grid-cols-3 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600 ">
                    <div class="flex items-center justify-between px-3">
                        <label
                            class="flex items-center w-full py-3 mx-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            <svg class="w-6 h-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.5 2A1.5 1.5 0 004 3.5V4h12v-.5A1.5 1.5 0 0014.5 2h-9zM2 7.5A1.5 1.5 0 013.5 6h13A1.5 1.5 0 0118 7.5V8H2v-.5zm-1 4A1.5 1.5 0 012.5 10h15a1.5 1.5 0 011.5 1.5v7a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 011 18.5v-7z"
                                    fill="currentColor" />
                            </svg>
                            <span class="ml-2">Todos</span>
                        </label>
                        <div class="flex text-right cursor-pointer custom-checkbox-companies "
                            wire:click="changeCompanies('all')" data-value="all">
                            @if (in_array('all', $inputCompanies))
                                <svg class="block w-6 h-6 transition duration-100 rounded-md checked bg-cyan-500 "
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="Interface / Check">
                                        <path id="Vector" d="M6 12L10.2426 16.2426L18.727 7.75732" stroke="#000000"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                </svg>
                            @else
                                <svg class="block w-6 h-6 transition duration-100 rounded-md border-cyan-500 checked "
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" fill="white" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M7.25007 2.38782C8.54878 2.0992 10.1243 2 12 2C13.8757 2 15.4512 2.0992 16.7499 2.38782C18.06 2.67897 19.1488 3.176 19.9864 4.01358C20.824 4.85116 21.321 5.94002 21.6122 7.25007C21.9008 8.54878 22 10.1243 22 12C22 13.8757 21.9008 15.4512 21.6122 16.7499C21.321 18.06 20.824 19.1488 19.9864 19.9864C19.1488 20.824 18.06 21.321 16.7499 21.6122C15.4512 21.9008 13.8757 22 12 22C10.1243 22 8.54878 21.9008 7.25007 21.6122C5.94002 21.321 4.85116 20.824 4.01358 19.9864C3.176 19.1488 2.67897 18.06 2.38782 16.7499C2.0992 15.4512 2 13.8757 2 12C2 10.1243 2.0992 8.54878 2.38782 7.25007C2.67897 5.94002 3.176 4.85116 4.01358 4.01358C4.85116 3.176 5.94002 2.67897 7.25007 2.38782Z"
                                        fill="currenteColor" />
                                </svg>
                            @endif
                        </div>
                    </div>
                </li>

                @foreach ($companies as $item)
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600 ">
                        <div class="flex items-center justify-between px-3">
                            <label
                                class="flex items-center w-full py-3 mx-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                <svg class="w-6 h-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.5 2A1.5 1.5 0 004 3.5V4h12v-.5A1.5 1.5 0 0014.5 2h-9zM2 7.5A1.5 1.5 0 013.5 6h13A1.5 1.5 0 0118 7.5V8H2v-.5zm-1 4A1.5 1.5 0 012.5 10h15a1.5 1.5 0 011.5 1.5v7a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 011 18.5v-7z"
                                        fill="currentColor" />
                                </svg>
                                <span class="ml-2">{{ $item->nick }}</span>
                            </label>
                            <div class="flex text-right cursor-pointer custom-checkbox-companies "
                                wire:click="changeCompanies('{{ $item->id }}')" data-value="{{ $item->id }}">
                                @if (in_array($item->id, $inputCompanies) || in_array('all', $inputCompanies))
                                    <svg class="block w-6 h-6 transition duration-100 rounded-md checked bg-cyan-500 "
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="Interface / Check">
                                            <path id="Vector" d="M6 12L10.2426 16.2426L18.727 7.75732"
                                                stroke="#000000" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </g>
                                    </svg>
                                @else
                                    <svg class="block w-6 h-6 transition duration-100 rounded-md border-cyan-500 checked "
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="24" height="24" fill="white" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M7.25007 2.38782C8.54878 2.0992 10.1243 2 12 2C13.8757 2 15.4512 2.0992 16.7499 2.38782C18.06 2.67897 19.1488 3.176 19.9864 4.01358C20.824 4.85116 21.321 5.94002 21.6122 7.25007C21.9008 8.54878 22 10.1243 22 12C22 13.8757 21.9008 15.4512 21.6122 16.7499C21.321 18.06 20.824 19.1488 19.9864 19.9864C19.1488 20.824 18.06 21.321 16.7499 21.6122C15.4512 21.9008 13.8757 22 12 22C10.1243 22 8.54878 21.9008 7.25007 21.6122C5.94002 21.321 4.85116 20.824 4.01358 19.9864C3.176 19.1488 2.67897 18.06 2.38782 16.7499C2.0992 15.4512 2 13.8757 2 12C2 10.1243 2.0992 8.54878 2.38782 7.25007C2.67897 5.94002 3.176 4.85116 4.01358 4.01358C4.85116 3.176 5.94002 2.67897 7.25007 2.38782Z"
                                            fill="currenteColor" />
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
    </x-user-accesses-section>

    <script>
        document.addEventListener('livewire:init', () => {
            setTimeout(() => {
                // let checkboxes_inputs = document.querySelectorAll('#companies-checkbox input[type="checkbox"]');
                let checkboxs_companies = document.querySelectorAll(
                    '#companies-checkbox .custom-checkbox-companies');
                let values = [];
                checkboxs_companies.forEach(function(checkboxs_company) {
                    // values.push(checkbox.values);
                    values.push(checkboxs_company.getAttribute('data-value'));
                });
                Livewire.dispatch('updateCheckboxCompanies', {
                    val: values
                });
                console.log(values);
            }, 500);
        });
    </script>
</div>
