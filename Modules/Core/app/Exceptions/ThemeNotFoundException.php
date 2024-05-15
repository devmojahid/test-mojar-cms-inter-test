<?php

namespace Modules\Core\Exceptions;

class ThemeNotFoundException extends \Exception
{
    public function __construct($message = "Theme not found", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}