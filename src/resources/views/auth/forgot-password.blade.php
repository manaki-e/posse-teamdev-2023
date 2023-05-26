<x-guest-layout>
    <div class="my-4 text-left text-sm text-gray-600">
        パスワードをリセットします。
        登録しているメールアドレスを入力してください。
        再設定用のURLを送信します
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('メールアドレス')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center my-4">
            <x-user-register-button class="admin-bg-green text-center mb-1" textColor="text-white" bgColor="admin-bg-green" borderColor="admin-border-green">
                <x-slot:button>メールを送信</x-slot:button>
            </x-user-register-button>
        </div>
    </form>
</x-guest-layout>
