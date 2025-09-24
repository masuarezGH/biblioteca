<?php
namespace App\Repository;

use App\Entity\Validacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ValidacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Validacion::class);
    }

    /**
     * @return Validacion[]
     */
    public function findPendientes(): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.estado = :estado')
            ->setParameter('estado', 'pendiente')
            ->getQuery()
            ->getResult();
    }
}
