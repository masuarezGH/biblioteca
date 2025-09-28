<?php

namespace App\Controller;

use App\Enum\EstadoLibro;
use App\Entity\Reserva;
use App\Entity\Libro;
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

        // Crear la reserva
        $reserva = new Reserva();
        $reserva->setUsuario($this->getUser());
        $reserva->setLibro($libro);
        $reserva->setFechaReserva(new \DateTime());

        // Cambiar estado del libro
        $libro->setEstado(EstadoLibro::PRESTADO);


        // Guardar en BD
        $em->persist($reserva);
        $em->persist($libro);
        $em->flush();

        $this->addFlash('success', 'Reserva realizada con éxito.');
        return $this->redirectToRoute('libro_detalle', ['id' => $libro->getId()]);
    }
}
