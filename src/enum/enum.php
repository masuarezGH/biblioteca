<?php

namespace App\Enum;

enum EstadoLibro: string
{
    case DISPONIBLE = 'Disponible';
    case PRESTADO = 'Prestado';
}