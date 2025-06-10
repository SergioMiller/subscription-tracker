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
                    <p class="lg:text-primary-800 text-gray-800 mb-2">{{ $subscription->name }}</p>
                    <p class="text-gray-500">{{ $subscription->description }}</p>
                </div>
                <div class="text-right">
                    <p>
                        <span class="text-green-700 font-bold">
                            {{ $subscription->getPrice() }} {{ $subscription->currency->symbol }}
                        </span>
                        <span class="text-gray-500"> per {{ $subscription->type->per() }}</span>
                    </p>
                    <a href="{{ route('subscriptions.edit', $subscription->getKey()) }}" class="text-blue-400">
                        edit
                    </a>
                    <a class="text-red-400" href="javascript:void(0);"
                       onclick="event.preventDefault(); return submit(this)"
                       data-form="action-{{ $subscription->getKey }}">
                        delete
                    </a>
                    <form id="action-{{ $subscription->getKey }}"
                          action="{{ route('subscriptions.destroy', $subscription->getKey()) }}"
                          method="POST">
                        @csrf
                        @method('delete')
                    </form>
                </div>
            </div>
        @endforeach
    @endif

@endsection

<script>
    function submit(link) {
        if (confirm('Are you sure you want to do this action?')) {
            document.getElementById(link.dataset.form).submit();
        }
    }
</script>
