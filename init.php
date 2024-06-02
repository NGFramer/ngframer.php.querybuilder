<?php
namespace MyLibrary;

use NGFramer\NGFramerPHPExceptions\exceptions\SqlBuilderError;
use NGFramer\NGFramerPHPExceptions\handlers\SqlBuilderExceptionHandler;


//Convert the error to an exception (SqlBuilderException).
set_error_handler([SqlBuilderError::class, 'convertToException']);
// Set the custom exception handler for the library.
set_exception_handler([SqlBuilderExceptionHandler::class, 'handle']);
