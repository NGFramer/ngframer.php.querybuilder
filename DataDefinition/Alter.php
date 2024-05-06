<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class Alter extends _DdlCommonColumn
{
    // The functions related to modification of columns in a table.
    // Modification means the addition and deletion, of columns.
    public function addColumn(string $columnName): void
    {
        $this->addAction('addColumn');
        $tableName = $this->getTableName();
        $this->selectColumn($columnName);
        $this->logColumn($tableName, $columnName);
    }

    public function addField(string $columnName): void
    {
        $this->addColumn($columnName);
    }

    public function dropColumn(): void
    {
        $this->addAction('dropColumn');
        $tableName = $this->getTableName();
        $this->selectColumn($this->getSelectedColumn());
        $this->logColumn($tableName, $this->getSelectedColumn());
    }

    public function dropField(): void
    {
        $this->dropColumn();
    }




    // The functions related to modification of attributes of columns in a table.
    // Modification means the addition, changing, and deletion of columns.
    protected function addColumnAttribute(string $attributeName, mixed $attributeValue): void
    {
        if ($this->queryLog[$this->selectedAction]['action'] == 'addColumn'){
            $this->logColumnAttribute($attributeName, $attributeValue);
        } elseif ($this->queryLog[$this->selectedAction]['action'] == 'dropColumn'){
            throw new \Exception("You cannot add an attribute to a column that is being dropped.");
        } else {
            $this->addAction('addColumnAttribute');
            $this->logColumnAttribute($attributeName, $attributeValue);
        }
    }

    protected function changeColumnAttribute(string $attributeName, mixed $attributeValue): void
    {
        if ($this->queryLog[$this->selectedAction]['action'] == 'addColumn' OR $this->queryLog[$this->selectedAction]['action'] == 'dropColumn'){
            throw new \Exception("You cannot change the attribute of a column that is being added or dropped.");
        } else {
            $this->addAction('changeColumnAttribute');
            $this->logColumnAttribute($attributeName, $attributeValue);
        }
    }

    protected function dropColumnAttribute(string $attributeName): void
    {
        if ($this->queryLog[$this->selectedAction]['action'] == 'addColumn' OR $this->queryLog[$this->selectedAction]['action'] == 'dropColumn'){
            throw new \Exception("You cannot drop the attribute of a column that is being added or dropped.");
        } else {
            $this->addAction('dropColumnAttribute');
            $this->logColumnAttribute($attributeName, null);
        }
    }




    // Only functions available for the use from the external class.
    public function changeType(string $type): void
    {
        $this->changeColumnAttribute("type", $type);
    }

    public function changeLength(int|null $length = null): void
    {
        $this->changeColumnAttribute("length", $length);
    }

    public function dropPrimary(): void
    {
        $this->dropColumnAttribute('primary');
    }

    public function dropUnique(): void
    {
        $this->dropColumnAttribute('unique');
    }




    public function build(): string
    {
        // Initialize the query with the table name and return.
        return "CREATE TABLE IF NOT EXISTS ";
        // TODO: Implement the rest of the query.
    }
}