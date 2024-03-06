<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * This interface extends the PSR event dispatcher interface, with additional information regarding the return value.
 */
interface EventDispatcher extends EventDispatcherInterface
{
    /**
     * The return value is the object that was passed as $event.
     */
    /*
     * The return value is specified for PhpStorm using .phpstorm.meta.php
     */
    public function dispatch(object $event): object;
}
