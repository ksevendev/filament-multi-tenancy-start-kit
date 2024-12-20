<div
    id="{{ $record->getKey() }}"
    wire:click="recordClicked('{{ $record->getKey() }}', {{ @json_encode($record) }})"
    class="record bg-white dark:bg-gray-700 rounded-lg px-4 py-2 cursor-grab font-medium text-gray-600 dark:text-gray-200"
    @if($record->timestamps && now()->diffInSeconds($record->{$record::UPDATED_AT}) < 3)
        x-data
        x-init="
            $el.classList.add('animate-pulse-twice', 'bg-primary-100', 'dark:bg-primary-800')
            $el.classList.remove('bg-white', 'dark:bg-gray-700')
            setTimeout(() => {
                $el.classList.remove('bg-primary-100', 'dark:bg-primary-800')
                $el.classList.add('bg-white', 'dark:bg-gray-700')
            }, 3000)
        "
    @endif
>
    <div class="flex gap-1 items-center">
        <x-heroicon-o-user class="text-gray-400  h-4 w-4" />
        {{ Str::limit($record->name ?? $record->lead->name, 35) }}
    </div>

    <div class="flex gap-2 items-center text-xs">
        <div class="flex gap-1 items-center text-xs">
            <x-heroicon-o-phone class="text-gray-400 h-4 w-4" />
            {{ $record->lead->phone }}
        </div>

        <div class="flex gap-1 items-center text-xs">
            <x-heroicon-o-envelope class="text-gray-400 h-4 w-4" />
            {{ $record->lead->email }}
        </div>
    </div>

    <div class="flex gap-2 items-center text-xs justify-between">
        <div class="flex gap-2">
            <span class="flex gap-1 align-items-center text-xs text-gray-400 dark:text-gray-500 mt-2">
                <x-heroicon-o-currency-dollar class="text-gray-400 h-4 w-4" />
                {{ Number::currency($record->valuation, 'BRL') }}
            </span>

            @if ($record->closing_forecast)
                <span class="flex gap-1 align-items-center text-xs text-gray-400 dark:text-gray-500 mt-2">
                    <x-heroicon-o-calendar-days class="text-gray-400 h-4 w-4" />
                    {{ $record->closing_forecast->format('d/m/Y') }}
                </span>
            @endif
        </div>

        <div class="flex gap-1 items-center text-xs">
            @if($record->user->avatar)
                <img src="{{ $record->user->getFilamentAvatarUrl() }}" alt="{{ $record->user->name }}" class="h-4 w-4 rounded-full">
            @else
                <span class="flex items-center justify-center h-4 w-4 rounded-full bg-gray-300 text-gray-500 p-2">
                    @php $initials = explode(' ', $record->user->name); @endphp
                    {{ $initials[0][0] }}{{ count($initials) > 1 ? $initials[1][0] : '' }}
                </span>
            @endif
        </div>

    </div>

    <div class="flex gap-1 align-items-center justify-between items-center text-xs text-gray-400 dark:text-gray-500 mt-2">

        @if ($record->origin)
            <span
                class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium"
                style="
                    border: 1px solid {{ $record->origin->color }};
                    color: {{ $record->origin->color }};
                    background-color: {{ $record->origin->color }}1A;
                "
            >
                {{ $record->origin->name }}
            </span>
        @endif

        <span class="flex gap-1">
            <x-heroicon-o-clock class="text-gray-400 h-4 w-4" />
            {{ $record->created_at->diffForHumans() }}
        </span>
    </div>
</div>
