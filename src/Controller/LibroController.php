<?php

namespace App\Controller;


use App\Entity\Libro;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibroController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function home(): Response
    {
        return $this->redirectToRoute('libro_catalogo');
    }

    #[Route('/catalogo', name: 'libro_catalogo')]
    public function catalogo(Request $request, EntityManagerInterface $em): Response
    {
        $titulo = $request->query->get('titulo');
        $genero = $request->query->get('genero');

        $qb = $em->getRepository(Libro::class)->createQueryBuilder('l');

        if ($titulo) {
            $qb->andWhere('l.titulo LIKE :titulo')
               ->setParameter('titulo', '%' . $titulo . '%');
        }

        if ($genero) {
            $qb->andWhere('l.genero = :genero')
               ->setParameter('genero', $genero);
        }

        $libros = $qb->getQuery()->getResult();

        // Extraer todos los géneros para el select
        $generos = $em->getRepository(Libro::class)
                      ->createQueryBuilder('l')
                      ->select('DISTINCT l.genero')
                      ->getQuery()
                      ->getResult();

        return $this->render('libro/catalogo.html.twig', [
            'libros' => $libros,
            'generos' => array_column($generos, 'genero'),
        ]);
    }

    #[Route('/catalogo/{id}', name: 'libro_detalle')]
    public function detalle(int $id, EntityManagerInterface $em): Response
    {
        $libro = $em->getRepository(Libro::class)->find($id);

        if (!$libro) {
            throw $this->createNotFoundException("El libro no existe");
        }

        return $this->render('libro/detalle.html.twig', [
            'libro' => $libro,
        ]);
    }

}
