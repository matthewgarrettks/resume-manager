<?php

namespace App\Repository;

use App\Entity\WorkExperience;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkExperience|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkExperience|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkExperience[]    findAll()
 * @method WorkExperience[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkExperienceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkExperience::class);
    }

    public function save(WorkExperience $x): void
    {
        $em = $this->getEntityManager();
        $em->persist($x);
        $em->flush();
    }

    public function delete(WorkExperience $x): void
    {
        $em = $this->getEntityManager();
        $em->remove($x);
        $em->flush();
    }
}
