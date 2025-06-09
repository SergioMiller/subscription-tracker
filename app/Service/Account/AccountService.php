<?php
declare(strict_types=1);

namespace App\Service\Account;

use App\Entities\User;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Service\Account\Dto\UpdateDto;
use Illuminate\Contracts\Hashing\Hasher;

final readonly class AccountService
{
    public function __construct(
        private Hasher $hasher,
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function update(User $user, UpdateDto $data): User
    {
        $user->name = $data->getName();
        $user->email = $data->getEmail();
        $user->default_currency_id = $data->getDefaultCurrencyId();

        if ($password = $data->getPassword()) {
            $user->password = $this->hasher->make($password);
        }

        return $this->userRepository->save($user);
    }
}
