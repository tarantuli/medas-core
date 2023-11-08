<?php

declare(strict_types=1);

namespace Medas\Core;

class Identifier
{
    public static function fromCamelCase(string $camelCase): self
    {
        $identifier = mb_strtolower(preg_replace('/(.)(\p{Lu})/', '$1 $2', $camelCase));

        return new self($identifier);
    }

    public static function fromKebabCase(string $kebabCase): self
    {
        $identifier = str_replace('-', ' ', $kebabCase);

        return new self($identifier);
    }

    private array $words;

    public function __construct(string $identifier)
    {
        $this->words = preg_split('/\s+/', $identifier);
    }

    public function toPascalCase(string $prefix = null): string
    {
        return $this->capitalize($this->toCamelCase($prefix));
    }

    private function capitalize(string $word): string
    {
        return mb_strtoupper(mb_substr($word, 0, 1)) . mb_substr($word, 1);
    }

    public function toCamelCase(string $prefix = null): string
    {
        $words = $this->words;

        if (null !== $prefix) {
            array_unshift($words, $prefix);
        }

        $string = '';

        foreach ($words as $i => $word) {
            if ($i === 0) {
                $string .= mb_strtolower($word);
            }
            else {
                $string .= $this->capitalizeThenLower($word);
            }
        }

        return $string;
    }

    private function capitalizeThenLower(string $word): string
    {
        return mb_strtoupper(mb_substr($word, 0, 1)) . mb_strtolower(mb_substr($word, 1));
    }

    public function toSnakeCase(
        bool $toLowerCase = true,
        bool $maintainCase = false,
        bool $toUpperCase = false
    ): string
    {
        return $this->implodeWithSeparator('_', $toLowerCase, $maintainCase, $toUpperCase);
    }

    private function implodeWithSeparator(
        string $separator,
        bool   $toLowerCase = true,
        bool   $maintainCase = false,
        bool   $toUpperCase = false
    ): string
    {
        $snakeCase = implode($separator, $this->words);

        if ($maintainCase) {
            // Do nothing
        }
        elseif ($toUpperCase) {
            $snakeCase = mb_strtoupper($snakeCase);
        }
        elseif ($toLowerCase) {
            $snakeCase = mb_strtolower($snakeCase);
        }

        return $snakeCase;
    }

    public function toKebabCase(
        bool $toLowerCase = true,
        bool $maintainCase = false,
        bool $toUpperCase = false
    ): string
    {
        return $this->implodeWithSeparator('-', $toLowerCase, $maintainCase, $toUpperCase);
    }
}
