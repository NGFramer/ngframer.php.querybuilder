<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\Supportive\_DdlTableColumn;

class AlterTable extends _DdlTableColumn
{
    // Variable only for the Alter Table.
    // Will be only addColumn, dropColumn, modifyColumn.
    private string|null $selectedColumnAction;




    // Construct function from parent class.
    // Location: AlterTable => _DdlTableColumn => _DdlTable.
    // __construct($tableName) function.
    public function __construct(string $tableName)
    {
        parent::__construct($tableName);
        // Initialize the query log, add the table name and the action to alterTable.
        $this->addQueryLog('table', $tableName, 'alterTable');
    }




    // Selection function modification from parent.
    public function select(string $columnName): self
    {
        parent::select($columnName);
        $this->selectedColumnAction = null;
        return $this;
    }




    // The functions related to modification of columns in a table.
    // Modification means the addition and deletion, of columns.
    public function addColumn($columnName):self
    {
        // Firstly we select the column.
        $this->select($columnName);
        // Make modification to the query log, we have added the table name and table's action previously.
        // We find the index for the column, and add the column, and it's name there.
        // Get the columns count.
        // Logic behind this is to get count number of columns, then do -1 as array index starts from 0, and +1 for new Index.
        $newColumnIndex = !empty($this->getIndexOfColumn($columnName)) ? $this->getIndexOfColumn($columnName) : $this->columnsCount();
        // Add the column to the query log.
        $this->addToQueryLogDeep('columns', $newColumnIndex, 'action', 'addColumn');
        $this->addToQueryLogDeep('columns', $newColumnIndex, 'column', $columnName);
        return $this;
    }


    // No function for changeColumn.
    // Change column will be done by selecting the column and then changing the attributes of the column.
    // Using functions like: changeType(), changeLength(), dropPrimary(), dropUnique(), dropAutoIncrement(), dropNotNull(), dropDefault(), dropAi().
    public function dropColumn(): self
    {
        // Find the name of the column to drop.
        $columnName = $this->getSelectedColumn();
        // Check if the column has action previous defined, meaning the column has been marked to be acted in this instance.
        if ($this->getActionOfColumn($columnName) == 'addColumn' || $this->getActionOfColumn($columnName) == 'dropColumn' || $this->getActionOfColumn($columnName) == 'modifyColumn'){
            // If the column is being added, then you can't drop the column being added.
            throw new \Exception("You cannot drop a column that is being modified in this instance.");
        }
        // Get the columns count.
        // Logic behind this is to get count number of columns, then do -1 as array index starts from 0, and +1 for new Index.
        $newColumnIndex = !empty($this->getIndexOfColumn($columnName)) ? $this->getIndexOfColumn($columnName) : $this->columnsCount();
        // Add the column and action to the query log.
        $this->addToQueryLogDeep('columns', $newColumnIndex, 'action', 'dropColumn');
        $this->addToQueryLogDeep('columns', $newColumnIndex, 'column', $columnName);
        return $this;
    }

    public function dropField(): self
    {
        $this->dropColumn();
        return $this;
    }




