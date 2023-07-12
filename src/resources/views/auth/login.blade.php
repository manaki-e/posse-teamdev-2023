<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('メールアドレス')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('パスワード')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-between mt-4">
            <!-- Remember Me -->
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 shadow-sm" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('ログイン情報を保持する') }}</span>
            </label>
            <!-- fogot password -->
            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md" href="{{ route('password.request') }}">
                {{ __('パスワードを忘れた場合') }}
            </a>
            @endif
        </div>


        <div class="flex flex-col items-center mt-4">
            <x-user-register-button class="admin-bg-green text-center mb-1" textColor="text-white" bgColor="admin-bg-green" borderColor="admin-border-green">
                <x-slot:button>ログイン</x-slot:button>
            </x-user-register-button>
        </div>
    </form>

    <div class="flex-center flex-col mb-4 gap-2">
        <div class="w-full my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-gray-500 after:mt-0.5 after:flex-1 after:border-t after:border-gray-500">
            <p class="mx-4 mb-0 text-sm text-center text-gray-500">
                または
            </p>
        </div>
        <a href="{{ url('/login/slack') }}" class="rounded-lg border border-gray-300 py-3 px-3 font-sans text-xs font-bold text-gray-600 transition-all hover:opacity-75 focus:ring focus:ring-blue-200">
            <div class="flex items-center justify-between gap-3">
                <img alt="Slack" src="https://a.slack-edge.com/bv1-10/slack_logo-ebd02d1.svg" class="h-4" title="Slack">
                <p>で ログイン</p>
            </div>
        </a>
    </div>
</x-guest-layout>
