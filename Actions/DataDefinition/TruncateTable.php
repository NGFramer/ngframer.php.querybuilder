<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition;

use Exception;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureTable;

final class TruncateTable extends StructureTable
{
    /**
     * This will add the action (truncateTable) and tableName to the actionLog.
     * @param string $table
     * @throws Exception
     */
    public function __construct(string $table)
    {
        parent::__construct($table);
        $this->setAction('truncateTable');
        return $this;
    }
}