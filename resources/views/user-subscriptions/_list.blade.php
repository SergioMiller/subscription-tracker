@foreach($items as $subscription)
    <div class="p-3 border-1 border-gray-200 rounded-md mb-5 flex flex-wrap justify-between">
        <div>
            <p class="lg:text-primary-800 text-gray-800 mb-2">{{ $subscription->subscription->name }}</p>
            <p class="lg:text-primary-800 text-gray-800 mb-2">
                {{ $subscription->status }}
            </p>
            <p class="text-gray-500">{{ $subscription->subscription->description }}</p>
        </div>
        <div class="text-right">
            <p>
                <span class="text-green-700 font-bold">
                    {{ $subscription->getUserPrice() }} {{ $subscription->getUserCurrency()->symbol }}
                </span>
                <span class="text-gray-500"> per {{ $subscription->subscription->type->per() }}</span>
            </p>
            <p class="text-gray-600">
                Start at:
                <span class="text-gray-500">{{ $subscription->start_at->format('M, d Y H:i') }}</span>
            </p>
            <p class="text-gray-600">
                Finish at:
                <span class="text-gray-500">{{ $subscription->finish_at->format('M, d Y H:i') }}</span>
            </p>
        </div>
    </div>
@endforeach
