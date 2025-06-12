@extends('layout.app')

@section('content')

    <h2 class="mb-5">My subscription</h2>

    @include('user-subscriptions._filter')

    @if($paginator->isEmpty())
        <p class="lg:text-primary-700">Nothing found.</p>
    @else

        @include('user-subscriptions._forecast', ['forecast' => $forecast])

        @include('user-subscriptions._stat', ['stat' => $stat])

        @include('user-subscriptions._list', ['items' => $items])

    @endif

@endsection
