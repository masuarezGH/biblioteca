<?php

namespace App\Controller;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/usuarios')]
#[IsGranted("ROLE_ADMIN")]
class AdminUsuarioController extends AbstractController
{
    #[Route('/', name: 'admin_usuarios')]
    public function index(EntityManagerInterface $em): Response
    {
        $usuarios = $em->getRepository(Usuario::class)->findAll();

        return $this->render('admin/usuarios/index.html.twig', [
            'usuarios' => $usuarios,
        ]);
    }

    #[Route('/verificar/{id}', name: 'admin_usuarios_verificar')]
    public function verificar(Usuario $usuario, EntityManagerInterface $em): Response
    {
        $usuario->setEstado(true); // asumimos que "estado" es booleano: verificado o no
        $em->flush();

        $this->addFlash('success', 'Usuario verificado correctamente.');
        return $this->redirectToRoute('admin_usuarios');
    }

    #[Route('/rechazar/{id}', name: 'admin_usuarios_rechazar')]
    public function rechazar(Usuario $usuario, EntityManagerInterface $em): Response
    {
        $usuario->setEstado(false);
        $em->flush();

        $this->addFlash('info', 'Usuario marcado como pendiente/rechazado.');
        return $this->redirectToRoute('admin_usuarios');
    }
}
