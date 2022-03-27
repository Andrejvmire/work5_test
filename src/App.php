<?php

namespace App;

class App
{
    /**
     * @throws \Exception
     */
    public static function init(): void
    {
        $router = new Router();
        $response = $router->execute();
        $response->send();
    }
}