<tr onclick="location.href='/items/{{ $id }}';" class="hover:bg-gray-100 cursor-pointer">
    <th class="px-6 py-4">
        <div class="flex gap-2 font-mono">
            <div class="min-w-max">
                <img class="w-20 h-20 object-contain" src="{{ asset('images/'.$image_url) }}" alt="Product Image">
            </div>
            <div class="flex flex-col gap-2">
                <p>{{ $title }}</p>
                <span class="text-xs font-bold">{{ $point }}</span>
                <div class="flex flex-wrap gap-2">
                    <img src="{{ $user_icon ?? '' }}" alt="ユーザアイコン" class="w-6 h-6 rounded-full object-cover object-center">
                    <span class="flex-center text-xs font-bold">{{ $user_name ?? '' }}</span>
                </div>
            </div>
        </div>
    </th>
    {{ $slot }}
    <td class="px-6 py-4 text-right whitespace-nowrap">{{ $borrowing_time }}</td>
    <td class="px-6 py-4 text-right whitespace-nowrap">{{ $return_time }}</td>
</tr>
