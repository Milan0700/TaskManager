@props(['category' => null])

<form method="POST" action="{{ $category ? route('categories.update', $category) : route('categories.store') }}">
    @csrf
    @if($category)
        @method('PUT')
    @endif

    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $category?->name) }}" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-primary-button>
            {{ $category ? __('Update') : __('Create') }}
        </x-primary-button>
    </div>
</form>
