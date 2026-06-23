<?php

declare(strict_types=1);

namespace Medas\Core\Events;

/**
 * Fired after the response has been determined but before any output is written, allowing listeners
 * to perform final side effects such as flushing persistence layers.
 */
class BeforeResponse
{
}