    // The functions related to modification of attributes of columns in a table.
    // Modification means the addition, changing, and deletion of columns.
    protected function addColumnAttribute(string $attributeName, mixed $attributeValue): void
    {
        // Get the column that has been selected. Selection is also done during the creation of the column.
        $columnName = $this->getSelectedColumn();
        // If no column has been selected, select a column first.
        if (empty($columnName)) {
            throw new \Exception("No column has been selected. Please select a column before proceeding.");
        }
        // If the column is being added, then you can add an attribute to the column being added, without any additional action addition to the column.
        if ($this->getActionOfColumn($columnName) == 'addColumn') {
            parent::addColumnAttribute($attributeName, $attributeValue);
        }
        // If the column is being dropped, then you can't add an attribute to the column being dropped.
        // You can though add attribute before and then drop the column.
        elseif ($this->getActionOfColumn($columnName) == 'dropColumn') {
            throw new \Exception("You cannot add an attribute to a column that is being dropped.");
        }
        // If the column is being modified (has no action for it), we add an action to query log, We haven't added before, only once, we set it.
        elseif (empty($this->getActionOfColumn($columnName))) {
            // Get a new index for the column current column.
            $columnIndex = $this->columnsCount();
            // First make an action for the table, if not made already.
            $this->addToQueryLogDeep('columns', $columnIndex, 'action', 'alterColumn');
            // Make an entry to the newer index.
            $this->addToQueryLogDeep('columns', $columnIndex, 'column', $columnName);
            $this->addToQueryLogDeep('columns', $columnIndex, $attributeName, $attributeValue);
        } else {
            // If no column has been selected, select a column first.
            throw new \Exception("No column has been selected. Please select a column before proceeding.");
        }
    }

    protected function changeColumnAttribute(string $attributeName, mixed $attributeValue): void
    {
        if (isset($this->selectedColumnAction) AND ($this->selectedColumnAction == 'addColumn' OR $this->selectedColumnAction == 'dropColumn')){
            throw new \Exception("You cannot change the attribute of a column that is being added or dropped.");
        } else {
            // Find the name of the column.
            $columnName = $this->getSelectedColumn();
            // Get a new index for the column current column.
            $newColumnIndex = $this->columnsCount();
            // First make an action for the table, if not made already.
            $this->addToQueryLogDeep('columns', $newColumnIndex, 'action', 'alterColumn');
            // Make an entry to the newer index.
            $this->addToQueryLogDeep('columns', $newColumnIndex, 'column', $columnName);
            $this->addToQueryLogDeep('columns', $newColumnIndex, $attributeName, $attributeValue);
        }
    }

    protected function dropColumnAttribute(string $attributeName): void
    {
        if (isset($this->selectedColumnAction) AND ($this->selectedColumnAction == 'addColumn' OR $this->selectedColumnAction == 'dropColumn')){
            throw new \Exception("You cannot change the attribute of a column that is being added or dropped.");
        } else {
            // Find the name of the column.
            $columnName = $this->getSelectedColumn();
            // Check if the action of the column is not set, then set it.
            if (!empty($this->getActionOfColumn($columnName))) {
                throw new \Exception("No attribute has been set for the column. Please set an attribute before proceeding.");
            }
            // Get a new index for the column current column.
            $newColumnIndex = $this->columnsCount();
            // First make an action for the table, if not made already.
            $this->addToQueryLogDeep('columns', $newColumnIndex, 'action', 'alterColumn');
            // Make an entry to the newer index.
            $this->addToQueryLogDeep('columns', $newColumnIndex, 'column', $columnName);
            $this->addToQueryLogDeep('columns', $newColumnIndex, $attributeName, false);
        }
    }









    // Only functions available for the use from the external class.
    public function changeType(string $type): self
    {
        $this->changeColumnAttribute("type", $type);
        return $this;
    }

    public function changeLength(int|null $length = null): self
    {
        $this->changeColumnAttribute("length", $length);
        return $this;
    }

    public function dropPrimary(): self
    {
        $this->dropColumnAttribute('primary');
        return $this;
    }

    public function dropUnique(): self
    {
        $this->dropColumnAttribute('unique');
        return $this;
    }

    public function dropAutoIncrement(): self
    {
        $this->dropColumnAttribute('autoIncrement');
        return $this;
    }

    public function dropNotNull(): self
    {
        $this->dropColumnAttribute('notNull');
        return $this;
    }

    public function dropDefault(): self
    {
        $this->dropColumnAttribute('default');
        return $this;
    }

    public function dropAi(): self
    {
        $this->dropAutoIncrement();
        return $this;
    }






    public function build(): string
    {
        // Initialize the query with the table name and return.
        return "CREATE TABLE IF NOT EXISTS ";
        // TODO: Implement the rest of the query.
    }
}