<?php

declare(strict_types=1);

namespace Medas\Core\Events;

use Medas\Core\StringMaker;

/**
 * A message about what the application is doing, for error reports in dev mode.
 * @class(Medas\Core\Events\DebugInformationGatherer) collects them, and @class(Medas\Events\EventDispatcher) drops
 * them outside dev mode.
 *
 * @performance The message is formatted in the constructor, so the arguments are turned into strings even outside dev
 *              mode, where the event is then dropped. When that's costly, use `lazyDispatch()`, which only creates
 *              the event when it will be passed on.
 */
readonly class DebugInformation
{
    /**
     * The formatted message.
     */
    public string $message;

    /**
     * Formats the message with `StringMaker::fromPattern()`: each argument is turned into a string of at most 1000
     * characters and filled into `$pattern` with `vsprintf()`. An argument that can't be turned into a string becomes
     * `�`.
     *
     * @throws \ValueError When `$pattern` isn't a valid format, or has more placeholders than there are arguments.
     */
    public function __construct(string $pattern, ...$arguments)
    {
        $this->message = StringMaker::instance()->fromPattern($pattern, $arguments);
    }
}
