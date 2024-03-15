<?php

namespace NGFramer\NGFramerPHPSQLBuilder

Class Query
{
    // Variable to carry the name of the table.
    $this->tableName = null;

    // Function to get and set the tableName;
    public function table(string $tableName)
    {
        \NGFramer\NGFramerPHPSQLBuilder\datamanipulation\Table::setTableName($tableName);
        return \NGFramer\NGFramerPHPSQLBuilder\datamanipulation\Table::getTableName();
    }

    public function select(string ...$fields = null)
    {
        $tableName = $this->tableName;
        \NGFramer\NGFramerPHPSQLBuilder\datamanipulation\Select::build($tableName, $fields = null)
    }
}
