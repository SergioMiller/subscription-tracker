<div class="mb-5">
    <p>Next month: {{ $forecast->getTotal30() }} {{ $forecast->getCurrency()->symbol }}</p>
    <p>Next year: {{ $forecast->getTotal365() }} {{ $forecast->getCurrency()->symbol }}</p>
</div>
