<?php

namespace MyLibrary;

use NGFramer\NGFramerPHPSQLServices\exceptions\SqlBuilderError;
use NGFramer\NGFramerPHPExceptions\handlers\SqlBuilderExceptionHandler;

//Convert the error to an exception (SqlBuilderException).
set_error_handler([new SqlBuilderError(), 'convertToException']);
// Set the custom exception handler for the library.
set_exception_handler([new SqlBuilderExceptionHandler(), 'handle']);
