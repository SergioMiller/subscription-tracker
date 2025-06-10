<?php
declare(strict_types=1);

namespace App\Service\Subscription\Dto;

use App\Enums\Subscription\SubscriptionTypeEnum;

final readonly class StoreDto
{
    public function __construct(
        private string $name,
        private string $description,
        private float|null $price,
        private int $currencyId,
        private SubscriptionTypeEnum $type,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'],
            price: (float) $data['price'],
            currencyId: (int) $data['currency_id'],
            type: SubscriptionTypeEnum::from($data['type']),
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float|null
    {
        return $this->price;
    }

    public function getCurrencyId(): int
    {
        return $this->currencyId;
    }

    public function getType(): SubscriptionTypeEnum
    {
        return $this->type;
    }
}
