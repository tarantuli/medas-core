<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class TodaySetIsOnlyAllowedInDevOrTest extends BaseException
{
    public function pattern(): string
    {
        return 'Today::set() is only allowed in dev or test environments.';
    }
}
