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

            @if(in_array($subscription->getKey(), $active_subscriptions, true))
                <a class="text-yellow-400" href="javascript:void(0);"
                   onclick="event.preventDefault(); return submit(this)"
                   data-form="action-unsubscribe-{{ $subscription->getKey() }}">
                    unsubscribe
                </a>
                <form id="action-unsubscribe-{{ $subscription->getKey() }}"
                      class="hidden"
                      action="{{ route('subscriptions.unsubscribe', $subscription->getKey()) }}"
                      method="POST">
                    @csrf
                </form>
            @else
                <a class="text-green-400" href="javascript:void(0);"
                   onclick="event.preventDefault(); return submit(this)"
                   data-form="action-subscribe-{{ $subscription->getKey() }}">
                    subscribe
                </a>
                <form id="action-subscribe-{{ $subscription->getKey() }}"
                      class="hidden"
                      action="{{ route('subscriptions.subscribe', $subscription->getKey()) }}"
                      method="POST">
                    @csrf
                </form>
            @endif

            <a href="{{ route('subscriptions.edit', $subscription->getKey()) }}" class="text-blue-400">
                edit
            </a>

            <a class="text-red-400" href="javascript:void(0);"
               onclick="event.preventDefault(); return submit(this)"
               data-form="action-{{ $subscription->getKey() }}">
                delete
            </a>
            <form id="action-{{ $subscription->getKey() }}"
                  action="{{ route('subscriptions.destroy', $subscription->getKey()) }}"
                  method="POST">
                @csrf
                @method('delete')
            </form>
        </div>
    </div>
@endforeach

<script>
    function submit(link) {
        if (confirm('Are you sure you want to do this action?')) {
            document.getElementById(link.dataset.form).submit();
        }
    }
</script>
