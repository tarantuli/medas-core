<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * A basic trait that turns a class into a singleton. More lightweight than a @class(Medas\Core\Attributes\Service),
 * useful for subtype instances.
 */
trait AsSingleton
{
    private static self $instance;

    public static function instance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }
}
