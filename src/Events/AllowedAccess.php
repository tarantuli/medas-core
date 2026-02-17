<?php

declare(strict_types=1);

namespace Medas\Core\Events;

enum AllowedAccess
{
    case Pending;
    case Allowed;
    case Denied;
}
