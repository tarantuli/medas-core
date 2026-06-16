<?php

declare(strict_types=1);

namespace Medas\Core\Lists;

enum SortByPriority
{
    case No;
    case HighToLow;
    case LowToHigh;
}
