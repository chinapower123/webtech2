<?php

namespace Framework\HTTP;

use Uri\Rfc3986\Uri;

class Request implements RequestInterface
{
    private array $attributes = [];

    private function __construct(
        private array $get,
        private array $post = [],
        private array $files = [],
        private array $server = []
    ) {
        $this->attributes = [];
    }

    static public function fromGlobals(): self
    {
        return new Request(
            $_GET,
            $_POST,
            $_FILES,
            $_SERVER,
        );
    }

    public function getPostData(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }

    public function getUri(): Uri
    {
        $uri = $this->server['REQUEST_URI'] ?? '/';
        return new Uri($uri);
    }

    public function getQueryParams(): array
    {
        return $this->get;
    }

    public function getParsedBody(): null|array
    {
        if ($this->getMethod() === 'POST') {
            return $this->post;
        }
        return null;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getAttribute(string $name, mixed $default = null): mixed
    {
        return $this->attributes[$name] ?? $default;
    }

    public function withAttribute(string $name, mixed $value): static
    {
        $clone = clone $this;
        $clone->attributes[$name] = $value;
        return $clone;
    }

    public function withoutAttribute(string $name): static
    {
        $clone = clone $this;
        unset($clone->attributes[$name]);
        return $clone;
    }

    public function getHeaders(): array
    {
        $headers = [];
        foreach ($this->server as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
                $headers[$name] = $value;
            }
        }
        return $headers;
    }

    public function hasHeader(string $name): bool
    {
        return isset($this->getHeaders()[$name]);
    }

    public function getHeader(string $name): string
    {
        $headers = $this->getHeaders();
        return $headers[$name] ?? '';
    }

    public function withHeader(string $name, string $value): static
    {
        $clone = clone $this;
        return $clone;
    }

    public function withoutHeader(string $name): static
    {
        $clone = clone $this;
        return $clone;
    }

    public function getUploadedFiles(): array { return $this->files; }
    public function getServerParams(): array { return $this->server; }
    public function getCookieParams(): array { return $_COOKIE; }
}