<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Ник (логин) -->
        <div>
            <x-input-label for="username" :value="'Ник (логин)'" />
            <x-text-input id="username" class="block mt-1 w-full" 
                          type="text" 
                          name="username" 
                          :value="old('username')" 
                          required 
                          autofocus 
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Настоящее имя -->
        <div class="mt-4">
            <x-input-label for="full_name" :value="'Настоящее имя'" />
            <x-text-input id="full_name" class="block mt-1 w-full" 
                          type="text" 
                          name="full_name" 
                          :value="old('full_name')" 
                          required />
            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
        </div>

        <!-- Город -->
        <div class="mt-4">
            <x-input-label for="city_id" :value="'Город'" />
            <select id="city_id" name="city_id" 
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required>
                <option value="">Выберите город</option>
                @foreach(\App\Models\City::all() as $city)
                    <option value="{{ $city->id }}" 
                            {{ old('city_id') == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          required 
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" 
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
               href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>