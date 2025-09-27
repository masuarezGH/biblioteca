<?php

namespace App\DataFixtures;

use App\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UsuarioFixture extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // 👤 Usuario normal
        $usuario = new Usuario();
        $usuario->setNombre('Juan');
        $usuario->setApellido('Pérez');
        $usuario->setUsername('juanp');
        $usuario->setEmail('juan@example.com');
        $usuario->setPassword(
            $this->passwordHasher->hashPassword($usuario, 'password123')
        );
        $usuario->setRol(['ROLE_USER']);
        $usuario->setTipo('usuario');
        $manager->persist($usuario);

        // 👤 Otro usuario
        $usuario2 = new Usuario();
        $usuario2->setNombre('Ana');
        $usuario2->setApellido('Gómez');
        $usuario2->setUsername('anag');
        $usuario2->setEmail('ana@example.com');
        $usuario2->setPassword(
            $this->passwordHasher->hashPassword($usuario2, 'password123')
        );
        $usuario2->setRol(['ROLE_USER']);
        $usuario2->setTipo('usuario');
        $manager->persist($usuario2);

        // 👑 Admin
        $admin = new Usuario();
        $admin->setNombre('Admin');
        $admin->setApellido('Principal');
        $admin->setUsername('admin');
        $admin->setEmail('admin@example.com');
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'admin123')
        );
        $admin->setRol(['ROLE_ADMIN']);
        $admin->setTipo('admin');
        $manager->persist($admin);

        // Guardar en la base de datos
        $manager->flush();
    }
}
