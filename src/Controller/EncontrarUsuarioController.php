<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Manager\UsuarioManager;


class EncontrarUsuarioController extends AbstractController
{
#[Route('/perfil/{id}', name: 'usuario_perfil')]
public function perfil(UsuarioManager $usuarioManager, int $id): Response
{
$usuario = $usuarioManager->getUsuario($id);
if (!$usuario) {
throw $this->createNotFoundException('Usuario no encontrado');
}
return $this->render('usuario/perfil.html.twig', ['usuario' => $usuario]);
}
}