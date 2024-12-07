<?php

namespace App\Src\Domain\Enums;

enum MovieStatus: string
{
    case Published = 'published';
    case Draft = 'draft';
}
