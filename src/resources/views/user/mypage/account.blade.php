<x-mypage-app>
    <style>
        input[type="text"]:focus {
            box-shadow: none !important;
        }
    </style>

    <x-slot:border_color>border-peer-perk</x-slot:border_color>
    <x-slot:title>アカウント情報編集</x-slot:title>
    <x-slot:earned_point>{{ Auth::user()->earned_point }}</x-slot:earned_point>
    <x-slot:distribution_point>{{ Auth::user()->distribution_point }}</x-slot:distribution_point>

    <div class="bg-white w-full">
        <div class="py-12">
            <div class="max-w-7xl mx-auto pl-4 space-y-6">
                <div class="border-2 shadow-md border-gray-200 rounded-lg px-8 py-4 w-full">
                    @include('profile.partials.update-profile-information-form')
                </div>
                <div class="border-2 shadow-md border-gray-200 rounded-lg px-8 py-4 w-full">
                    @include('profile.partials.update-password-form')
                </div>
                <div class="border-2 shadow-md border-red-600 rounded-lg px-8 py-4 w-full">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-mypage-app>
