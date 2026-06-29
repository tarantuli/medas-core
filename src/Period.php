<?php

declare(strict_types=1);

namespace Medas\Core;

class Period
{
    public static function fromString(string $string): self
    {
        if (!preg_match(
            '/^P(?:(\d+)Y)?(?:(\d+)M)?(?:(\d+)D)?(?:T(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?)?$/',
            $string,
            $match
        )) {
            throw new Exceptions\InvalidIso8601Duration($string);
        }

        return new self(
            years: (int) ($match[1] ?? 0),
            months: (int) ($match[2] ?? 0),
            days: (int) ($match[3] ?? 0),
            hours: (int) ($match[4] ?? 0),
            minutes: (int) ($match[5] ?? 0),
            seconds: (int) ($match[6] ?? 0),
        );
    }

    public function __construct(
        public int $years = 0,
        public int $months = 0,
        public int $days = 0,
        public int $hours = 0,
        public int $minutes = 0,
        public int $seconds = 0,
    )
    {
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        $string = 'P';

        if ($this->years > 0) {
            $string .= $this->years . 'Y';
        }

        if ($this->months > 0) {
            $string .= $this->months . 'M';
        }

        if ($this->days > 0) {
            $string .= $this->days . 'D';
        }

        if ($this->hours > 0 || $this->minutes > 0 || $this->seconds > 0) {
            $string .= 'T';
        }

        if ($this->hours > 0) {
            $string .= $this->hours . 'H';
        }

        if ($this->minutes > 0) {
            $string .= $this->minutes . 'M';
        }

        if ($this->seconds > 0) {
            $string .= $this->seconds . 'S';
        }

        if ($string === 'P') {
            // Default to a valid ISO 8601 duration string of zero seconds.
            return 'PT0S';
        }

        return $string;
    }
}
