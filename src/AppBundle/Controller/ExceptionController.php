<?php
namespace AppBundle\Controller;

use AppBundle\Exceptions\ApiException;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;


class ExceptionController  extends BaseApiController
{

    public function showAction($exception)
    {

        $originException = $exception;

        if ( !$exception instanceof ApiException && !$exception instanceof HttpException) {
            $exception = new HttpException($this->getStatusCode($exception), $this->getStatusText($exception));
        }

        if ($exception instanceof HttpException) {
            $exception = new ApiException($this->getStatusText($exception), $this->getStatusCode($exception));
        }

        $error = $exception->getErrorDetails();
        $error['originMessage'] = $originException->getMessage();

        $code = $this->getStatusCode($originException);

        if ($this->isDebugMode()) {
            $error['exception'] = FlattenException::create($originException);
        }


        return $this->handleView($this->view(['error' => $error], $code, ['X-Status-Code' => $code]));
    }

    protected function getStatusCode(\Exception $exception)
    {

        // If matched
        if ($statusCode = $this->get('fos_rest.exception.codes_map')->resolveException($exception)) {
            return $statusCode;
        }

        // Otherwise, default
        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        return 500;
    }

    protected function getStatusText(\Exception $exception, $default = 'Internal Server Error')
    {
        $code = $this->getStatusCode($exception);

        return array_key_exists($code, Response::$statusTexts) ? Response::$statusTexts[$code] : $default;
    }

    public function isDebugMode()
    {
        return $this->getParameter('kernel.debug');
    }
}