@props([
    'status' => null,
    'category' => null,
    'categories' => [],
    'date_from' => null,
    'date_to' => null,
])

<form method="GET" class="flex flex-wrap items-end gap-4 mb-4">
    <!-- status -->
    <div class="w-1/6">
        <x-input-label for="status" :value="__('Status')" />
        <select name="status" id="status"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            <option value="" {{ $status === null ? 'selected' : '' }}>{{ __('All') }}</option>
            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
            <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
        </select>
    </div>

    <!-- category -->

    <div class="w-1/6">
        <x-input-label for="category_id" :value="__('Category')" />
        <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            <option value="">-- {{ __('None') }} --</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ (string) $category === (string) $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- date from -->
    <div class="w-1/6">
        <x-input-label for="date_from" :value="__('From')" />
        <x-text-input id="date_from" name="date_from" type="date" value="{{ $date_from }}"
            class="mt-1 block w-full" />
    </div>

    <!-- date to -->
    <div class="w-1/6">
        <x-input-label for="date_to" :value="__('To')" />
        <x-text-input id="date_to" name="date_to" type="date" value="{{ $date_to }}"
            class="mt-1 block w-full" />
    </div>

    <div class="mt-6">
        <x-primary-button>
            {{ __('Filter') }}
        </x-primary-button>
    </div>
</form>

@if ($status || $category || $date_from || $date_to)
    <div class="mt-2">
        <a href="{{ route('tasks.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
            {{ __('Clear filters') }}
        </a>
    </div>
@endif
