<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

abstract class _DdlColumn extends _DdlCommon{

    // Everything about the column.
    // The select column selects the column. This will be used during the time of modification of columns.
    // To select the column, the table must be selected first.
    public function selectColumn(string $columnName): void
    {
        if (!$this->getTableName()) {
            throw new \Exception("No table has been selected. Please select a table before proceeding to select $columnName column.", '01001', null);
        }
        $this->selectedColumn = $columnName;
    }

    public function selectField(string $columnName): void
    {
        $this->selectColumn($columnName);
    }

    public function select(string $columnName): void
    {
        $this->selectColumn($columnName);
    }

    // This function returns the tableColumn that has been selected.
    // If a column is created, the column is selected by default.
    protected function getSelectedColumn(): string
    {
        if (empty($this->selectedColumn)) {
            throw new \Exception("No column has been selected. Please select a column before proceeding.");
        }
        return $this->selectedColumn;
    }

    abstract public function addColumn(string $columnName): void;

    public function addField(string $columnName): void
    {
        $this->addColumn($columnName);
    }

    abstract protected function addColumnAttribute(string $attributeName, mixed $attributeValue): void;




    // The publicly accessible function from above the system code files.
    // Workable column attributes for DDL common.
    public function type(string $type): void
    {
        $this->addColumnAttribute("type", $type);
    }

    // Clone function of type() function.
    public function addType(string $type): void
    {
        $this->type($type);
    }

    public function length(int|null $length = null): void
    {
        if (is_null($length)) {
            $length = _Ddl_Default::getLength($this->queryLog[self::getTableName()][self::getSelectedColumn()]["type"]);
        }
        $this->addColumnAttribute("length", $length);
    }

    // Clone function of length() function.
    public function addLength(int $length): void
    {
        $this->length($length);
    }

    public function typeLength(string $type, int $length): void
    {
        $this->type($type);
        $this->length($length);
    }

    public function addTypeLength(string $type, int $length): void
    {
        $this->typeLength($type, $length);
    }

    public function default(mixed $default): void
    {
        $this->addColumnAttribute("default", $default);
    }

    public function addDefault(mixed $default): void
    {
        $this->default($default);
    }

    public function null(): void
    {
        $this->addColumnAttribute("null", true);
    }

    public function addNull(): void
    {
        $this->null();
    }

    public function notNull(): void
    {
        $this->addColumnAttribute("null", false);
    }

    public function addNotNull(): void
    {
        $this->notNull();
    }

    public function primary(): void
    {
        $this->addColumnAttribute("primary", true);
    }

    public function addPrimary(): void
    {
        $this->primary();
    }

    public function unique(): void
    {
        $this->addColumnAttribute("unique", true);
    }

    public function addUnique(): void
    {
        $this->unique();
    }

    public function autoIncrement(): void
    {
        $this->addColumnAttribute("autoIncrement", true);
    }

    public function addAutoIncrement(): void
    {
        $this->autoIncrement();
    }

    public function ai(): void
    {
        $this->autoIncrement();
    }

    public function addAI(): void
    {
        $this->autoIncrement();
    }

    public function foreignKey(string $referenceTable, string $referenceColumn): void
    {
        $reference = ['table' => $referenceTable, 'column' => $referenceColumn];
        $this->addColumnAttribute("foreignKey", $reference);
    }

    public function addForeignKey(string $referenceTable, string $referenceColumn): void
    {
        $this->foreignKey($referenceTable, $referenceColumn);
    }

    public function fk(string $referenceTable, string $referenceColumn): void
    {
        $this->foreignKey($referenceTable, $referenceColumn);
    }

    public function addFk(string $referenceTable, string $referenceColumn): void
    {
        $this->foreignKey($referenceTable, $referenceColumn);
    }

}