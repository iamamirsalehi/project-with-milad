<?php

namespace App\Domain\Enums;

enum MovieStatus: string
{
    case Published = 'published';
    case Draft = 'draft';
}
