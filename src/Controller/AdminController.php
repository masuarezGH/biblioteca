<?php

namespace App\Controller;

use App\Entity\Libro;
use App\Entity\Usuario;
use App\Entity\Reserva;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(EntityManagerInterface $em): Response
    {
        $usuariosPendientes = $em->getRepository(Usuario::class)->findBy(['estado' => false]);
        $reservasPendientes = $em->getRepository(Reserva::class)->findBy(['estado' => 'Pendiente']);
        $reservasActivas = $em->getRepository(Reserva::class)->findBy(['estado' => 'Activa']);
        $reservasRechazadas = $em->getRepository(Reserva::class)->findBy(['estado' => 'Rechazada']);
        $librosPublicados = $em->getRepository(Libro::class)->findAll([]);

        $hoy = new \DateTime();
        $librosSinDevolver = $em->getRepository(Reserva::class)->createQueryBuilder('r')
            ->where('r.estado = :estado')
            ->andWhere('r.fechaFin < :hoy')
            ->setParameter('estado', 'Activa')
            ->setParameter('hoy', $hoy)
            ->getQuery()
            ->getResult();

        $clientesDeudores = $librosSinDevolver; // o lógica más específica

        $ultimasReservas = $em->getRepository(Reserva::class)->findBy([], ['fechaInicio' => 'DESC'], 5);

        return $this->render('admin/dashboard.html.twig', [
            'usuarios_pendientes' => $usuariosPendientes,
            'reservas_pendientes' => $reservasPendientes,
            'reservas_activas' => $reservasActivas,
            'reservas_rechazadas' => $reservasRechazadas,
            'libros_sin_devolver' => $librosSinDevolver,
            'clientes_deudores' => $clientesDeudores,
            'ultimas_reservas' => $ultimasReservas,
            'libros_publicados' => $librosPublicados,
        ]);
}

}
