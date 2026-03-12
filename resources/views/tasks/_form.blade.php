@props(['task' => null, 'categories' => []])

<form method="POST" action="{{ $task ? route('tasks.update', $task) : route('tasks.store') }}">
    @csrf
    @if ($task)
        @method('PUT')
    @endif

    <!-- Title -->
    <div>
        <x-input-label for="title" :value="__('Title')" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
            value="{{ old('title', $task?->title) }}" required autofocus />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <!-- Description -->
    <div class="mt-4">
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" name="description"
            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
            rows="3">{{ old('description', $task?->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <!-- Category -->
    <div class="mt-4">
        <x-input-label for="category_id" :value="__('Category')" />
        <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            <option value="">-- {{ __('None') }} --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $task?->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
    </div>

    <!-- Task date -->
    <div class="mt-4">
        <x-input-label for="task_date" :value="__('Due date')" />
        <x-text-input id="task_date" name="task_date" type="date" class="mt-1 block w-full"
            value="{{ old('task_date', optional($task?->task_date)->format('Y-m-d')) }}" />
        <x-input-error :messages="$errors->get('task_date')" class="mt-2" />
    </div>

    <!-- Recurring -->
    <div class="mt-4">
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_recurring" value="1"
                {{ old('is_recurring', $task?->is_recurring) ? 'checked' : '' }}
                class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" />
            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recurring') }}</span>
        </label>
    </div>

    <div class="mt-4">
        <x-primary-button>
            {{ $task ? __('Update') : __('Create') }}
        </x-primary-button>
    </div>
</form>
