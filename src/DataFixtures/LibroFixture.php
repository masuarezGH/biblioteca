<?php

namespace App\DataFixtures;

use App\Enum\EstadoLibro;
use App\Entity\Libro;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LibroFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $libros = [
            [
                'titulo' => 'Cien años de soledad',
                'autor' => 'Gabriel García Márquez',
                'genero' => 'Realismo mágico',
                'descripcion' => 'La obra maestra de García Márquez que narra la historia de la familia Buendía en Macondo.',
                'imagen' => 'cien-anos.jpg',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'Don Quijote de la Mancha',
                'autor' => 'Miguel de Cervantes',
                'genero' => 'Clásico',
                'descripcion' => 'Las aventuras de Alonso Quijano, un hidalgo que enloquece leyendo libros de caballería.',
                'imagen' => 'quijote.jpg',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => '1984',
                'autor' => 'George Orwell',
                'genero' => 'Distopía',
                'descripcion' => 'Una sociedad controlada por el Gran Hermano y la vigilancia absoluta.',
                'imagen' => '1984.jpg',
                'estado' => 'Prestado',
            ],
            [
                'titulo' => 'Fahrenheit 451',
                'autor' => 'Ray Bradbury',
                'genero' => 'Ciencia ficción',
                'descripcion' => 'Un futuro donde los bomberos queman libros para evitar que la gente piense.',
                'imagen' => 'fahrenheit.jpg',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'Orgullo y prejuicio',
                'autor' => 'Jane Austen',
                'genero' => 'Romance',
                'descripcion' => 'La historia de Elizabeth Bennet y el señor Darcy en la Inglaterra del siglo XIX.',
                'imagen' => 'orgullo.jpg',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'El principito',
                'autor' => 'Antoine de Saint-Exupéry',
                'genero' => 'Fábula',
                'descripcion' => 'Un pequeño príncipe viaja por planetas reflexionando sobre la vida y la amistad.',
                'imagen' => 'principito.jpg',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'Crimen y castigo',
                'autor' => 'Fiódor Dostoyevski',
                'genero' => 'Novela psicológica',
                'descripcion' => 'Un joven estudiante lucha con la culpa tras cometer un asesinato.',
                'imagen' => 'crimen.jpg',
                'estado' => 'Prestado',
            ],
            [
                'titulo' => 'Matar a un ruiseñor',
                'autor' => 'Harper Lee',
                'genero' => 'Drama',
                'descripcion' => 'Un clásico sobre racismo y justicia en el sur de Estados Unidos.',
                'imagen' => 'ruisenor.jpg',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'La Odisea',
                'autor' => 'Homero',
                'genero' => 'Épica',
                'descripcion' => 'El viaje de Odiseo de regreso a Ítaca tras la guerra de Troya.',
                'imagen' => 'odisea.jpg',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'El Hobbit',
                'autor' => 'J.R.R. Tolkien',
                'genero' => 'Fantasía',
                'descripcion' => 'La aventura de Bilbo Bolsón junto a un grupo de enanos para recuperar un tesoro.',
                'imagen' => 'hobbit.jpg',
                'estado' => 'Disponible',
            ],
            // ➡️ Agregamos 10 más para llegar a 20
            [
                'titulo' => 'La sombra del viento',
                'autor' => 'Carlos Ruiz Zafón',
                'genero' => 'Misterio',
                'descripcion' => 'Un joven descubre un libro maldito que cambiará su vida para siempre.',
                'imagen' => 'sombra.jpg',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'Los juegos del hambre',
                'autor' => 'Suzanne Collins',
                'genero' => 'Distopía',
                'descripcion' => 'Katniss Everdeen lucha por sobrevivir en un cruel reality show futurista.',
                'imagen' => 'hambre.jpg',
                'estado' => 'Prestado',
            ],
            [
                'titulo' => 'It',
                'autor' => 'Stephen King',
                'genero' => 'Terror',
                'descripcion' => 'Un grupo de amigos se enfrenta a un ser maligno que adopta la forma de payaso.',
                'imagen' => 'it.jpg',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'Harry Potter y la piedra filosofal',
                'autor' => 'J.K. Rowling',
                'genero' => 'Fantasía',
                'descripcion' => 'La primera aventura del joven mago Harry Potter en Hogwarts.',
                'imagen' => 'hp1.jpg',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'El alquimista',
                'autor' => 'Paulo Coelho',
                'genero' => 'Fábula',
                'descripcion' => 'La historia de Santiago y su búsqueda de un tesoro en Egipto.',
                'imagen' => 'alquimista.jpg',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'Drácula',
                'autor' => 'Bram Stoker',
                'genero' => 'Terror',
                'descripcion' => 'El clásico de vampiros que inmortalizó al conde Drácula.',
                'imagen' => 'dracula.jpg',
                'estado' => 'Prestado',
            ],
            [
                'titulo' => 'El nombre del viento',
                'autor' => 'Patrick Rothfuss',
                'genero' => 'Fantasía',
                'descripcion' => 'Kvothe relata su vida y su aprendizaje en la Universidad.',
                'imagen' => 'viento.jpg',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'La Iliada',
                'autor' => 'Homero',
                'genero' => 'Épica',
                'descripcion' => 'El relato de la guerra de Troya y la cólera de Aquiles.',
                'imagen' => 'iliada.jpg',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'Rayuela',
                'autor' => 'Julio Cortázar',
                'genero' => 'Experimental',
                'descripcion' => 'Una novela que puede leerse en múltiples órdenes.',
                'imagen' => 'rayuela.jpg',
                'estado' => 'Disponible',
            ],
            [
                'titulo' => 'El señor de los anillos',
                'autor' => 'J.R.R. Tolkien',
                'genero' => 'Fantasía',
                'descripcion' => 'La gran saga épica de la Tierra Media y la lucha contra Sauron.',
                'imagen' => 'lotr.jpg',
                'estado' => 'Disponible',
            ],
        ];

        foreach ($libros as $data) {
            $libro = new Libro();
            $libro->setTitulo($data['titulo']);
            $libro->setAutor($data['autor']);
            $libro->setGenero($data['genero']);
            $libro->setDescripcion($data['descripcion']);
            $libro->setImagen($data['imagen']);
            $libro->setEstado(
                $data['estado'] === 'Disponible'
                ? EstadoLibro::DISPONIBLE
                : EstadoLibro::PRESTADO
        );
            $manager->persist($libro);
        }

        $manager->flush();
    }
}
