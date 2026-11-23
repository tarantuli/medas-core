<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * A value for each of the four sides of a rectangle, like margins. As in CSS, sides that are left out repeat others:
 * the right side defaults to the top, the bottom to the top, and the left to the right. So `new RectangleSides(1, 2)`
 * gives `1` for the top and bottom, and `2` for the left and right.
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
