<?php

namespace App\Controller;

use App\Enum\EstadoLibro;
use App\Entity\Libro;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/libros')]
#[IsGranted("ROLE_ADMIN")]
class AdminLibroController extends AbstractController
{
    #[Route('/', name: 'admin_libros')]
    public function index(EntityManagerInterface $em): Response
    {
        $libros = $em->getRepository(Libro::class)->findAll();
        return $this->render('admin/libros/index.html.twig', ['libros' => $libros]);
    }

    #[Route('/eliminar/{id}', name: 'admin_libro_eliminar')]
    public function eliminar(Libro $libro, EntityManagerInterface $em): Response
    {
        $em->remove($libro);
        $em->flush();

        $this->addFlash('success', 'Libro eliminado correctamente.');
        return $this->redirectToRoute('admin_libros');
    }

    #[Route('/admin/libros/editar/{id}', name: 'admin_libro_editar')]
    public function editar(Libro $libro): Response
    {
        return $this->render('admin/libros/editar.html.twig', [
            'libro' => $libro,
        ]);
    }

    #[Route('/admin/libros/cambiar-estado/{id}', name: 'admin_libro_cambiar_estado')]
    public function cambiarEstado(Libro $libro, EntityManagerInterface $em): Response
    {
        if ($libro->getEstado() === EstadoLibro::PRESTADO) {
            $libro->setEstado(EstadoLibro::DISPONIBLE);
        } else {
            $libro->setEstado(EstadoLibro::PRESTADO);
        }

        $em->flush();

        $this->addFlash('success', 'Estado del libro actualizado.');
        return $this->redirectToRoute('admin_libro_editar', ['id' => $libro->getId()]);
    }

    // Podrías agregar aquí métodos para crear y editar libros
}
