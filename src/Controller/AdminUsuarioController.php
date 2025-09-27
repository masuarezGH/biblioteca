<?php

namespace App\Controller;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/usuarios')]
class AdminUsuarioController extends AbstractController
{
    #[Route('/', name: 'admin_usuarios_listar')]
    public function listar(EntityManagerInterface $em): Response
    {
        $usuarios = $em->getRepository(Usuario::class)->findAll();

        return $this->render('admin/usuarios/listar.html.twig', [
            'usuarios' => $usuarios,
        ]);
    }

    #[Route('/{id}/verificar', name: 'admin_usuarios_verificar')]
    public function verificar(Usuario $usuario, EntityManagerInterface $em): Response
    {
        $usuario->setEstado(true);
        $em->flush();

        $this->addFlash('success', 'El usuario fue verificado correctamente.');
        return $this->redirectToRoute('admin_usuarios_listar');
    }

    #[Route('/{id}/rechazar', name: 'admin_usuarios_rechazar')]
    public function rechazar(Usuario $usuario, EntityManagerInterface $em): Response
    {
        $usuario->setEstado(false);
        $em->flush();

        $this->addFlash('info', 'El usuario fue marcado como NO verificado.');
        return $this->redirectToRoute('admin_usuarios_listar');
    }
}
