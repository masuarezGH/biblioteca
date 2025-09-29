<?php

namespace App\Controller;

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

    // Podrías agregar aquí métodos para crear y editar libros
}
