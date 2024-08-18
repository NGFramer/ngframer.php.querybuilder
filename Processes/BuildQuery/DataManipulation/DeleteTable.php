<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

use Exception;
use NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation\Supportive\Bindings;

class DeleteTable
{
    /**
     * Use the following traits for query building.
     */
    use WhereTrait;
    use LimitTrait;


    /**
     * Use the following for binding functions.
     */
    use Bindings;


    /**
     * Variable to store the actionLog.
     * @var array|null
     */
    private ?array $actionLog;


    /**
     * Variable to store the formulated query and bindings.
     * @var array|null
     */
    private ?array $queryLog;


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
     * @return array
     * @throws Exception
     */
    public function build(): array
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
        $this->queryLog['query'] = $query;
        return $this->queryLog;
    }
}