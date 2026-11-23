<?php

declare(strict_types=1);

namespace Medas\Core\Events;

use Psr\EventDispatcher\StoppableEventInterface;

/**
 * An event that asks its listeners whether something is allowed. Code dispatches the vote, the listeners set
 * `$allowedAccess`, and the code reads it afterwards.
 *
 * Listeners run in order of priority, and each can overwrite the vote so far, so the last one that sets it decides.
 * `Denied` is the exception: it stops the dispatch, so no later listener can overrule it. A vote no listener answered
 * stays `Pending`.
 *
 * The code holding the vote decides what each outcome means. `allowElseThrow()` and
 * @class(Medas\HttpRequestHandler\HttpRequestHandler) only go ahead on `Allowed`; the latter answers `Denied` with a
 * 403 and every other outcome with a 401. @class(Medas\Routing\HandlerFinder) only leaves a route out on `Denied`.
 *
 * @see AllowedAccess
 */
abstract class BasicVote implements StoppableEventInterface
{
    /**
     * The vote so far, set by the listeners.
     */
    public AllowedAccess $allowedAccess = AllowedAccess::Pending;

    /**
     * Returns `true` once a listener has voted `Denied`.
     */
    public function isPropagationStopped(): bool
    {
        return $this->allowedAccess === AllowedAccess::Denied;
    }
}
