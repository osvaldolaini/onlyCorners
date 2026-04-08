<div class="flex items-center w-full">
    <div class="w-full text-center">
        <label class="items-center text-gray-900 swap swap-rotate dark:text-white">
            <!-- this hidden checkbox controls the state -->
            @if (auth()->user()->panel == 'admin')
                @if (in_array('admin', json_decode(auth()->user()->groups)))
                    <svg wire:click="togglePanel('user')" class="w-6 h-6 mx-auto" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve">
                        <g>
                            <path d="
                    M23,28L23,28c-1.1,0-2.1-0.7-2.5-1.8c0-0.1,0-0.2-0.1-0.2h-8.9c0,0.1,0,0.2-0.1,0.2C11.1,27.3,10.1,28,9,28h0
                    c-0.6,0-1,0.4-1,1s0.4,1,1,1h14c0.6,0,1-0.4,1-1S23.6,28,23,28z" fill="currentColor" />
                            <path
                                d="M27,3H5C3.3,3,2,4.3,2,6v15c0,1.7,1.3,3,3,3h6.9h8.1H27c1.7,0,3-1.3,3-3V6C30,4.3,28.7,3,27,3z"
                                fill="currentColor" />
                        </g>
                    </svg>
                @endif
            @else
                @if (in_array('user', json_decode(auth()->user()->groups)))
                    <svg wire:click="togglePanel('admin')" class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M4 21C4 17.4735 6.60771 14.5561 10 14.0709M19.8726 15.2038C19.8044 15.2079 19.7357 15.21 19.6667 15.21C18.6422 15.21 17.7077 14.7524 17 14C16.2923 14.7524 15.3578 15.2099 14.3333 15.2099C14.2643 15.2099 14.1956 15.2078 14.1274 15.2037C14.0442 15.5853 14 15.9855 14 16.3979C14 18.6121 15.2748 20.4725 17 21C18.7252 20.4725 20 18.6121 20 16.3979C20 15.9855 19.9558 15.5853 19.8726 15.2038ZM15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                @endif
            @endif
        </label>
    </div>
</div>
