<?php

declare(strict_types=1);

namespace Medas\Core;

use Medas\ServiceManager\Attributes\Service;

// https://misc.flogisoft.com/bash/tip_colors_and_formatting
#[Service]
class Cli
{
    // Formatting
    public const BOLD = '1';
    const DIM = '2';
    const UNDERLINED = '4';
    const BLINK = '5';
    const INVERT = '7';
    const HIDDEN = '8';

    // Foreground colors
    const DEFAULT = '39';
    const BLACK = '30';
    const RED = '31';
    const GREEN = '32';
    const YELLOW = '33';
    const BLUE = '34';
    const MAGENTA = '35';
    const CYAN = '36';
    const LIGHT_GRAY = '37';
    const GRAY = '90';
    const LIGHT_RED = '91';
    const LIGHT_GREEN = '92';
    const LIGHT_YELLOW = '93';
    const LIGHT_BLUE = '94';
    const LIGHT_MAGENTA = '95';
    const LIGHT_CYAN = '96';
    const WHITE = '97';

    // Background colors
    const DEFAULT_BG = '49';
    const BLACK_BG = '40';
    const RED_BG = '41';
    const GREEN_BG = '42';
    const YELLOW_BG = '43';
    const BLUE_BG = '44';
    const MAGENTA_BG = '45';
    const CYAN_BG = '46';
    const LIGHT_GRAY_BG = '47';
    const GRAY_BG = '100';
    const LIGHT_RED_BG = '101';
    const LIGHT_GREEN_BG = '102';
    const LIGHT_YELLOW_BG = '103';
    const LIGHT_BLUE_BG = '104';
    const LIGHT_MAGENTA_BG = '105';
    const LIGHT_CYAN_BG = '106';
    const WHITE_BG = '107';

    // 256 color map prefixes
    const COLOR256 = '38;5;';
    const COLOR256_BG = '48;5;';

    public function print(string $string, string ...$formats): self
    {
        printf("\e[%sm%s\e[0m", implode(';', $formats), $string);
        return $this;
    }
}
