<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

class DeleteTable
{
    /**
     * Variable to store the actionLog.
     * @var array|null
     */
    private ?array $actionLog;


    /**
     * Constructor function.
     * @param array $actionLog
     */
    public function __construct(array $actionLog)
    {
        $this->actionLog = $actionLog;
    }


    /**
     * This function builds the applicable query from the actionLog.
     * @return string
     */
    public function build(): string
    {
        // Get actionLog, table from the class.
        $actionLog = $this->actionLog;
        $table = $actionLog['table'];

        // Prepare the initial query.
        $query = "DELETE FROM $table";

        // Return the query built.
        return $query;
    }
}