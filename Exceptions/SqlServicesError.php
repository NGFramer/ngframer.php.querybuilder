<?php

namespace NGFramer\NGFramerPHPSQLServices\Exceptions;

use NGFramer\NGFramerPHPExceptions\exceptions\supportive\_BaseError;

class SqlServicesError extends _BaseError
{
    /**
     * Converts the error into an exception.
     * @throws SqlServicesException
     */
    public function convertToException($code, $message, string $file, int $line, array $context = []): void
    {
        // Throw the exception (SqlServicesException).
        throw new SqlServicesException($message, $code, null, $line, $context);
    }
}