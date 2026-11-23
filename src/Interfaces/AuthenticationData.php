<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * What an authentication token says about its user: at least who it is. An
 * @class(Medas\Core\Interfaces\AuthenticationTokenController) puts it in a token, and gets it back from one.
 *
 * @assumes It can be converted to an array and back, because the token controller may store the whole object in the
 *          token.
 * @assumes It holds nothing secret. A token can be readable by anyone who has it: a JWT, for example, is signed, not
 *          encrypted.
 */
interface AuthenticationData
{
    public function getUserId(): mixed;
}
