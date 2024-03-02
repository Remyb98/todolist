<?php

namespace App\Data;

enum TaskState: string
{
    case OPEN = 'Open';
    case PENDING = 'Penging';
    case FINISHED = 'Finished';
}
