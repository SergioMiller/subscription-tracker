<div class="mb-5">
    <p>Quantity: {{ $stat->getQuantity() }}</p>
    <p>Amount: {{ $stat->getAmount() }} {{ $stat->getCurrency()->symbol }}</p>
    <p>Average: {{ $stat->getAverage() }} {{ $stat->getCurrency()->symbol }}</p>
</div>
