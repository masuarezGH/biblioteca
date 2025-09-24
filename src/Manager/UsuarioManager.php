<?php
namespace App\Manager;


use App\Repository\UsuarioRepository;
use App\Entity\Usuario;


class UsuarioManager
{
private UsuarioRepository $repo;


public function __construct(UsuarioRepository $repo)
{
$this->repo = $repo;
}


public function getUsuarios(): array
{
return $this->repo->findAll();
}


public function getUsuario(int $id): ?Usuario
{
return $this->repo->find($id);
}
}