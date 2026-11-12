<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Generates random codes, like secrets, from one or more character sets.
 *
 * Characters are picked with `random_int()`, a cryptographically secure source. A character that occurs in several of
 * the given sets is used once, so overlapping sets don't make it more likely.
 *
 * @notFor Unique codes; it doesn't check whether a code was generated before.
 */
#[Attributes\Service]
readonly class CodeGenerator
{
    private const string AMBIGUOUS_CHARACTERS = '0oO1ilI';

    /**
     * @throws Exceptions\NoCharactersAvailableToGenerateACodeFrom When no sets are given.
     */
    public function generate(int $length, CodeGenerator\CharacterSet ...$sets): string
    {
        $characters = $this->getCharacters($sets, false);

        return $this->createCode($characters, $length);
    }

    /**
     * Like `generate()`, but leaves out characters that are easily confused when read: `0`, `o`, `O`, `1`, `i`, `l` and
     * `I`.
     *
     * @throws Exceptions\NoCharactersAvailableToGenerateACodeFrom When no sets are given, or none of their characters
     *                                                             are left.
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
