<?php

namespace NGFramer\NGFramerPHPSQLServices\DataDefinition\Supportive;

use Exception;
use NGFramer\NGFramerPHPSQLServices\_Executor;

Trait _DdlExecutor
{
    // Use the following traits for this class.
    use _Executor;


    // Properties for this class to save values.
    // Private as in the _DdlStructure.
    private string $query;


    // Use the following methods.

    /**
     * @throws Exception
     */
    public function execute(): int|array|bool
    {
        // Connect to the database using the _Executor trait in the namespace.
        $this->connect();

        // Execute the query using the direct method, the prepared method does not exist for the DdlStatements.
        return $this->directExecution();
    }
}