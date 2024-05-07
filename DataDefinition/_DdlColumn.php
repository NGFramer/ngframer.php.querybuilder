<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

abstract class _DdlColumn extends _DdlCommon{

    // Everything about the column.
    // The select column selects the column. This will be used during the time of modification of columns.
    // To select the column, the table must be selected first.
    public function selectColumn(string $columnName): self
    {
        if (!$this->getTableName()) {
            throw new \Exception("No table has been selected. Please select a table before proceeding to select $columnName column.", '01001', null);
        }
        $this->selectedColumn = $columnName;
        return $this;
    }

    public function selectField(string $columnName): self
    {
        $this->selectColumn($columnName);
        return $this;
    }

    public function select(string $columnName): self
    {
        $this->selectColumn($columnName);
        return $this;
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

    abstract public function addColumn(string $columnName): self;

    public function addField(string $columnName): self
    {
        $this->addColumn($columnName);
        return $this;
    }

    abstract protected function addColumnAttribute(string $attributeName, mixed $attributeValue): void;




    // The publicly accessible function from above the system code files.
    // Workable column attributes for DDL common.
    public function type(string $type): self
    {
        $this->addColumnAttribute("type", $type);
        return $this;
    }

    // Clone function of type() function.
    public function addType(string $type): self
    {
        $this->type($type);
        return $this;
    }

    public function length(int|null $length = null): self
    {
        if (is_null($length)) {
            $length = _Ddl_Default::getLength($this->queryLog[$this->getTableName()][$this->getSelectedColumn()]["type"]);
        }
        $this->addColumnAttribute("length", $length);
        return $this;
    }

    // Clone function of length() function.
    public function addLength(int $length): self
    {
        $this->length($length);
        return $this;
    }

    public function typeLength(string $type, int $length): self
    {
        $this->type($type);
        $this->length($length);
        return $this;
    }

    public function addTypeLength(string $type, int $length): self
    {
        $this->typeLength($type, $length);
        return $this;
    }

    public function default(mixed $default): self
    {
        $this->addColumnAttribute("default", $default);
        return $this;
    }

    public function addDefault(mixed $default): self
    {
        $this->default($default);
        return $this;
    }

    public function null(): self
    {
        $this->addColumnAttribute("null", true);
        return $this;
    }

    public function addNull(): self
    {
        $this->null();
        return $this;
    }

    public function notNull(): self
    {
        $this->addColumnAttribute("null", false);
        return $this;
    }

    public function addNotNull(): self
    {
        $this->notNull();
        return $this;
    }

    public function primary(): self
    {
        $this->addColumnAttribute("primary", true);
        return $this;
    }

    public function addPrimary(): self
    {
        $this->primary();
        return $this;
    }

    public function unique(): self
    {
        $this->addColumnAttribute("unique", true);
        return $this;
    }

    public function addUnique(): self
    {
        $this->unique();
        return $this;
    }

    public function autoIncrement(): self
    {
        $this->addColumnAttribute("autoIncrement", true);
        return $this;
    }

    public function addAutoIncrement(): self
    {
        $this->autoIncrement();
        return $this;
    }

    public function ai(): self
    {
        $this->autoIncrement();
        return $this;
    }

    public function addAI(): self
    {
        $this->autoIncrement();
        return $this;
    }

    public function foreignKey(string $referenceTable, string $referenceColumn): self
    {
        $reference = ['table' => $referenceTable, 'column' => $referenceColumn];
        $this->addColumnAttribute("foreignKey", $reference);
        return $this;
    }

    public function addForeignKey(string $referenceTable, string $referenceColumn): self
    {
        $this->foreignKey($referenceTable, $referenceColumn);
        return $this;
    }

    public function fk(string $referenceTable, string $referenceColumn): self
    {
        $this->foreignKey($referenceTable, $referenceColumn);
        return $this;
    }

    public function addFk(string $referenceTable, string $referenceColumn): self
    {
        $this->foreignKey($referenceTable, $referenceColumn);
        return $this;
    }
}