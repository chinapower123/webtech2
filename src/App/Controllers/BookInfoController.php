<?php
namespace App\Controllers;
use Framework\HTTP\Request;
use Framework\HTTP\RequestInterface;
use Framework\Templating\TemplateEngine;

class BookInfoController
{
    private TemplateEngine $templateEngine;

    public function __construct(TemplateEngine $templateEngine){
        $this->templateEngine = $templateEngine;
    }
    public function index(RequestInterface $request):string
    {
        $id = $request->getQueryParams()['id'] ?? null;
        return $this->templateEngine->render('BookInfo.html', ['id' => $id] );
    }
}