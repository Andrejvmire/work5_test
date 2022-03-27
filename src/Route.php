<?php

namespace App;

class Route
{
    private string $_controller;
    private string $_method;

    public function __construct()
    {
        $request_uri = $this->getRequestUri();
        $this->setController(
            $request_uri[0] ?? null
        );
        $this->setMethod(
            $request_uri[1] ?? null
        );
    }

    public function setController(string $controller = ""): string
    {
        $controller = ucwords(
            strtolower($controller)
        );
        $controller = preg_replace("/\s+/", "", $controller);
        $this->_controller = '\\App\\Controller\\' . $controller . 'Controller';
        return $this->_controller;
    }

    public function getController(): string
    {
        return $this->_controller;
    }

    public function setMethod(string $method = null): string
    {
        $method = strtolower($method ?? 'index');
        $this->_method = $method . 'Action';
        return $this->_method;
    }

    public function getMethod(): string
    {
        return $this->_method;
    }

    public function getArgs(): array
    {
        return !isset($this->getRequestUri()[2]) ? [] : [
            "id" => $this->getRequestUri()[2]
        ];
    }

    private function getRequestUri(): array
    {
        return explode(
            '/',
            trim(
                Container::getRequest()->server->get("REQUEST_URI"),
                '/'
            )
        );
    }
}