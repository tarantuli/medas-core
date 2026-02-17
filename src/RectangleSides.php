<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Represents the four sides of a rectangle
 */
readonly class RectangleSides
{
    public float $right;
    public float $bottom;
    public float $left;

    public function __construct(
        public float $top,
        float|null   $right = null,
        float|null   $bottom = null,
        float|null   $left = null,
    )
    {
        $this->right = $right ?? $this->top;
        $this->bottom = $bottom ?? $this->top;
        $this->left = $left ?? $this->right;
    }
}
