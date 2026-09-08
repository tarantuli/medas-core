<?php

declare(strict_types=1);

namespace Medas\Core;

#[Attributes\Service]
class Today
{
    private Date|null $date = null;

    public function __construct(
        private readonly bool $isDev = false,
    )
    {
    }

    /**
     * Returns the current date, unless a specific date has been set. Then that value is returned.
     */
    public function get(): Date
    {
        return $this->date ?? Date::today();
    }

    /**
     * Sets the date to return. If set to null, then get() will return the current date.
     *
     * This is only allowed in dev or test environments.
     */
    public function set(Date|null $date): void
    {
        if (!$this->isDev) {
            throw new Exceptions\TodaySetIsOnlyAllowedInDevOrTest();
        }

        $this->date = $date;
    }
}
