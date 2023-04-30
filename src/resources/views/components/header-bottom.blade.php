@php

$selected = 'user-tab-text-green py-4 px-6 block border-b-4 font-bold user-border-green';
$unselected = 'text-gray-600 py-4 px-6 block';

@endphp


<div class="container mx-auto flex flex-wrap flex-col md:flex-row items-center border-b-2">
    <nav class="flex flex-col sm:flex-row">
        <button class="{{ Request::routeIs('users.items.*') ? $selected : $unselected }}">
            <a href="#" class="">アイテム</a>
        </button>
        <button class="{{ Request::routeIs('users.requests.*) ? $selected : $unselected }}">
            <a href="#" class="">リクエスト</a>
        </button>
        <button class="{{ Request::routeIs('users.events.*') ? $selected : $unselected }}">
            <a href="#" class="">イベント</a>
        </button>
    </nav>
</div>
