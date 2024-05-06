<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class Create extends _DDL
{
    public function addTable(string $tableName): void
    {
        $this->addAction('createTable');
        $this->setTableName($tableName);
        $this->logTable($tableName);
    }

    public function createTable(string $tableName): void
    {
        $this->addTable($tableName);
    }

    protected function addColumnAttribute(string $attributeName, mixed $attributeValue): void
    {
        $this->logColumnAttribute($attributeName, $attributeValue);
    }

    public function addColumn(string $columnName): void
    {
        $tableName = $this->getTableName();
        $this->selectColumn($columnName);
        $this->logColumn($tableName, $columnName);
    }

    public function build(): string
    {
        return "CREATE TABLE " . $this->getTableName();
        // TODO: Implement build() method.
    }
}