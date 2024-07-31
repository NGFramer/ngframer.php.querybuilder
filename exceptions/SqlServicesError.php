<?php

namespace NGFramer\NGFramerPHPSQLServices\exceptions;

use NGFramer\NGFramerPHPExceptions\exceptions\supportive\_BaseError;

class SqlServicesError extends _BaseError
{
    /**
     * Converts the error into an exception.
     * @throws SqlServicesException
     */
    public function convertToException($code, $message, string $file, int $line, array $context = []): void
    {
        // Throw the exception (DbServicesException).
        throw new \NGFramer\NGFramerPHPSQLServices\exceptions\SqlServicesException($message, $code, null, 500, []);
    }
}