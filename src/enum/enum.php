<?php

namespace App\Enum;

enum EstadoLibro: string
{
    case DISPONIBLE = 'Disponible';
    case PRESTADO = 'Prestado';
}
enum EstadoReserva: string
{
    case ACTIVA = 'Activa';
    case RECHAZADA = 'Rechazada';
    case FINALIZADA = 'Finalizada';
    case PENDIENTE = 'Pendiente';
}