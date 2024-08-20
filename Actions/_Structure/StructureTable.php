<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\_Structure;

use Exception;

abstract class StructureTable extends Structure
{
    /**
     * This class extends on the structure class.
     * @param string $table
     * @throws Exception
     */
    public function __construct(string $table)
    {
        // This will take in the structure name ($tableName).
        parent::__construct('table', $table);
    }
}