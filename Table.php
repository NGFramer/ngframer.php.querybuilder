<?php

namespace NGFramer\NGFramerPHPSQLServices;

use NGFramer\NGFramerPHPSQLServices\DataDefinition\AlterTable;
use NGFramer\NGFramerPHPSQLServices\DataDefinition\CreateTable;
use NGFramer\NGFramerPHPSQLServices\DataDefinition\DropTable;
use NGFramer\NGFramerPHPSQLServices\DataDefinition\RenameTable;
use NGFramer\NGFramerPHPSQLServices\DataDefinition\TruncateTable;
use NGFramer\NGFramerPHPSQLServices\DataManipulation\DeleteTable;
use NGFramer\NGFramerPHPSQLServices\DataManipulation\InsertTable;
use NGFramer\NGFramerPHPSQLServices\DataManipulation\SelectTable;
use NGFramer\NGFramerPHPSQLServices\DataManipulation\UpdateTable;

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


    public function insert(array ...$data): InsertTable
    {
        return new InsertTable($this->tableName, ...$data);
    }


    public function update(array ...$data): UpdateTable
    {
        return new UpdateTable($this->tableName, ...$data);
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


    public function rename(string $newTableName): RenameTable
    {
        return new RenameTable($this->tableName, $newTableName);
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