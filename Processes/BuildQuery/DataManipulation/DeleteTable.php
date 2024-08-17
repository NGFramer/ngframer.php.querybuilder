<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

use Exception;

class DeleteTable
{
    /**
     * Use the following traits.
     */
    use WhereTrait;
    use LimitTrait;


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
     * @throws Exception
     */
    public function build(): string
    {
        // Get actionLog, table from the class.
        $actionLog = $this->actionLog;
        $table = $actionLog['table'];

        // Prepare the initial query.
        $query = "DELETE FROM $table";

        // Add the where clause.
        if (isset($actionLog['where'])) {
            $query .= $this->where($actionLog['where']);
        }

        // Add the limit clause.
        if (isset($actionLog['limit'])) {
            $query .= $this->limit($actionLog['limit']);
        }

        // Return the query built.
        return $query;
    }
}