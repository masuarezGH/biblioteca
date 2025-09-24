<?php
namespace App\Manager;


use App\Repository\ValidacionRepository;
use App\Entity\Validacion;


class ValidacionManager
{
private ValidacionRepository $repo;


public function __construct(ValidacionRepository $repo)
{
$this->repo = $repo;
}


public function getValidaciones(): array
{
return $this->repo->findAll();
}


public function getValidacion(int $id): ?Validacion
{
return $this->repo->find($id);
}
}