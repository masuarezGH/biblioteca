<?php

namespace App\DataFixtures;

use App\Entity\Reserva;
use App\Entity\Usuario;
use App\Entity\Libro;
use App\Enum\EstadoLibro;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReservaFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $hoy = new \DateTime();

        // Buscar usuarios por email
        $juan   = $manager->getRepository(Usuario::class)->findOneBy(['email' => 'juan@example.com']);
        $ana    = $manager->getRepository(Usuario::class)->findOneBy(['email' => 'ana@example.com']);
        $admin  = $manager->getRepository(Usuario::class)->findOneBy(['email' => 'admin@example.com']);
        $user1  = $manager->getRepository(Usuario::class)->findOneBy(['email' => 'user1@example.com']);
        $user2  = $manager->getRepository(Usuario::class)->findOneBy(['email' => 'user2@example.com']);

        // Buscar algunos libros
        $libro1 = $manager->getRepository(Libro::class)->findOneBy(['titulo' => 'Cien años de soledad']);
        $libro2 = $manager->getRepository(Libro::class)->findOneBy(['titulo' => 'Don Quijote de la Mancha']);
        $libro3 = $manager->getRepository(Libro::class)->findOneBy(['titulo' => '1984']);
        $libro4 = $manager->getRepository(Libro::class)->findOneBy(['titulo' => 'Fahrenheit 451']);
        $libro5 = $manager->getRepository(Libro::class)->findOneBy(['titulo' => 'El Hobbit']);
        $libro6 = $manager->getRepository(Libro::class)->findOneBy(['titulo' => 'El principito']);

        // --- Reserva Activa (Juan) ---
        if ($juan && $libro1) {
            $reserva = new Reserva();
            $reserva->setSocio($juan);
            $reserva->setLibro($libro1);
            $reserva->setFechaInicio((clone $hoy)->modify('-2 days'));
            $reserva->setFechaFin((clone $hoy)->modify('+5 days'));
            $reserva->setEstado('Activa');
            $libro1->setEstado(EstadoLibro::PRESTADO);
            $manager->persist($reserva);
        }

        // --- Reserva Pendiente (Ana) ---
        if ($ana && $libro2) {
            $reserva = new Reserva();
            $reserva->setSocio($ana);
            $reserva->setLibro($libro2);
            $reserva->setFechaInicio((clone $hoy));
            $reserva->setFechaFin((clone $hoy)->modify('+7 days'));
            $reserva->setEstado('Pendiente');
            $manager->persist($reserva);
        }

        // --- Reserva Rechazada (user1) ---
        if ($user1 && $libro3) {
            $reserva = new Reserva();
            $reserva->setSocio($user1);
            $reserva->setLibro($libro3);
            $reserva->setFechaInicio((clone $hoy)->modify('-3 days'));
            $reserva->setFechaFin((clone $hoy)->modify('+4 days'));
            $reserva->setEstado('Rechazada');
            $manager->persist($reserva);
        }

        // --- Reserva Finalizada (user2) ---
        if ($user2 && $libro4) {
            $reserva = new Reserva();
            $reserva->setSocio($user2);
            $reserva->setLibro($libro4);
            $reserva->setFechaInicio((clone $hoy)->modify('-10 days'));
            $reserva->setFechaFin((clone $hoy)->modify('-2 days'));
            $reserva->setEstado('Finalizada');
            $libro4->setEstado(EstadoLibro::DISPONIBLE);
            $manager->persist($reserva);
        }

        // --- Reserva Vencida (sin devolver) (Juan otra vez) ---
        if ($juan && $libro5) {
            $reserva = new Reserva();
            $reserva->setSocio($juan);
            $reserva->setLibro($libro5);
            $reserva->setFechaInicio((clone $hoy)->modify('-15 days'));
            $reserva->setFechaFin((clone $hoy)->modify('-5 days')); // ya venció
            $reserva->setEstado('Activa');
            $libro5->setEstado(EstadoLibro::PRESTADO);
            $manager->persist($reserva);
        }

        // --- Reservas del Admin ---
        if ($admin && $libro6) {
            // Admin con una reserva activa
            $reservaAdmin1 = new Reserva();
            $reservaAdmin1->setSocio($admin);
            $reservaAdmin1->setLibro($libro6);
            $reservaAdmin1->setFechaInicio((clone $hoy)->modify('-1 days'));
            $reservaAdmin1->setFechaFin((clone $hoy)->modify('+6 days'));
            $reservaAdmin1->setEstado('Activa');
            $libro6->setEstado(EstadoLibro::PRESTADO);
            $manager->persist($reservaAdmin1);

            // Admin con una reserva finalizada
            $reservaAdmin2 = new Reserva();
            $reservaAdmin2->setSocio($admin);
            $reservaAdmin2->setLibro($libro2);
            $reservaAdmin2->setFechaInicio((clone $hoy)->modify('-20 days'));
            $reservaAdmin2->setFechaFin((clone $hoy)->modify('-10 days'));
            $reservaAdmin2->setEstado('Finalizada');
            $manager->persist($reservaAdmin2);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UsuarioFixture::class,
            LibroFixture::class,
        ];
    }
}
