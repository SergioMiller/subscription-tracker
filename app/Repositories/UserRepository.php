<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\User;
use App\Interfaces\Repositories\UserRepositoryInterface;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function entityClassName(): string
    {
        return User::class;
    }
}
