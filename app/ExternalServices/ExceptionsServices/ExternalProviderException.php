<?php


namespace App\ExternalServices\ExceptionsServices;


use Exception;
use Throwable;

class ExternalProviderException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}