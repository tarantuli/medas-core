<?php

declare(strict_types=1);

namespace Medas\Core;

#[Attributes\Service]
readonly class CodeGenerator
{
    private const string AMBIGUOUS_CHARACTERS = '0oO1ilI';

    public function generate(int $length, CodeGenerator\CharacterSet ...$sets): string
    {
        $characters = $this->getCharacters($sets, false);

        return $this->createCode($characters, $length);
    }

    /**
     * This generates codes with ambiguous characters like "0" and "o", "1" and "I" or "l" stripped.
     */
    public function generateUnambiguous(int $length, CodeGenerator\CharacterSet ...$sets): string
    {
        $characters = $this->getCharacters($sets, true);

        return $this->createCode($characters, $length);
    }

    private function getCharacters(array $sets, bool $stripAmbiguousCharacters): array
    {
        $characters = [];

        foreach ($sets as $set) {
            $characters = array_merge($characters, str_split($set->value));
        }

        $characters = array_unique($characters);

        if ($stripAmbiguousCharacters) {
            $characters = array_filter(
                $characters,
                fn($character) => !str_contains(self::AMBIGUOUS_CHARACTERS, $character)
            );
        }

        return array_values($characters);
    }

    private function createCode(array $characters, int $length): string
    {
        $characterCount = count($characters);

        if ($characterCount === 0) {
            throw new Exceptions\NoCharactersAvailableToGenerateACodeFrom();
        }

        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[random_int(0, $characterCount - 1)];
        }

        return $code;
    }
}
