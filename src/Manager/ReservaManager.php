<?php
namespace App\Manager;


use App\Repository\ReservaRepository;
use App\Entity\Reserva;


class ReservaManager
{
private ReservaRepository $repo;


public function __construct(ReservaRepository $repo)
{
$this->repo = $repo;
}


public function getReservas(): array
{
return $this->repo->findAll();
}


public function getReserva(int $id): ?Reserva
{
return $this->repo->find($id);
}
}