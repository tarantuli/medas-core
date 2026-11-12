<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Tells whether a class carries an attribute, and remembers the answer, so the reflection only happens once.
 *
 * Attributes that extend the requested attribute class count as well.
 *
 * @cache Each answer is stored in the `'default'` cache under the key `[$class, $attribute]`. It's only invalidated
 *        when the caches are cleared, for example with `services:clear-caches`.
 * @notFor Attributes on parent classes, interfaces or traits; only the class itself is checked.
 * @notFor Reading the attribute's arguments; the global `attribute()` function returns an instance of it.
 */
#[Attributes\Service]
readonly class AttributeChecker
{
    public function __construct(
        /** Provides the `'default'` cache that holds the answers. */
        private Interfaces\CacheManager $cacheManager,
    )
    {
    }

    public function hasAttribute(string|object $classOrObject, string $attribute): bool
    {
        $class = is_object($classOrObject) ? $classOrObject::class : $classOrObject;

        return $this->cacheManager->get()->get(
            [$class, $attribute],
            fn() => $this->determine($class, $attribute)
        );
    }

    private function determine(string $class, string $attribute): bool
    {
        return new \ReflectionClass($class)->getAttributes(
            $attribute,
            \ReflectionAttribute::IS_INSTANCEOF
        ) !== [];
    }
}
