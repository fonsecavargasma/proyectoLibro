<?php

namespace App\Application\Exceptions;

class OpenLibraryException extends \Exception
{
    public function errorMessage()
    {
        return "Error en OpenLibrary API: " . $this->getMessage();
    }
}
