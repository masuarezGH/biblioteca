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
        // Redirige al catálogo como vista inicial
        return $this->redirectToRoute('libro_catalogo');
    }

    #[Route('/catalogo', name: 'libro_catalogo')]
    public function catalogo(Request $request, EntityManagerInterface $em): Response
    {
        $titulo = $request->query->get('titulo');
        $genero = $request->query->get('genero');
        $autor = $request->query->get('autor');

        $qb = $em->getRepository(Libro::class)->createQueryBuilder('l');

        if ($titulo) {
            $qb->andWhere('l.titulo LIKE :titulo')
               ->setParameter('titulo', '%' . $titulo . '%');
        }

        if ($genero) {
            $qb->andWhere('l.genero = :genero')
               ->setParameter('genero', $genero);
        }
        if ($autor) {
            $qb->andWhere('l.autor LIKE :autor')
                ->setParameter('autor', '%' . $autor . '%');
        }

        $libros = $qb->getQuery()->getResult();

        // Extraer todos los géneros para el select
        $generos = $em->getRepository(Libro::class)
                      ->createQueryBuilder('l')
                      ->select('DISTINCT l.genero AS genero')
                      ->getQuery()
                      ->getScalarResult();

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
