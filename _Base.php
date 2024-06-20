<?php

namespace NGFramer\NGFramerPHPSQLServices;

// Class for database services
abstract class _Base
{
    // Use the following Traits for this class.
    use _Builder, _Executor, _Utilities;

    // No additional functions are required.
    // Every function required are served from the Traits.
}