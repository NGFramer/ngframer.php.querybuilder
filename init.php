<?php
namespace MyLibrary;

use NGFramer\NGFramerPHPException\exception\SqlBuilderException;
use NGFramer\NGFramerPHPException\handler\SqlBuilderExceptionHandler;

// Set the custom exception handler for the library
set_exception_handler([SqlBuilderExceptionHandler::class, 'handle']);