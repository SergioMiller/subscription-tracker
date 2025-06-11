<?php
declare(strict_types=1);

namespace App\Service\Forecast\Dto;

use App\Entities\Currency;

final class ResultDto
{
    public function __construct(
        public float $total30,
        public float $total365,
        public Currency $currency,
    ) {
    }

    public function getTotal30(): float
    {
        return $this->total30;
    }

    public function getTotal365(): float
    {
        return $this->total365;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}
