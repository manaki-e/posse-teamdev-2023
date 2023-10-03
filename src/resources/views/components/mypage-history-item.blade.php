<tr onclick="location.href='/items/{{ $id }}';" class="hover:bg-gray-100 cursor-pointer">
    <th class="px-6 py-4">
        <div class="flex gap-2 font-mono">
            <div class="min-w-max">
                <img class="w-20 h-20 object-contain" src="{{ asset('images/'.$image_url) }}" alt="Product Image">
            </div>
            <div class="flex flex-col gap-2">
                <p>{{ $title }}</p>
                <div class="flex gap-4">
                    <div class="flex">
                        <svg xmlns=" http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                        <span class="flex-center">{{ $likes ?? '0' }}</span>
                    </div>
                    <span class="mt-0.5">{{ $point }}</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <img src="{{ $user_icon ?? '' }}" alt="ユーザアイコン" class="w-6 h-6 rounded-full object-cover object-center">
                    <span class="flex-center text-sm">{{ $user_name ?? '' }}</span>
                </div>
            </div>
        </div>
    </th>
    {{ $slot }}
    <td class="px-6 py-4 text-right whitespace-nowrap">{{ $borrowing_time }}</td>
    <td class="px-6 py-4 text-right whitespace-nowrap">{{ $return_time }}</td>
</tr>
