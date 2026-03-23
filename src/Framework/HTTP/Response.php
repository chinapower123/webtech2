<?php

namespace Framework\Http;

class Response implements ResponseInterface{
    private string $body;

    public function __construct(
        private int $status_code = 200,
        string      $protocol_version = '1.1',
        array       $headers = [],
        string      $body = null
    ){
        $this->body = $body ?? '';
    }

    function getHeaders(): array
    {
        // TODO: Implement getHeaders() method.
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

    function getStatusCode(): int
    {
        // TODO: Implement getStatusCode() method.
    }

    public function withStatusCode(int $code): static
    {
        // TODO: Implement withStatusCode() method.
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function withBody(string $body): static
    {
        // TODO: Implement withBody() method.
    }
}