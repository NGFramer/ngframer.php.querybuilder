<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

// Non-functional class. Only set's and gets the table name.
Class Table {
    private ?string $tableName = null;

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function setTableName($tableName): void
    {
        $this->tableName = $tableName;
    }
}
