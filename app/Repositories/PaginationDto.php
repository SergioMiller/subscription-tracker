<?php
declare(strict_types=1);

namespace App\Repositories;

final readonly class PaginationDto
{
    protected const int DEFAULT_PER_PAGE = 10;

    protected const int DEFAULT_PAGE = 1;

    public function __construct(private array $data = [])
    {
    }

    public function getPage(): int|null
    {
        return isset($this->data['page']) ? (int) $this->data['page'] : static::DEFAULT_PAGE;
    }

    public function getPerPage(): int|null
    {
        return isset($this->data['per_page']) ? (int) $this->data['per_page'] : static::DEFAULT_PER_PAGE;
    }
}
