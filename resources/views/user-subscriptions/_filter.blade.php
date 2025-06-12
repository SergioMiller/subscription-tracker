<div class="mb-5">
    <p class="mb-5">Filter</p>

    <form action="{{ route('user-subscriptions.index') }}">
        <div class="grid grid-cols-4 gap-4">
            <div>
                <p class="mb-4">Type</p>
                @foreach($filter['data']['type'] as $type)
                    <div class="flex items-center mb-4">
                        <input id="type-option-{{ $type }}"
                               type="radio"
                               name="type"
                               value="{{ $type }}"
                               class="w-4 h-4 border-gray-300 cursor-pointer"
                            @checked(($filter['filled']['type'] ?? []) === $type)
                        >
                        <label for="type-option-{{ $type }}"
                               class="block ms-2  text-sm font-medium text-gray-900 cursor-pointer">
                            {{ $type }}
                        </label>
                    </div>
                @endforeach
                @error('type')
                <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div>
                <p class="mb-4">Price</p>

                <div class="mb-4">
                    <input type="text"
                           id="price_min"
                           name="price_min"
                           placeholder="Min"
                           value="{{ old('price_min', $filter['filled']['price_min'] ?? null) }}"
                           class="shadow-xs password-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('price_min') border-red-500 text-red-900 placeholder-red-700 @enderror"/>
                    @error('price_min')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="mb-4">
                    <input type="text"
                           id="price_max"
                           name="price_max"
                           placeholder="Max"
                           value="{{ old('price_max', $filter['filled']['price_max'] ?? null) }}"
                           class="shadow-xs password-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('price_max') border-red-500 text-red-900 placeholder-red-700 @enderror"/>
                    @error('price_max')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div>
                    @foreach($filter['data']['price'] as $price)
                        <div class="flex items-center mb-4">
                            <input id="type-option-{{ $price }}"
                                   type="radio"
                                   name="price"
                                   value="{{ $price }}"
                                   class="w-4 h-4 border-gray-300 cursor-pointer"
                                @checked(($filter['filled']['price'] ?? 'converted') === $price)
                            >
                            <label for="type-option-{{ $price }}"
                                   class="block ms-2  text-sm font-medium text-gray-900 cursor-pointer">
                                {{ $price }}
                            </label>
                        </div>
                    @endforeach
                    @error('price')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                        {{ $message }}
                    </p>
                    @enderror
                    <p class="text-sm text-gray-500">
                        base - ціна яка вказана в підписці </br>
                        converted - ціна яка показана користувачу
                    </p>
                </div>

            </div>
            <div>
                <p class="mb-4">Month</p>

                <input type="month"
                       id="month"
                       name="month"
                       placeholder="Max"
                       value="{{ old('month', $filter['filled']['month'] ?? null) }}"
                       class="shadow-xs password-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('month') border-red-500 text-red-900 placeholder-red-700 @enderror"/>
                @error('month')
                <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                    {{ $message }}
                </p>
                @enderror
            </div>
        </div>

        <p class="text-right">
            <a class="text-blue-600 mr-5" href="{{ route('user-subscriptions.index') }}">Clear</a>
            <button class="text-green-600 cursor-pointer">Apply</button>
        </p>

    </form>
</div>
