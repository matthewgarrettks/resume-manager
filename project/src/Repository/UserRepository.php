<?php

namespace App\Repository;

use App\Entity\SignUps;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user)
    {
        $manager = $this->getEntityManager();
        $manager->persist($user);
        $manager->flush();
    }

    public function delete(User $user)
    {
        $manager = $this->getEntityManager();
        $manager->remove($user);
        $manager->flush();
    }
}
