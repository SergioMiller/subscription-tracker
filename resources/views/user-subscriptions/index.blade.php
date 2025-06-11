@extends('layout.app')

@section('content')

    <h2 class="mb-5">My subscription</h2>

    @if($paginator->isEmpty())
        <p class="lg:text-primary-700">Nothing found.</p>
    @else
        @foreach($items as $subscription)
            <div class="p-3 border-1 border-gray-200 rounded-md mb-5 flex flex-wrap justify-between">
                <div>
                    <p class="lg:text-primary-800 text-gray-800 mb-2">{{ $subscription->subscription->name }}</p>
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
    @endif

@endsection

<script>
    function submit(link) {
        if (confirm('Are you sure you want to do this action?')) {
            document.getElementById(link.dataset.form).submit();
        }
    }
</script>
