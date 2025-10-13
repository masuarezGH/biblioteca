<?php

namespace App\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Enum\EstadoReserva;
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
    public function findByUsuario(Usuario $usuario): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.socio = :usuario')
            ->setParameter('usuario', $usuario)
            ->orderBy('r.fechaInicio', 'DESC')
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
            ->setParameter('estado', EstadoReserva::ACTIVA) 
            ->orderBy('r.fechaInicio', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reserva[]
     */
    public function findReservasActivasPorUsuario(Usuario $usuario): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.socio = :usuario')
            ->andWhere('r.estado = :estado')
            ->setParameter('usuario', $usuario)
            ->setParameter('estado', EstadoReserva::ACTIVA)
            ->orderBy('r.fechaInicio', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reserva[]
     */
    public function findHistorialPorUsuario(Usuario $usuario): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.socio = :usuario')
            ->setParameter('usuario', $usuario)
            ->orderBy('r.fechaInicio', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findHistorialPaginado(int $page = 1, int $limit = 5): Paginator
    {
        $query = $this->createQueryBuilder('r')
            ->orderBy('r.fechaInicio', 'DESC')
            ->getQuery()
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return new Paginator($query);
    }
}
