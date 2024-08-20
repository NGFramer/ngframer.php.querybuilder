<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\_Structure;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;

abstract class StructureTable extends Structure
{
    /**
     * This class extends on the structure class.
     * @param string $table
     * @throws SqlServicesException
     */
    public function __construct(string $table)
    {
        // This will take in the structure name ($tableName).
        parent::__construct('table', $table);
    }
}