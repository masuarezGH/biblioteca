<?php
namespace App\Repository;

use App\Entity\Libro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LibroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Libro::class);
    }

    /**
     * @return Libro[]
     */
    public function findDisponibles(): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.estado = :estado')
            ->setParameter('estado', 'disponible')
            ->getQuery()
            ->getResult();
    }

    /**
     * Buscar libros por género
     * 
     * @return Libro[]
     */
    public function findByGenero(string $genero): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.genero = :genero')
            ->setParameter('genero', $genero)
            ->getQuery()
            ->getResult();
    }
}
