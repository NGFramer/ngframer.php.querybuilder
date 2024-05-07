<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class CreateTable extends _DdlColumn
{

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