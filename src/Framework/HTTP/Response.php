<?php

namespace Framework\Http;

use AllowDynamicProperties;

#[AllowDynamicProperties]
class Response implements ResponseInterface
{
    private string $body;
    private array $headers;
    private string $protocol_version;

    public function __construct(
        private int $status_code = 200,
        string      $protocol_version = '1.1',
        array       $headers = [],
        string      $body = null
    ){
        $this->body = $body ?? '';
        $this->headers = $headers;
        $this->protocol_version = $protocol_version;
        $this->status_code = $status_code;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getStatusCode(): int
    {
        return $this->status_code;
    }

    public function withStatusCode(int $code): static
    {
        $clone = clone $this;
        $clone->status_code = $code;
        return $clone;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function withBody(string $body): static
    {
        $clone = clone $this;
        $clone->body = $body;
        return $clone;
    }

    public function withHeader(string $name, string $value): static
    {
        $clone = clone $this;
        $clone->headers[$name] = $value;
        return $clone;
    }

    public function hasHeader(string $name): bool
    {
        return isset($this->headers[$name]);
    }

    public function getHeader(string $name): string
    {
        return $this->headers[$name] ?? '';
    }

    public function withoutHeader(string $name): static
    {
        $clone = clone $this;
        unset($clone->headers[$name]);
        return $clone;
    }
}