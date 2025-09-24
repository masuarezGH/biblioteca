<?php
namespace App\Manager;


use App\Repository\LibroRepository;
use App\Entity\Libro;


class LibroManager
{
private LibroRepository $repo;


public function __construct(LibroRepository $repo)
{
$this->repo = $repo;
}


public function getLibros(): array
{
return $this->repo->findAll();
}


public function getLibro(int $id): ?Libro
{
return $this->repo->find($id);
}


public function getLibrosDisponibles(): array
{
return $this->repo->findDisponibles();
}
}