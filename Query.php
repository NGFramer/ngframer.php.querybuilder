<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

Class Query
{
    // Variable to carry the name of the table.
    private $tableName = null;

    // Function to get and set the tableName;
    public function table(string $tableName): void
    {
        \NGFramer\NGFramerPHPSQLBuilder\datamanipulation\Table::setTableName($tableName);
        $this->tableName = \NGFramer\NGFramerPHPSQLBuilder\datamanipulation\Table::getTableName();
    }

    public function select(string ...$fields)
    {
        $tableName = $this->tableName;
        \NGFramer\NGFramerPHPSQLBuilder\datamanipulation\Select::build($tableName, $fields);
    }
}
