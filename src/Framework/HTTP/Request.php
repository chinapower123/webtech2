<?php

namespace Framework\HTTP;
use Uri\Rfc3986\Uri;

class Request implements RequestInterface {
    private function __construct(
        private array $get,
        private array $post = [],
        private array $files = [],
        private array $server = []
    ) {}

    static public function fromGlobals(): self
    {
        return new Request(
            $_GET,
            $_POST,
            $_FILES,
            $_SERVER,
        );
    }

    function getHeaders(): array
    {

    }

    function hasHeader(string $name): bool
    {
        // TODO: Implement hasHeader() method.
    }

    function getHeader(string $name): string
    {
        // TODO: Implement getHeader() method.
    }

    function withHeader(string $name, string $value): static
    {
        // TODO: Implement withHeader() method.
    }

    function withoutHeader(string $name): static
    {
        // TODO: Implement withoutHeader() method.
    }

    function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }

    function getUri(): Uri
    {
        $uri = $this->server['REQUEST_URI'] ?? '/';
        return new Uri($uri);
    }

    function getServerParams(): array
    {
        // TODO: Implement getServerParams() method.
    }

    function getCookieParams(): array
    {
        // TODO: Implement getCookieParams() method.
    }

    function getQueryParams(): array
    {
        // TODO: Implement getQueryParams() method.
    }

    function getUploadedFiles(): array
    {
        // TODO: Implement getUploadedFiles() method.
    }

    function getParsedBody(): null|array
    {
        // TODO: Implement getParsedBody() method.
    }

    function getAttributes(): array
    {
        // TODO: Implement getAttributes() method.
    }

    function getAttribute(string $name, mixed $default = null): mixed
    {
        // TODO: Implement getAttribute() method.
    }

    function withAttribute(string $name, mixed $value): static
    {
        // TODO: Implement withAttribute() method.
    }

    function withoutAttribute(string $name): static
    {
        // TODO: Implement withoutAttribute() method.
    }
}