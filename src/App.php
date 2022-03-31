<?php

namespace App;

use Exception;

class App
{
    /**
     * @throws Exception
     */
    public static function init(): void
    {
        $router = Container::getRouter();
        $response = $router->execute();
        $response->send();
    }
}