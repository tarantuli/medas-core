<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Today's date, which dev and test environments can set to another date, so code that depends on the date can be
 * tested.
 *
 * `CorePackage` binds `$isDev` to the `$isDev` of the `ServiceConfigBuilder`, so `set()` only works when the
 * application's service config is built in dev mode.
 *
 * @state Keeps the date given to `set()` for the lifetime of the instance, which for a service is the whole process.
 */
#[Attributes\Service]
class Today
{
    private Date|null $date = null;

    public function __construct(
        /** Whether `set()` is allowed. */
        private readonly bool $isDev = false,
    )
    {
    }

    /**
     * The date given to `set()`, or the current date when none is set.
     */
    public function get(): Date
    {
        return $this->date ?? Date::today();
    }

    /**
     * Sets the date that `get()` returns. With `null`, `get()` returns the current date again.
     *
     * @throws Exceptions\TodaySetIsOnlyAllowedInDevOrTest When `$isDev` is `false`.
     */
    public function set(Date|null $date): void
    {
        if (!$this->isDev) {
            throw new Exceptions\TodaySetIsOnlyAllowedInDevOrTest();
        }

        $this->date = $date;
    }
}
