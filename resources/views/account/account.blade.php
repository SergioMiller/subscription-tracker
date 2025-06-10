@extends('layout.app')

@section('content')

    <form class="max-w-sm mx-auto" method="post" action="{{ route('account.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label for="name"
                   class="block mb-2 text-sm font-medium text-gray-900 @error('name') text-red-700 @enderror">Name</label>
            <input type="text"
                   id="name"
                   name="name"
                   value="{{ old('name', $user->name ?? null) }}"
                   class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('name') border-red-500 text-red-900 placeholder-red-700 @enderror"/>
            @error('name')
            <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="email"
                   class="block mb-2 text-sm font-medium text-gray-900 @error('email') text-red-700 @enderror">Email</label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email', $user->email ?? null) }}"
                   class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('email') border-red-500 text-red-900 placeholder-red-700 @enderror"/>
            @error('email')
            <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="password"
                   class="block mb-2 text-sm font-medium text-gray-900 @error('password') text-red-700 @enderror">Password</label>

            <input type="password"
                   id="password"
                   name="password"
                   class="shadow-xs password-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('password') border-red-500 text-red-900 placeholder-red-700 @enderror"/>
            @error('password')
            <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                {{ $message }}
            </p>
            @enderror
        </div>


        <fieldset class="mb-5">
            <legend class="sr-only">Currencies</legend>

            @foreach($currencies as $currency)
                <div class="flex items-center mb-4">
                    <input id="country-option-{{ $currency->id }}"
                           type="radio"
                           name="default_currency_id"
                           value="{{ old('id', $currency->id) }}"
                           class="w-4 h-4 border-gray-300 cursor-pointer"
                        @checked($user->default_currency_id ?? null === $currency->id)
                    >
                    <label for="country-option-{{ $currency->id }}"
                           class="block ms-2  text-sm font-medium text-gray-900 cursor-pointer">
                        {{ $currency->name }}
                    </label>
                </div>
            @endforeach
            @error('default_currency_id')
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
