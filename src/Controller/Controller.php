<?php

namespace App\Controller;

use App\Container;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    protected Response $response;

    public final function __construct()
    {
        $this->response = Container::getResponse();
    }

    public function indexAction(): Response
    {
        $this->response->setContent("Some text");
        return $this->response->send();
    }
}