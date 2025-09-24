<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Manager\ReservaManager;


class ReservaController extends AbstractController
{
#[Route('/reservas', name: 'reserva_listar')]
public function listar(ReservaManager $reservaManager): Response
{
$reservas = $reservaManager->getReservas();
return $this->render('reserva/lista.html.twig', ['reservas' => $reservas]);
}
}