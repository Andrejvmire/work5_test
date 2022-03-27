<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class PageNotFoundController extends Controller
{
    public function indexAction(): Response
    {
        $this->response->setStatusCode(404);
        return $this->response->setContent('Страница не найдена!');
    }
}