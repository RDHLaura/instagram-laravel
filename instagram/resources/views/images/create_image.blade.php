<x-app-layout>
    <x-guest-layout>
        <x-auth-card>
            <x-slot name="logo">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </x-slot>
            <form method="POST" action="{{ route('images.store') }}" enctype="multipart/form-data">
                @csrf
                <!-- Imagen -->
                <div>
                    <x-avatar-input />
                    <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                </div>
                <!-- Descripción de la imagen -->
                <div class="mt-4">
                    <x-input-label for="description" :value="__('Description')" />
                    <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
                <input type="hidden" name="user_id" value ="{{ Auth::user()->id}}">
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Subir') }}
                    </x-primary-button>
                </div>
            </form>
        </x-auth-card>
    </x-guest-layout>
</x-app-layout>
