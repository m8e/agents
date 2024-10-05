<?php

namespace App\Enums;

enum TaskProgress: int
{
    case NOT_STARTED = 0;
    case STARTED = 10;
    case IN_PROGRESS = 50;
    case NEAR_COMPLETION = 90;
    case COMPLETED = 100;
}
