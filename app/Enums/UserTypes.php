<?php

namespace App\Enums;

enum UserTypes: int
{
    case USER = 0;
    case CELEB = 1;
    case DUMMY = 2;
    case SUPREMO = 76;
}
