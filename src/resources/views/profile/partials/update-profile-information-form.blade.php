<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('プロフィール情報') }}
        </h2>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('氏名')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="display_name" :value="__('表示名')" />
            <x-text-input id="display_name" name="display_name" type="text" class="mt-1 block w-full" :value="old('display_name', $user->display_name)" required autofocus autocomplete="display_name" />
            <x-input-error class="mt-2" :messages="$errors->get('display_name')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    <form method="post" action="{{ route('mypage.account.slack') }}" class="ml-24 -mt-9">
        @csrf
        <x-secondary-button type="submit">
            <img src="{{ asset('slack.svg') }}" alt="" class="w-4 h-4 mr-4">
            {{ __('slack上の情報を取得する') }}
        </x-secondary-button>
    </form>
</section>
