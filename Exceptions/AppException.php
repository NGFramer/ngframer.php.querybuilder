<?php

namespace NGFramer\NGFramerPHPSQLServices\Exceptions;

use NGFramer\NGFramerPHPExceptions\exceptions\_BaseException;
use Throwable;

class AppException extends _BaseException
{
    /**
     * AppException constructor.
     *
     * @param string $message
     * @param int $code
     * @param string $label
     * @param Throwable|null $previous
     * @param int $statusCode
     * @param array $details
     */
    public function __construct(string $message = "", int $code = 0, string $label = '', Throwable $previous = null, int $statusCode = 500, array $details = [])
    {
        parent::__construct($message, $code, $label, $previous, $statusCode, $details);
    }
}