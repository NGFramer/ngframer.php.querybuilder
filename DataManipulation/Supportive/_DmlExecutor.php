<?php

namespace NGFramer\NGFramerPHPSQLServices\DataManipulation\Supportive;

use Exception;
use NGFramer\NGFramerPHPSQLServices\_Executor;

Trait _DmlExecutor
{
    // Use the following traits for this class.
    use _Executor;


    // Properties for this class to save values.
    // Private as in the _DmlStructure.
    private array $bindParameters = [];
    private string $query;


    // Use the following methods.

    /**
     * @throws Exception
     */
    public function execute(): int|array|bool
    {
        // Connect to the database using the _Executor trait in the namespace.
        $this->connect();

        // Execute the query using the asked method (prepared or direct).
        if (!$this->isGoDirect()) {
            return $this->preparedExecution();
        } else  {
            return $this->directExecution();
        }
    }
}