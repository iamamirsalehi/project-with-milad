<?php

namespace App\Modules\Movie\Enums;

enum MovieStatus: string
{
    case Published = 'published';
    case Draft = 'draft';
}
