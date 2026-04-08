<div class="col-span-full sm:col-span-3">
    <label for="acronym">Foto (300 x 400)</label>
    <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
        <!-- Profile Photo File Input -->
        <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo"
            x-on:change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                photoPreview = e.target.result;
                            };
                            reader.readAsDataURL($refs.photo.files[0]);
                    " />

        <x-label for="photo" value="{{ __('Photo') }}" />

        <!-- Current Profile Photo -->
        <div class="mt-2" x-show="! photoPreview">
            <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                class="object-cover w-20 h-20 rounded-full">
        </div>

        <!-- New Profile Photo Preview -->
        <div class="mt-2" x-show="photoPreview" style="display: none;">
            <span class="block w-20 h-20 bg-center bg-no-repeat bg-cover rounded-full"
                x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
            </span>
        </div>

        <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
            {{ __('Select A New Photo') }}
        </x-secondary-button>

        @if ($this->user->profile_photo_path)
            <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                {{ __('Remove Photo') }}
            </x-secondary-button>
        @endif

        <x-input-error for="photo" class="mt-2" />
    </div>

</div>
