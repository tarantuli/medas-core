<?php

declare(strict_types=1);

namespace Medas\Core\Serializers;

use Medas\Core\Attributes\Service;

#[Service]
readonly class ClosureFinder
{
    /**
     * Traverses the given array or object recursively and returns the path to the first \Closure found, or null if
     * none is found. The path is returned as a human-readable string, e.g. "items → 0 → callback".
     *
     * @param int[] $visitedObjectIds Tracks visited object IDs to prevent infinite loops on circular references.
     */
    public function search(mixed $value, array $path = [], array $visitedObjectIds = []): string|null
    {
        if ($value instanceof \Closure) {
            return implode(' → ', $path) ?: '[root value]';
        }

        if (is_array($value)) {
            foreach ($value as $key => $item) {
                $result = $this->search($item, [...$path, (string) $key], $visitedObjectIds);

                if ($result !== null) {
                    return $result;
                }
            }

            return null;
        }

        if (is_object($value)) {
            $objectId = spl_object_id($value);

            if (in_array($objectId, $visitedObjectIds, true)) {
                return null;
            }

            $visitedObjectIds[] = $objectId;
            $class = new \ReflectionClass($value);

            foreach ($class->getProperties() as $property) {
                if (!$property->isInitialized($value)) {
                    continue;
                }

                $result = $this->search(
                    $property->getValue($value),
                    [...$path, $value::class . '::' . $property->getName()],
                    $visitedObjectIds,
                );

                if ($result !== null) {
                    return $result;
                }
            }

            return null;
        }

        return null;
    }
}
