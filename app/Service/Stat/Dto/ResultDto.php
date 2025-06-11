<?php
declare(strict_types=1);

namespace App\Service\Stat\Dto;

use App\Entities\Currency;

final class ResultDto
{
    public function __construct(
        public int $quantity,
        public float $amount,
        public float $average,
        public Currency $currency,
    ) {
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getAverage(): float
    {
        return $this->average;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}
