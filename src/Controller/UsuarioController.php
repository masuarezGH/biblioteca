<?php

namespace App\Controller;

use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Form\UsuarioType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UsuarioController extends AbstractController
{
    #[Route('/perfil', name: 'usuario_perfil')]
    public function perfil(EntityManagerInterface $em)
    {
        $usuario = $this->getUser();

        // Traer reservas activas del usuario
        $reservas = $em->getRepository(Reserva::class)->findBy([
            'socio' => $usuario,
            'estado' => 'Activa'
        ]);

        return $this->render('usuario/perfil.html.twig', [
            'usuario' => $usuario,
            'reservas' => $reservas,
        ]);
    }

}
