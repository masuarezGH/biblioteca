<?php

namespace App\Controller;

use App\Entity\Libro;
use App\Entity\Usuario;
use App\Entity\Reserva;
use App\Enum\EstadoReserva;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/{page}', name: 'admin_dashboard', requirements: ['page' => '\d+'], defaults: ['page' => 1])]
    public function index(EntityManagerInterface $em, int $page): Response
    {
        // Usuarios pendientes (estado = false)
        $usuariosPendientes = $em->getRepository(Usuario::class)->findBy(['estado' => false]);

        // Reservas filtradas por estado usando Enum
        $reservasPendientes = $em->getRepository(Reserva::class)->findBy([
            'estado' => EstadoReserva::PENDIENTE
        ]);

        $hoy = new \DateTime();
        $reservasActivas = $em->getRepository(Reserva::class)->createQueryBuilder('r')
            ->where('r.estado = :estado')
            ->setParameter('estado', EstadoReserva::ACTIVA)
            ->getQuery()
            ->getResult();

        $reservasRechazadas = $em->getRepository(Reserva::class)->findBy([
            'estado' => EstadoReserva::RECHAZADA
        ]);

        // Libros publicados
        $librosPublicados = $em->getRepository(Libro::class)->findAll();

        // Libros sin devolver (reservas activas con fechaFin vencida)
        $hoy = new \DateTime();
        $librosSinDevolver = $em->getRepository(Reserva::class)->createQueryBuilder('r')
            ->where('r.estado = :estado')
            ->andWhere('r.fechaFin < :hoy')
            ->setParameter('estado', EstadoReserva::ACTIVA)
            ->setParameter('hoy', $hoy)
            ->getQuery()
            ->getResult();

        // Clientes deudores (usuarios con reservas sin devolver)
        $clientesDeudores = $librosSinDevolver;

        // Paginación de últimas reservas
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $totalReservas = $em->getRepository(Reserva::class)->count([]);

        $ultimasReservas = $em->getRepository(Reserva::class)->findBy(
            [],
            ['fechaInicio' => 'DESC'],
            $limit,
            $offset
        );

        $totalPages = (int) ceil($totalReservas / $limit);

        return $this->render('admin/dashboard.html.twig', [
            'usuarios_pendientes' => $usuariosPendientes,
            'reservas_pendientes' => $reservasPendientes,
            'reservas_activas' => $reservasActivas,
            'reservas_rechazadas' => $reservasRechazadas,
            'libros_sin_devolver' => $librosSinDevolver,
            'clientes_deudores' => $clientesDeudores,
            'ultimas_reservas' => $ultimasReservas,
            'libros_publicados' => $librosPublicados,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }
}
