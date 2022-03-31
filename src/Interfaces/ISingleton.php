<?php

namespace App\Interfaces;

interface ISingleton
{
    static function getInstance(): ISingleton;
}