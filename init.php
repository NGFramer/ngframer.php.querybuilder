<?php

namespace NGFramer\NGFramerPHPSQLServices;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesError;
use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesExceptionHandler;

//Convert the error to an exception (SqlBuilderException).
set_error_handler([new SqlServicesError(), 'convertToException']);
// Set the custom exception handler for the library.
set_exception_handler([new SqlServicesExceptionHandler(), 'handle']);