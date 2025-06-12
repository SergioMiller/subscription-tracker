@extends('layout.app')

@section('content')

    <div class="mb-15 text-right">
        <a href="{{ route('subscriptions.create') }}"
           class="cursor-pointer text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Create subscriptions
        </a>
    </div>

    @if($paginator->isEmpty())
        <p class="lg:text-primary-700">Nothing found.</p>
    @else
        @include('subscriptions._list', ['paginator' => $paginator])
    @endif

@endsection
