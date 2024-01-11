<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Exception\User\UserNotFoundException;
use phpDocumentor\Reflection\Types\Boolean;

class UserRepository extends BaseRepository
{
    protected static function entityClass(): string
    {
        return User::class;
    }


    public function findOneByEmailOrFail(string $email): User
    {
        if (null === $user = $this->objectRepository->findOneBy(['email' => $email]))
        {
            throw UserNotFoundException::fromEmail($email);
        }

        return $user;
    }


    /**
     * @param \App\Entity\User $user
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(User $user):void
    {
        $this->saveEntity($user);
    }


    /**
     * @param \App\Entity\User $user
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(User $user): void
    {
        $this->removeEntity($user);
    }

}