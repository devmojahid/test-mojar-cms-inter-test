<?php
namespace Modules\Core\Exceptions;

class InvalidActivatorClass extends \Exception
{
    public static function missConfig()
    {
        return new static("You don't have valid activator class in your config file. Please add 'db_activator' key in your config file.");
    }
}