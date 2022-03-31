<?php

namespace App\Controller;

use App\Container;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Controller
{
    protected Response $_response;

    protected Environment $_twig;

    public final function __construct()
    {
        $this->_response = Container::getResponse();
        $this->_twig = Container::getTwig();
    }

    /**
     * Отсылает текст клиенту
     * @param string $content
     * @param int $status_code
     * @return Response
     */
    protected function render(string $content = '', int $status_code = 200): Response
    {
        $this->_response->setContent($content);
        $this->_response->setStatusCode($status_code);
        return $this->_response->send();
    }

    /**
     * Отсылает подготовленый шаблон twig клиенты
     * @param string $template имя шаблона
     * @param array $context контекст шиблона
     * @param int $status_code статус страницы
     * @return Response
     */
    protected function renderTwig(string $template, array $context = [], int $status_code = 200): Response
    {
        try {
            return $this->render(
                $this->_twig->render($template, $context),
                $status_code
            );
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            // отправить в логгер
        }
        return $this->render();
    }

    /**
     * @param string $url
     * @param int $status
     * @param array $headers
     * @return Response
     */
    protected function redirectToRoute(string $url, int $status = 302, array $headers = []): Response
    {
        $router = Container::getRouter();
        return $router->redirect($url, $status, $headers);
    }

    public function indexAction(): Response
    {
        return $this->renderTwig('base.html.twig');
    }
}