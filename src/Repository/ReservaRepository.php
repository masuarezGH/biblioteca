<?php
namespace App\Repository;

use App\Entity\Reserva;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReservaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reserva::class);
    }

    /**
     * @return Reserva[]
     */
    public function findByUsuario(int $usuarioId): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.socio = :usuarioId')
            ->setParameter('usuarioId', $usuarioId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reserva[]
     */
    public function findActivas(): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.estado = :estado')
            ->setParameter('estado', 'activa')
            ->getQuery()
            ->getResult();
    }
}
