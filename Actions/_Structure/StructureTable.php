<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\_Structure;

use Exception;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\AlterTable;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\CreateTable;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\DropTable;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\RenameTable;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\TruncateTable;

abstract class StructureTable extends Structure
{
    /**
     * This class extends on the structure class.
     * @param string $table
     * @throws Exception
     */
    public function __construct(string $table)
    {
        $this->table = $table;
        // This will take in the structure name ($tableName).
        parent::__construct('table', $table);
        return $this;
    }
}