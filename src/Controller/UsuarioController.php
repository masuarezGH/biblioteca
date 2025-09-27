<?php

namespace App\Controller;

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
    #[Route('/registro', name: 'usuario_registro')]
    public function registro(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encriptar contraseña
            $hashedPassword = $passwordHasher->hashPassword(
                $usuario,
                $usuario->getPassword()
            );
            $usuario->setPassword($hashedPassword);

            // Asignar valores por defecto
            $usuario->setRol(['ROLE_USER']); // rol normal
            $usuario->setEstado(false);      // pendiente de verificación
            $usuario->setTipo('socio');      // tipo socio

            $em->persist($usuario);
            $em->flush();

            $this->addFlash('success', 'Tu cuenta fue creada como socio. Espera la validación de un administrador.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registro.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
