<?php

namespace App;

use Exception;
use PDO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Container extends Singleton
{
    private ?Request $_request = null;

    private ?Response $_response = null;

    private ?PDO $_db = null;

    private ?Route $_route = null;

    /**
     * @return Request
     */
    public static function getRequest(): Request
    {
        $instance = static::getInstance();
        if (is_null($instance->_request)) {
            $instance->_request = Request::createFromGlobals();
        }
        return $instance->_request;
    }

    /**
     * @return Response
     */
    public static function getResponse(): Response
    {
        $instance = static::getInstance();
        if (is_null($instance->_response)) {
            $instance->_response = new Response();
        }
        return $instance->_response;
    }

    /**
     * @return PDO
     * @throws Exception
     */
    public static function getDb(): PDO
    {
        $instance = static::getInstance();
        if (is_null($instance->_db)) {
            $errorMsg = "В переменных окружения не содержится значение %s";
            if (($dns = $_ENV['PDO_DNS']) === null) throw new Exception(sprintf($errorMsg, "PDO_DNS"));
            if (($user = $_ENV['DB_USER']) === null) throw new Exception(sprintf($errorMsg, "DB_USER"));
            if (($pass = $_ENV['DB_PASS']) === null) throw new Exception(sprintf($errorMsg, "DB_PASS"));
            $instance->_db = new PDO($dns, $user, $pass);
        }
        return $instance->_db;
    }

    public static function getRoute(): Route
    {
        $instance = static::getInstance();
        if (is_null($instance->_route)) {
            $instance->_route = new Route();
        }
        return $instance->_route;
    }

}