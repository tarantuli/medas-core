<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Splits an identifier into words, so it can be written in another naming style: `'user_name'` becomes `'userName'`
 * with `toCamelCase()`, and `'UsernameNotPrintable'` becomes `'username-not-printable'` with `toKebabCase()`.
 *
 * @class(Medas\Core\Identifiers\IdentifierAnalyzer) decides where the identifier is split. One with a `-` is only
 * split at those, even when it also contains `_` or spaces. Camel and Pascal case are split before every capital, so an
 * acronym becomes one word per letter: `'parseHTTPRequest'` becomes `'parse-h-t-t-p-request'`. To keep it readable,
 * write the acronym as a word: `'parseHttpRequest'` becomes `'parse-http-request'`.
 *
 * Whitespace at the start or end of a space-separated identifier is ignored.
 *
 * The words keep their case until a method changes it.
 */
readonly class Identifier
{
    private array $words;

    /**
     * @throws Exceptions\EmptyIdentifier When `$identifier` is `''`.
     */
    public function __construct(string $identifier)
    {
        $analyzer = new Identifiers\IdentifierAnalyzer();

        match ($analyzer->determine($identifier)) {
            Identifiers\IdentifierType::SnakeCase => $this->words = explode('_', $identifier),
            Identifiers\IdentifierType::KebabCase => $this->words = explode('-', $identifier),

            Identifiers\IdentifierType::PascalCase
                => $this->words = $this->splitByCapital(strtolower(substr($identifier, 0, 1)) . substr($identifier, 1)),

            Identifiers\IdentifierType::CamelCase
                => $this->words = $this->splitByCapital($identifier),

            Identifiers\IdentifierType::SpaceCase => $this->words = $this->splitBySpace($identifier)
        };
    }

    private function splitByCapital(string $identifier): array
    {
        $words = preg_split('/(?=[A-Z])/', $identifier);

        if ($words === false) {
            throw new Exceptions\SplitByCapitalFailed($identifier, preg_last_error_msg());
        }

        return $words;
    }

    private function splitBySpace(string $identifier): array
    {
        // Without empty words, which whitespace at the start or end would otherwise give
        $words = preg_split('/\s+/', $identifier, flags: PREG_SPLIT_NO_EMPTY);

        if ($words === false) {
            throw new Exceptions\SplitBySpaceFailed($identifier, preg_last_error_msg());
        }

        return $words;
    }

    /**
     * Returns the words as `toCamelCase()` joins them, with the first letter in upper case: `'UserName'`.
     */
    public function toPascalCase(string|null $prefix = null): string
    {
        return $this->capitalize($this->toCamelCase($prefix));
    }

    private function capitalize(string $word): string
    {
        return mb_strtoupper(mb_substr($word, 0, 1)) . mb_substr($word, 1);
    }

    /**
     * Joins the words without a separator: the first one in lower case, the others with a capital and the rest in
     * lower case, like `'userName'`.
     *
     * @param string|null $prefix A word put in front, like `'get'` to make `'getUserName'`.
     */
    public function toCamelCase(string|null $prefix = null): string
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

    /**
     * Joins the words with `_`, like `'user_name'`.
     *
     * The words are put in lower case, unless `$maintainCase` keeps them as they are, `$toUpperCase` puts them in
     * upper case, or `$toLowerCase` is `false`. `$maintainCase` wins over `$toUpperCase`.
     */
    public function toSnakeCase(
        bool $toLowerCase = true,
        bool $maintainCase = false,
        bool $toUpperCase = false
    ): string
    {
        return $this->implodeWithSeparator('_', $toLowerCase, $maintainCase, $toUpperCase);
    }

    /**
     * Joins the words with `-`, like `'user-name'`. The case is set as `toSnakeCase()` sets it.
     */
    public function toKebabCase(
        bool $toLowerCase = true,
        bool $maintainCase = false,
        bool $toUpperCase = false
    ): string
    {
        return $this->implodeWithSeparator('-', $toLowerCase, $maintainCase, $toUpperCase);
    }

    /**
     * Joins the words with spaces, like `'user name'`. The case is set as `toSnakeCase()` sets it.
     */
    public function toPhrase(bool $toLowerCase = true, bool $maintainCase = false, bool $toUpperCase = false): string
    {
        return $this->implodeWithSeparator(' ', $toLowerCase, $maintainCase, $toUpperCase);
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
}
