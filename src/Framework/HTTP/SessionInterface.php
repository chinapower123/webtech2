<?php

namespace Framework\HTTP;

/**
 * A service that allows access to the global session.
 * Session cookies SHOULD not be created unless the session is actively being used.
 */
interface SessionInterface extends \ArrayAccess
{
    /**
     * Destroy the session, its cookie and its contents.
     */
    function destroy(): void;
}