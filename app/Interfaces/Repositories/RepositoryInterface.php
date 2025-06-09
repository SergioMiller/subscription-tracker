<?php
declare(strict_types=1);

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function entityClassName(): string;

    public function save(Model $entity): Model;

    public function getByKey(int $key): Model|null;

    public function destroy(Model $entity): bool;

    public function getAll(): Collection;
}
