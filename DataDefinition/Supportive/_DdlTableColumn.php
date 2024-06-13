<?php

namespace NGFramer\NGFramerPHPSQLServices\DataDefinition\Supportive;

use NGFramer\NGFramerPHPExceptions\exceptions\SqlBuilderException;

abstract class _DdlTableColumn extends _DdlTable
{
    // Variable to store the column data.
    protected string|null $selectedColumn;


    // Construct function from parent class.
    // __construct($tableName) function.
    public function __construct(string $tableName)
    {
        parent::__construct($tableName);
    }


    // Everything about the column.
    // The select function selects the column.
    // To select the column, the table must be selected first.
    public function select(string $columnName): self
    {
        if (!$this->getTable()) {
            throw new SqlBuilderException("No table has been selected. Please select a table before proceeding to select $columnName column.", 0, null, 500, ['error_type'=>'ddl_table_notSelected']);
        }
        $this->selectedColumn = $columnName;
        return $this;
    }


    // Opposite of select() function.
    public function deselect(): self
    {
        if (!empty($this->selectedColumn)){
            $this->selectedColumn = null;
        }
        return $this;
    }


    // Clone function of select() function.
    public function selectField(string $columnName): self
    {
        $this->select($columnName);
        return $this;
    }


    // Clone function of deselect() function.
    public function deselectField(): self
    {
        $this->deselect();
        return $this;
    }


    // Clone function of select() function.
    public function selectColumn(string $columnName): self
    {
        $this->select($columnName);
        return $this;
    }


    // Clone function of deselect() function.
    public function deselectColumn(): self
    {
        $this->deselect();
        return $this;
    }


    // This function returns the tableColumn that has been selected.
    protected function getSelectedColumn(): string
    {
        if (empty($this->selectedColumn)) {
            throw new SqlBuilderException("No column has been selected. Please select a column before proceeding.", 0, null, 500, ['error_type'=>'ddl_table_columnNotSelected']);
        }
        return $this->selectedColumn;
    }


    // Function related to the addition of columns.
    abstract public function addColumn($columnName):self;

    public function addField(string $columnName): self
    {
        $this->addColumn($columnName);
        return $this;
    }


    // Functions related ot the addition of attributes to the columns.
    // The functions related to modification of attributes of columns in a table.
    // Logic behind the modification of attributes of columns:
    // 1. Find the index of the selected column,
    // 1. If it's null (index of selected column in queryLog), thrown an error, column must be selected first.
    // 1. If the index does not exist means, the column name was not found in the query log.
    // 2. If column index is found, add an entry to the queryLog = [columns => [ 0 => [ attributeName => attributeValue ] ] ].
    protected function addColumnAttribute(string $attributeName, mixed $attributeValue): void
    {
        // Find the name of the column.
        $columnName = $this->getSelectedColumn();
        // Find the index in which the column is located.
        $columnIndex = $this->getIndexOfColumn($columnName);
        // Check if the column index is null or not.
        if ($columnIndex === null){
            throw new SqlBuilderException("No column was found. Please select a column before proceeding.", 0, null, 500, ['error_type'=>'ddl_table_columnNotFound']);
        }
        $this->addToQueryLogDeep('columns', $columnIndex, $attributeName, $attributeValue);
    }


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