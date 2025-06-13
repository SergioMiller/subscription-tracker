@if ($notification = session()->get('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
        <strong>{{ $notification }}</strong>
    </div>
@endif

@if ($notification = session()->get('error'))

    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
        <strong>{{ $notification }}</strong>
    </div>

@endif
