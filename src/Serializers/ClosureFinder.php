<?php

declare(strict_types=1);

namespace Medas\Core\Serializers;

use Medas\Core\Attributes\Service;

/**
 * Finds where a closure is hidden in a value, so `PhpSerializer` can say which closure made `serialize()` fail.
 *
 * It looks at array items and at all initialised properties of objects, including dynamic properties and private
 * properties of parent classes. It ignores `__serialize()` and `__sleep()`, though, so the closure it finds isn't
 * necessarily the one `serialize()` stumbled over.
 *
 * @performance Walks the whole value, using reflection for objects. An object that can be reached along several paths
 *              is walked once for each path; only cycles are cut short.
 */
#[Service]
readonly class ClosureFinder
{
    /**
     * Returns the path to the first closure in `$value`, like `'Foo::items → 0 → Bar::callback'`, or `'[root value]'`
     * when `$value` is a closure itself. Returns `null` when there's none.
     *
     * A property is labelled with the class of the object, except a private property of a parent class, which is
     * labelled with that parent class.
     *
     * `$path` and `$visitedObjectIds` are only used while recursing; leave them out.
     *
     * @param string[] $path
     * @param int[]    $visitedObjectIds The IDs of the objects on the current path, to stop at circular references.
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

            foreach ($this->properties($value) as $label => $property) {
                if (!$property->isInitialized($value)) {
                    continue;
                }

                $result = $this->search(
                    $property->getValue($value),
                    [...$path, $label],
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

    /**
     * @return array<string, \ReflectionProperty> The properties of the object, by their label in the path.
     */
    private function properties(object $object): array
    {
        $properties = [];

        // Unlike ReflectionClass, ReflectionObject includes dynamic properties
        foreach (new \ReflectionObject($object)->getProperties() as $property) {
            $properties[$object::class . '::' . $property->getName()] = $property;
        }

        // getProperties() leaves out the private properties of parent classes
        for ($parent = get_parent_class($object); $parent !== false; $parent = get_parent_class($parent)) {
            foreach (new \ReflectionClass($parent)->getProperties(\ReflectionProperty::IS_PRIVATE) as $property) {
                if ($property->getDeclaringClass()->getName() === $parent) {
                    $properties[$parent . '::' . $property->getName()] = $property;
                }
            }
        }

        return $properties;
    }
}
