<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation;

use Exception;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureTable;

final class DeleteTable extends StructureTable
{
    /**
     * This sets the tableName and the action to the actionLog.
     * @param string $table
     * @throws Exception
     */
    public function __construct(string $table)
    {
        parent::__construct($table);
        $this->setAction('deleteTable');
        return $this;
    }
}