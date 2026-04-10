# Collections

Collections are typed, iterable containers that implement `ArrayAccess`, `Iterator`, and `Countable`. They are the standard way to hold lists of objects in the medas framework.

## Available classes

### `BasicCollection`

A straightforward collection backed by an array. Use this when you need a simple iterable list with array-style access and no change tracking.

```php
$collection = new BasicCollection([$user1, $user2]);

count($collection);           // 2
$collection[0];               // $user1
$collection->contains($user); // true

foreach ($collection as $key => $user) { ... }
```

### `GenericCollection`

Extends `BasicCollection` with change tracking. Tracks which items were added, removed, moved, or modified since the collection was last snapshotted.

```php
$collection = new GenericCollection([$user1, $user2]);

$collection[] = $user3;
unset($collection[0]);

$collection->hasChanged();        // true
$collection->getAdditions();      // yields $user3
$collection->getDeletions();      // yields $user1
$collection->getModifications();  // yields entries where the value at a key changed
$collection->getMovements();      // yields entries where a value moved to a different key

$collection->resetChangeTracking(); // snapshot current state as the new baseline
```

`getAdditions()` and `getDeletions()` use **value-based** comparison (strict `===`), so they are best suited to collections of objects. For scalar-heavy collections with duplicates, prefer key-based logic.

### `LazyGenericCollection`

A `GenericCollection` that defers loading until first access. The data fetcher is a `\Closure` provided either at construction or via `setLoader()`:

```php
$collection = new LazyGenericCollection(fn() => $this->repository->findAll());

// Data is not fetched until this line:
count($collection);
```

Calling `setData()` on a lazy collection marks it as fetched, preventing the loader from running.

## Change tracking

`GenericCollection` and `LazyGenericCollection` implement `TracksChanges`:

| Method | Returns |
|---|---|
| `hasChanged()` | `true` if any additions, deletions, or modifications exist |
| `getAdditions()` | Items present in `$data` but not in `$initialData` |
| `getDeletions()` | Items present in `$initialData` but not in `$data` |
| `getModifications()` | Keys whose value has changed |
| `getMovements()` | Values that existed before but are now at a different key |
| `resetChangeTracking()` | Sets the current data as the new baseline |

## Setting data directly

Collections implementing `SettableCollection` expose `setData(array $data)`, which replaces the contents and resets the change tracking baseline in one step.
