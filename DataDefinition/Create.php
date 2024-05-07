<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class Create extends _DdlColumn
{
    public function addTable(): self
    {
        $this->addAction('createTable');
        $this->logTable($this->getTableName());
        return $this;
    }

    public function createTable(string $tableName): self
    {
        $this->addTable($tableName);
        return $this;
    }

    protected function addColumnAttribute(string $attributeName, mixed $attributeValue): void
    {
        $this->logColumnAttribute($attributeName, $attributeValue);
    }

    public function addColumn(string $columnName): self
    {
        $tableName = $this->getTableName();
        $this->selectColumn($columnName);
        $this->logColumn($tableName, $columnName);
        return $this;
    }

    public function build(): string
    {
        return "CREATE TABLE " . $this->getTableName();
        // TODO: Implement build() method.
    }
}