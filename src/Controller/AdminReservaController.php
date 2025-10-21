<?php

namespace App\Controller;

use App\Entity\Libro;
use App\Entity\Reserva;
use App\Enum\EstadoLibro;
use App\Enum\EstadoReserva;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/reservas')]
#[IsGranted("ROLE_ADMIN")]
class AdminReservaController extends AbstractController
{
    #[Route('/', name: 'admin_reservas')]
    public function index(EntityManagerInterface $em): Response
    {
        //  el index muestra SOLO las pendientes
        $reservas = $em->getRepository(Reserva::class)->findBy([
            'estado' => EstadoReserva::PENDIENTE
        ]);

        return $this->render('admin/reservas/index.html.twig', ['reservas' => $reservas]);
    }

    #[Route('/aprobar/{id}', name: 'admin_reserva_aprobar')]
    public function aprobar(Reserva $reserva, EntityManagerInterface $em): Response
    {
        $reserva->setEstado(EstadoReserva::ACTIVA);
        $reserva->getLibro()->setEstado(EstadoLibro::PRESTADO);
        $em->flush();

        $this->addFlash('success', 'Reserva aprobada.');
        return $this->redirectToRoute('admin_reservas');
    }

    #[Route('/rechazar/{id}', name: 'admin_reserva_rechazar')]
    public function rechazar(Reserva $reserva, EntityManagerInterface $em): Response
    {
        $reserva->setEstado(EstadoReserva::RECHAZADA);
        $reserva->setFechaFin(new \DateTime()); // marcar la fecha de fin como hoy
        $reserva->getLibro()->setEstado(EstadoLibro::DISPONIBLE);
        $em->flush();

        $this->addFlash('info', 'Reserva rechazada.');
        return $this->redirectToRoute('admin_reservas');
    }

    #[Route('/rechazadas', name: 'admin_reservas_rechazadas')]
    public function rechazadas(EntityManagerInterface $em): Response
    {
        $reservas = $em->getRepository(Reserva::class)->findBy([
            'estado' => EstadoReserva::RECHAZADA
        ]);

        return $this->render('admin/reservas/rechazadas.html.twig', ['reservas' => $reservas]);
    }

    #[Route('/activas', name: 'admin_reservas_activas')]
    public function activas(EntityManagerInterface $em): Response
    {
        $reservas = $em->getRepository(Reserva::class)->findBy([
            'estado' => EstadoReserva::ACTIVA
        ]);

        return $this->render('admin/reservas/activas.html.twig', [
            'reservas' => $reservas
        ]);
    }

    #[Route('/sin-devolver', name: 'admin_libros_sin_devolver')]
    public function sinDevolver(EntityManagerInterface $em): Response
    {
        $hoy = new \DateTime();
        $qb = $em->getRepository(Reserva::class)->createQueryBuilder('r')
            ->where('r.estado = :estado')
            ->andWhere('r.fechaFin < :hoy')
            ->setParameter('estado', EstadoReserva::ACTIVA)
            ->setParameter('hoy', $hoy);

        $reservas = $qb->getQuery()->getResult();

        return $this->render('admin/reservas/sin_devolver.html.twig', ['reservas' => $reservas]);
    }

    #[Route('/clientes-deudores', name: 'admin_clientes_deudores')]
    public function clientesDeudores(EntityManagerInterface $em): Response
    {
        $hoy = new \DateTime();
        $qb = $em->getRepository(Reserva::class)->createQueryBuilder('r')
            ->where('r.estado = :estado')
            ->andWhere('r.fechaFin < :hoy')
            ->setParameter('estado', EstadoReserva::ACTIVA)
            ->setParameter('hoy', $hoy);

        $reservasVencidas = $qb->getQuery()->getResult();

        return $this->render('admin/reservas/deudores.html.twig', [
            'reservas' => $reservasVencidas
        ]);
    }

    #[Route('/finalizar/{id}', name: 'admin_reserva_finalizar')]
    public function finalizar(Reserva $reserva, EntityManagerInterface $em): Response
    {
        $reserva->setEstado(EstadoReserva::FINALIZADA);
        $reserva->setFechaFin(new \DateTime()); // marcar la fecha de fin como hoy
        $reserva->getLibro()->setEstado(EstadoLibro::DISPONIBLE);
        $em->flush();

        $this->addFlash('info', 'Reserva finalizada.');
        return $this->redirectToRoute('admin_reservas_activas');
    }
}
