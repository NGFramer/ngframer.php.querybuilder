<?php
namespace MyLibrary;

use NGFramer\NGFramerPHPException\exception\SqlBuilderError;
use NGFramer\NGFramerPHPException\handler\SqlBuilderExceptionHandler;


//Convert the error to an exception (SqlBuilderException).
set_error_handler([SqlBuilderError::class, 'errorToException']);
// Set the custom exception handler for the library.
set_exception_handler([SqlBuilderExceptionHandler::class, 'handle']);