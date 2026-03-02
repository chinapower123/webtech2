<?php

namespace Framework\Http\RequestInterface;

use Uri\Rfc3986\Uri;

class Request implements RequestInterface {
    private function __construct(
        private array $get,
        private array $post = [],
        private array $files = [],
        private Uri $uri
    ) {}

    static public function fromGlobals(): self
    {
        return new Request(
            $_GET,
            $_POST,
            $_FILES,
        );
    }

    public function getUri(): string{
    }
}