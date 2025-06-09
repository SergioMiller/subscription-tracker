<?php
declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\Entities\User;

/**
 * @method User save(User $entity)
 * @method User|null getByKey(int $id)
 */
interface UserRepositoryInterface extends RepositoryInterface
{
}
