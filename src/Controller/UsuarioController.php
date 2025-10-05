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

    #[Route('/perfil/editar', name: 'usuario_perfil_editar')]
    public function editarPerfil(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $usuario = $this->getUser();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hashear la nueva contraseña si se ha cambiado
            if ($form->get('password')->getData()) {
                $hashedPassword = $passwordHasher->hashPassword(
                    $usuario,
                    $form->get('password')->getData()
                );
                $usuario->setPassword($hashedPassword);
            }

            $em->persist($usuario);
            $em->flush();

            $this->addFlash('success', 'Perfil actualizado con éxito.');
            return $this->redirectToRoute('usuario_perfil');
        }

        return $this->render('usuario/editar_perfil.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
