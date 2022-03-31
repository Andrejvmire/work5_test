<?php

namespace App;

use App\Interfaces\ISingleton;

abstract class Singleton implements ISingleton
{
    private static array $_instance = [];

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    /**
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception("Класс не может быть восстановлен из строки");
    }

    public static function getInstance(): ISingleton
    {
        $class = static::class;
        if (!isset(self::$_instance[$class])) {
            self::$_instance[$class] = new static();
        }
        return self::$_instance[$class];
    }
}