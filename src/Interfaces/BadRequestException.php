<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Marks exceptions that a bad request causes, like invalid input, rather than a mistake in the code.
 *
 * error-reporting neither logs nor mails them unless its `LogBadRequests` or `EmailBadRequests` option is switched
 * on, and http-request-handler answers them with status code 400, unless the exception declares a code of its own.
 */
interface BadRequestException
{
}
