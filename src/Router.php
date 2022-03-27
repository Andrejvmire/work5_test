<?php

namespace App;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    /**
     * @throws Exception
     */
    public static function execute(): Response
    {
        $route = Container::getRoute();
        $controller = $route->getController();
        $method = $route->getMethod();
        $arguments = array_merge(
            $route->getArgs(),
            Container::getRequest()->query->all()
        );
        if (class_exists($controller) && method_exists($controller, $method)) {
            return (new $controller)->$method($arguments);
        }
        $controller = $route->setController('page not found');
        $method = $route->setMethod();
        if (class_exists($controller) && method_exists($controller, $method)) {
            return (new $controller)->$method($arguments);
        } else {
            throw new Exception("Контроллер $controller или его метод $method не определены");
        }
    }
}