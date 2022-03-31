<?php

namespace App;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Container extends Singleton
{
    private ?Request $_request = null;

    private ?Response $_response = null;

    private ?Connection $_db = null;

    private ?Route $_route = null;

    private ?Router $_router = null;

    private ?Environment $_twig = null;

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
     * @return Connection
     */
    public static function getDb(): Connection
    {
        $instance = static::getInstance();
        if (is_null($instance->_db)) {
            $connectionParams = [
                'url' => $_ENV['PDO_DNS'],
            ];
            try {
                $instance->_db = DriverManager::getConnection($connectionParams);
            } catch (Exception $e) {
                $instance->_db = null;
                // отправить в логгер
            }
        }
        return $instance->_db;
    }

    /**
     * @return Route
     */
    public static function getRoute(): Route
    {
        $instance = static::getInstance();
        if (is_null($instance->_route)) {
            $instance->_route = new Route();
        }
        return $instance->_route;
    }

    /**
     * @return Environment
     */
    public static function getTwig(): Environment
    {
        $instance = static::getInstance();
        if (is_null($instance->_twig)) {
            $loader = new FilesystemLoader(__DIR__ . '/templates');
            $instance->_twig = new Environment($loader);
        }
        return $instance->_twig;
    }

    /**
     * @return Router
     */
    public static function getRouter(): Router
    {
        $instance = static::getInstance();
        if (is_null($instance->_router)) {
            $instance->_router = new Router();
        }
        return $instance->_router;
    }

}