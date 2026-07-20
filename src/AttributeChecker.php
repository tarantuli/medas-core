<?php

declare(strict_types=1);

namespace Medas\Core;

#[Attributes\Service]
readonly class AttributeChecker
{
    public function __construct(
        private Interfaces\CacheManager $cacheManager,
    )
    {
    }

    public function hasAttribute(string $class, string $attribute): bool
    {
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
