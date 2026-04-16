<?php

namespace Framework\AccessControl;

use Framework\Http\RequestInterface;
use Framework\Http\ResponseInterface;
use Framework\Http\Response;
use Framework\Kernel\MiddlewareInterface;
use Framework\Kernel\RequestHandlerInterface;

class FirewallMiddleware implements MiddlewareInterface
{
    private FireWall $firewall;

    public function __construct(FireWall $firewall)
    {
        $this->firewall = $firewall;
    }

    public function process(RequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = $request->getAttribute('user');
        if (!$this->firewall->accepts($request, $user)) {
            return new Response(403, '1.1', [], 'Toegang geweigerd.');
        }

        return $handler->handle($request);
    }
}