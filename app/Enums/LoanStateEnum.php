<?php

namespace App\Enums;    

enum LoanStateEnum: int 
{
    case SCOUT_EVENT = 0;
    case WAITING = 1;
    case ACCEPTED = 2;
    case DENIED = 3;
}