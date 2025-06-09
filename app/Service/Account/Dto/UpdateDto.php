<?php
declare(strict_types=1);

namespace App\Service\Account\Dto;

final readonly class UpdateDto
{
    public function __construct(
        private string $name,
        private string $email,
        private int $defaultCurrencyId,
        private string|null $password = null
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            defaultCurrencyId: (int) $data['default_currency_id'],
            password: $data['password'] ?? null,
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDefaultCurrencyId(): int
    {
        return $this->defaultCurrencyId;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
