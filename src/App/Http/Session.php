<?php

namespace App\Http;

use Framework\Http\SessionInterface;

class Session implements SessionInterface
{
public function __construct() {
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }
}

public function offsetExists($offset): bool {
    return isset($_SESSION[$offset]);
}

public function offsetGet($offset): mixed {
    return $_SESSION[$offset] ?? null;
}

public function offsetSet($offset, $value): void {
    $_SESSION[$offset] = $value;
}

public function offsetUnset($offset): void {
    unset($_SESSION[$offset]);
}

public function destroy(): void {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
    );
}
session_destroy();
}
}