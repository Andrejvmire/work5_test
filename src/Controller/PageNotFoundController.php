<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class PageNotFoundController extends Controller
{
    public function indexAction(): Response
    {
        return $this->renderTwig('page_not_found.html.twig', [], 404);
    }
}