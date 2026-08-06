<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * This interface is used to mark sensitive properties. It can, for instance, be used with ConfigOptions. Loggers and
 * dumpers should react to the presence of this interface.
 */
interface IsSensitive
{
}
