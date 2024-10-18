<?php

namespace NGFramer\NGFramerPHPSQLServices\Exceptions;

use NGFramer\NGFramerPHPExceptions\exceptions\_BaseException;
use Throwable;

class SqlServicesException extends _BaseException
{
    /**
     * SqlServicesException constructor.
     *
     * @param $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $statusCode
     * @param array $details
     */
    public function __construct($message = null, int $code = 0, ?Throwable $previous = null, int $statusCode = 500, array $details = [])
    {
        // Call the parent constructor for exception.
        parent::__construct($message, $code, $previous, $statusCode, $details);
    }
}