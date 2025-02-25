<?php

namespace NGFramer\NGFramerPHPSQLServices\Exceptions;

use NGFramer\NGFramerPHPExceptions\Exceptions\BaseException;
use Throwable;

class SqlServicesException extends BaseException
{
    /**
     * SqlServicesException constructor.
     *
     * @param ?string $message
     * @param int $code
     * @param string $label
     * @param Throwable|null $previous
     * @param int $statusCode
     * @param array $details
     */
    public function __construct(?string $message = null, int $code = 0, string $label = '', ?Throwable $previous = null, int $statusCode = 500, array $details = [])
    {
        // Call the parent constructor for exception.
        parent::__construct($message, $code, $label, $previous, $statusCode, $details);
    }
}