<?php

namespace NGFramer\NGFramerPHPSQLBuilder\datamanipulation;

// Non functional class. Only set's and get's the table name.
Class Table {
    private $tableName;

    public function __construct(string $tableName) {
        $this->tableName = $tableName;
    }

    public function getTableName() {
        return $this->tableName;
    }
}