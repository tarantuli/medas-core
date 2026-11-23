<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Marks classes whose values mustn't be shown, like a config option that holds a password. Code that lists, logs or
 * dumps values should leave them out.
 *
 * `config-options:list`, for example, shows `[REDACTED]` for such options, unless it's run with `--show-sensitive`.
 */
interface IsSensitive
{
}
