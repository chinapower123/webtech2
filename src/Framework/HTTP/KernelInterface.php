<?php

namespace Framework\Kernel;

use Framework\Http\RequestInterface;

/**
 * Handles a server request and produces a response.
 *
 * A kernel processes an HTTP request in order to produce an
 * HTTP response.
 */
interface KernelInterface
{
    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     *
     * @param RequestInterface $request The server request.
     * @return string The response as a string.
     */
    public function handle(RequestInterface $request): string;
}