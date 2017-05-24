<?php
namespace AppBundle\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiException extends HttpException
{
    public function getErrorDetails()
    {
        return [
            'code' => $this->getStatusCode() ?: 999,
            'message' => $this->getMessage()?:'API Exception',
        ];
    }
}
