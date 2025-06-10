@extends('layout.app')

@section('content')

    <div class="mb-15 text-right">
        <a href="{{ route('subscriptions.create') }}"
           class="cursor-pointer text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Create subscription
        </a>
    </div>

    @if($paginator->isEmpty())
        <p class="lg:text-primary-700">Nothing found.</p>
    @else
        @foreach($paginator as $subscription)
            <div class="p-3 border-1 border-gray-200 rounded-md mb-5 flex flex-wrap justify-between">
                <div>
                    <p class="lg:text-primary-800 text-gray-800">{{ $subscription->name }}</p>
                    <p class="text-gray-500">{{ $subscription->description }}</p>
                </div>
                <div class="text-right">
                    <p class="text-green-700 font-bold">
                        {{ $subscription->price }}{{ $subscription->currency->symbol }} per {{ $subscription->type->per() }}
                    </p>
                    <a href="#" class="text-red-400">
                        delete
                    </a>
                </div>
            </div>
        @endforeach
    @endif

@endsection
