@php

$selected = 'user-tab-text-green py-4 px-6 block border-b-4 font-bold user-border-green';
$unselected = 'text-gray-600 py-4 px-6 block';

@endphp

<div class="border-b-2">
    <div class="container mx-auto flex flex-wrap flex-col md:flex-row items-center">
        <nav class="flex flex-col sm:flex-row">
            <button class="{{ Request::routeIs('users.items*') ? $selected : $unselected }}">
                <a href="{{route('users.items')}}" class="">アイテム</a>
            </button>
            <button class="{{ Request::routeIs('users.requests*') ? $selected : $unselected }}">
                <a href="{{route('users.requests')}}" class="">リクエスト</a>
            </button>
            <button class="{{ Request::routeIs('users.events*') ? $selected : $unselected }}">
                <a href="{{route('users.events')}}" class="">イベント</a>
            </button>
        </nav>
    </div>
</div>

