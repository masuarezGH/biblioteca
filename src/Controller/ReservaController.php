<?php

namespace App\Controller;

use App\Entity\Reserva;
use App\Entity\Libro;
use App\Enum\EstadoLibro;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ReservaController extends AbstractController
{
    #[Route('/reserva/{id}', name: 'reserva_libro')]
    #[IsGranted("ROLE_USER")]
    public function reservar(Libro $libro, EntityManagerInterface $em)
    {
        // Si el libro ya está prestado, mostramos error
        if ($libro->getEstado() === EstadoLibro::PRESTADO) {
            $this->addFlash('error', 'El libro ya está prestado.');
            return $this->redirectToRoute('libro_detalle', ['id' => $libro->getId()]);
        }
        $usuario = $this->getUser();

        if (!$usuario->isEstado()) {
            $this->addFlash('danger', 'Tu cuenta aún no fue validada por un administrador. No podés reservar libros.');
            return $this->redirectToRoute('libro_catalogo');
        }

        // Crear la reserva
        $reserva = new Reserva();
        $reserva->setSocio($this->getUser()); // usa setSocio, no setUsuario
        $reserva->setLibro($libro);
        $reserva->setFechaInicio(new \DateTime());
        $reserva->setFechaFin((new \DateTime())->modify('+7 days'));
        $reserva->setEstado('Pendiente');

        // Cambiar estado del libro
        $libro->setEstado(EstadoLibro::PRESTADO);

        // Guardar en BD
        $em->persist($reserva);
        $em->persist($libro);
        $em->flush();

        $this->addFlash('success', 'Reserva realizada con éxito. Esperando confirmación del administrador.');
        return $this->redirectToRoute('libro_detalle', ['id' => $libro->getId()]);
    }

    #[Route('/reserva/devolver/{id}', name: 'reserva_devolver')]
    #[IsGranted("ROLE_ADMIN")]
    public function devolver(Reserva $reserva, EntityManagerInterface $em)
    {
        // Cambiar estado de la reserva
        $reserva->setEstado('Finalizada');
        $reserva->setFechaFin(new \DateTime());

        // Cambiar estado del libro
        $libro = $reserva->getLibro();
        $libro->setEstado(EstadoLibro::DISPONIBLE);

        $em->flush();

        $this->addFlash('success', 'El libro fue devuelto y está disponible nuevamente.');
        return $this->redirectToRoute('libro_catalogo'); // redirige al catálogo
    }
}
