<?php

namespace App\Controller;

use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Form\RegistroType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistroController extends AbstractController
{
    #[Route('/registro', name: 'usuario_registro')]
    public function registro(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $usuario = new Usuario();
        $form = $this->createForm(RegistroType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword(
                $usuario,
                $form->get('password')->getData()
            );
            $usuario->setPassword($hashedPassword);

            // valores por defecto
            $usuario->setRol(['ROLE_USER']);
            $usuario->setEstado(false);
            $usuario->setTipo('socio');

            $em->persist($usuario);
            $em->flush();

            $this->addFlash('success', 'Tu cuenta fue creada como socio. Espera la validación de un administrador.');

            return $this->redirectToRoute('app_login');
        }


        return $this->render('usuario/registro.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
