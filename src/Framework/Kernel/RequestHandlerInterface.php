<?php

namespace Framework\Kernel;

use Framework\Http\RequestInterface;
use Framework\Http\ResponseInterface;

/**
* Handles a server request and produces a response.
 *
 * An HTTP request handler process an HTTP request in order to produce an
* HTTP response.
 */
interface RequestHandlerInterface
{
    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     *
     * @param RequestInterface $request The request.
     * @return ResponseInterface The response.
     */
    function handle(RequestInterface $request): ResponseInterface;
}