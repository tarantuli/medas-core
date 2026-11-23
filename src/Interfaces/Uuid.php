<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A UUID. As a string, and in JSON, it's the readable form, like `'0b6a3f1e-2c4d-4e5f-8a9b-1c2d3e4f5a6b'`.
 * `toBytes()` returns the 16 bytes, for storage.
 *
 * Create one with a @class(Medas\Core\Interfaces\UuidProvider).
 */
interface Uuid extends \Stringable, \JsonSerializable
{
    public function toBytes(): string;
}
