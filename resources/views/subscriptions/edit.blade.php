@extends('layout.app')

@section('content')

    <form class="max-w-sm mx-auto" method="post" action="{{ route('subscriptions.update', $entity->getKey()) }}">
        @csrf
        @method('PUT')

        <h2 class="mb-5">Edit subscription</h2>

        <div class="mb-5">
            <label for="name"
                   class="block mb-2 text-sm font-medium text-gray-900 @error('name') text-red-700 @enderror">Name</label>
            <input type="text"
                   id="name"
                   name="name"
                   value="{{ old('name', $entity->name) }}"
                   class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('name') border-red-500 text-red-900 placeholder-red-700 @enderror"/>
            @error('name')
            <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="description"
                   class="block mb-2 text-sm font-medium text-gray-900 @error('description') text-red-700 @enderror">Description</label>
            <input type="text"
                   id="description"
                   name="description"
                   value="{{ old('description', $entity->description) }}"
                   class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('description') border-red-500 text-red-900 placeholder-red-700 @enderror"/>
            @error('description')
            <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="price"
                   class="block mb-2 text-sm font-medium text-gray-900 @error('price') text-red-700 @enderror">Price</label>

            <input type="number"
                   id="price"
                   name="price"
                   value="{{ old('price', $entity->getPrice()) }}"
                   class="shadow-xs password-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('price') border-red-500 text-red-900 placeholder-red-700 @enderror"/>
            @error('price')
            <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                {{ $message }}
            </p>
            @enderror
        </div>


        <fieldset class="mb-5">
            <legend class="sr-only">Currencies</legend>

            @foreach($currencies as $currency)
                <div class="flex items-center mb-4">
                    <input id="currency-option-{{ $currency->getKey() }}"
                           type="radio"
                           name="currency_id"
                           value="{{ $currency->getKey() }}"
                           class="w-4 h-4 border-gray-300 cursor-pointer"
                        @checked(($entity->currency_id ?? null) === $currency->getKey())
                    >
                    <label for="currency-option-{{ $currency->getKey() }}"
                           class="block ms-2  text-sm font-medium text-gray-900 cursor-pointer">
                        {{ $currency->name }}
                    </label>
                </div>
            @endforeach
            @error('currency_id')
            <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                {{ $message }}
            </p>
            @enderror
        </fieldset>

        <fieldset class="mb-5">
            <legend class="sr-only">Types</legend>

            @foreach($types as $key =>$value)
                <div class="flex items-center mb-4">
                    <input id="type-option-{{ $key }}"
                           type="radio"
                           name="type"
                           value="{{ old('type', $key) }}"
                           class="w-4 h-4 border-gray-300 cursor-pointer"
                        @checked(old('type', $entity->type->value) === $entity->type->value)
                    >
                    <label for="type-option-{{ $key }}"
                           class="block ms-2  text-sm font-medium text-gray-900 cursor-pointer">
                        {{ $value }}
                    </label>
                </div>
            @endforeach
            @error('type')
            <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                {{ $message }}
            </p>
            @enderror
        </fieldset>

        <button type="submit"
                class="cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Save
        </button>
    </form>

@endsection
