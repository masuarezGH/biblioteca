<?php

namespace App\Controller;

use App\Entity\Reserva;
use App\Enum\EstadoReserva;
use App\Manager\UsuarioManager;
use App\Repository\ReservaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EncontrarUsuarioController extends AbstractController
{
    #[Route('/perfil/{id}', name: 'usuario_perfil', requirements: ['id' => '\d+'])]
public function perfilUsuario(
    UsuarioManager $usuarioManager,
    ReservaRepository $reservaRepo,
    int $id
): Response {
    $usuario = $usuarioManager->getUsuario($id);

    if (!$usuario) {
        throw $this->createNotFoundException('Usuario no encontrado');
    }

    $reservasActivas = $reservaRepo->findReservasActivasPorUsuario($usuario);
    $historial = $reservaRepo->findHistorialPorUsuario($usuario);

    return $this->render('usuario/perfil.html.twig', [
        'usuario' => $usuario,
        'reservas_activas' => $reservasActivas,
        'historial' => $historial,
    ]);
}

}
