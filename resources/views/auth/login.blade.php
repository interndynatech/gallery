<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="font-[sans-serif] min-h-screen flex fle-col items-center justify-center px-4">
        <div class="grid md:grid-cols-2 items-center gap-4 max-w-6xl w-full">
            <div class="border border-gray-300 rounded-lg p-6 max-w-md shadow-[0_2px_22px_-4px_rgba(93,96,127,0.2)] max-md:mx-auto">
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <h3 class="text-teal-500 text-4xl font-bold pb-7">Sign in</h3>
                        <x-input-label for="name" :value="__('Name')" class="text-gray-800 text-sm mb-2 block" />
                        <x-text-input id="name" class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-teal-600" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>


                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-gray-800 text-sm mb-2 block" />
                        <div class="relative flex items-center">
                            <x-text-input id="password" class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-teal-600" type="password" name="password" required autocomplete="current-password" />
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                                <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
                            </svg>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex flex-wrap items-center justify-between gap-4 mt-4">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" class="h-4 w-4 shrink-0 text-teal-600 focus:ring-teal-500 border-gray-300 rounded" name="remember">
                            <label for="remember_me" class="ml-3 block text-sm text-gray-800">{{ __('Remember me') }}</label>
                        </div>
                    </div>

                    <div class="!mt-8">
                        <x-primary-button class="flex justify-center w-full shadow-xl py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-teal-600 hover:bg-teal-700 focus:outline-none">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
            <div class="lg:h-[400px] md:h-[300px] max-md:mt-8">
                <img src="{{asset('assets/images/svg-dyna-logo.svg')}}" class="w-full md:py-20 max-md:w-4/5 mx-auto block object-cover" alt="Dining Experience" />
            </div>
        </div>
    </div>
</x-guest-layout>