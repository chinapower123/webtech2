<?php
namespace Framework\Kernel;

use Framework\Http\RequestInterface;
use Framework\Http\Response;
use Framework\Http\ResponseInterface;
use Framework\Routing\RouterInterface;

class Kernel implements KernelInterface
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        $controller = $this->router->route($request);
        $body = $controller();

        return new Response(200, '1.1', [], $body);
    }
}