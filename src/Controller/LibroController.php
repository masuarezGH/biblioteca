<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Manager\LibroManager;


class LibroController extends AbstractController
{
#[Route('/', name: 'libro_listar')]
public function listar(LibroManager $libroManager): Response
{
$libros = $libroManager->getLibrosDisponibles();
return $this->render('libro/lista.html.twig', ['libros' => $libros]);
}


#[Route('/libro/{id}', name: 'libro_detalle')]
public function detalle(LibroManager $libroManager, int $id): Response
{
$libro = $libroManager->getLibro($id);
if (!$libro) {
throw $this->createNotFoundException('Libro no encontrado');
}
return $this->render('libro/detalle.html.twig', ['libro' => $libro]);
}
}