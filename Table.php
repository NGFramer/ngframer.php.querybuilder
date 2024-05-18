<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\AlterTable;
use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\CreateTable;
use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\DropTable;
use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\TruncateTable;
use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\DeleteTable;
use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\InsertTable;
use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\SelectTable;
use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\UpdateTable;

class Table
{
    private string $tableName;

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }




    // Data Modification functions.
    public function select(string ...$fields): SelectTable
    {
        return new SelectTable($this->tableName, $fields);
    }

    public function insert(array $data): InsertTable
    {
        return new InsertTable($this->tableName, $data);
    }

    public function update(array ...$data): UpdateTable
    {
        return new UpdateTable($this->tableName, $data);
    }

    public function delete(): DeleteTable
    {
        return new DeleteTable($this->tableName);
    }




    // Data Definition Functions.
    public function create(): CreateTable
    {
        return new CreateTable($this->tableName);
    }

    public function alter(): AlterTable
    {
        return new AlterTable($this->tableName);
    }

    public function truncate(): TruncateTable
    {
        return new TruncateTable($this->tableName);
    }

    public function drop(): DropTable
    {
        return new DropTable($this->tableName);
    }
}