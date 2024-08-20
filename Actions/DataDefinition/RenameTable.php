<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureTable;

final class RenameTable extends StructureTable
{
    /**
     * This will add tableName and action to the action log.
     * @param string $table
     * @throws SqlServicesException
     */
    public function __construct(string $table)
    {
        parent::__construct($table);
        $this->setAction('renameTable');
        return $this;
    }


    /**
     * This takes in the new table name and sets it to the action log.
     * @param string $newTableName
     * @return RenameTable
     * @throws SqlServicesException
     */
    public function to(string $newTableName): RenameTable
    {
        $this->addToActionLog('to', $newTableName);
        return $this;
    }
}