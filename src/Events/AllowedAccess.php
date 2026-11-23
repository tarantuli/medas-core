<?php

declare(strict_types=1);

namespace Medas\Core\Events;

/**
 * The outcome of a @class(Medas\Core\Events\BasicVote). What happens with each outcome is up to the code that holds
 * the vote; see `BasicVote`.
 */
enum AllowedAccess
{
    /**
     * No listener has voted.
     */
    case Pending;

    /**
     * Access needs an authenticated user, and there isn't one.
     */
    case Unauthenticated;

    /**
     * Access is allowed, unless a later listener votes otherwise.
     */
    case Allowed;

    /**
     * Access is refused. This stops the vote, so no later listener can change it.
     */
    case Denied;
}
