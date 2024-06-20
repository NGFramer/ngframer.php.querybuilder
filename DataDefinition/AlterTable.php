<?php

namespace NGFramer\NGFramerPHPSQLServices\DataDefinition;

use NGFramer\NGFramerPHPExceptions\exceptions\SqlBuilderException;
use NGFramer\NGFramerPHPSQLServices\DataDefinition\Supportive\_DdlDefault;
use NGFramer\NGFramerPHPSQLServices\DataDefinition\Supportive\_DdlTableColumn;

class AlterTable extends _DdlTableColumn
{
    // Construct function from parent class.
    // Location: AlterTable => _DdlTableColumn => _DdlTable.
    // __construct($tableName) function.
    public function __construct(string $tableName)
    {
        parent::__construct($tableName);
        // Initialize the query log, add the table name and the action to alterTable.
        $this->addQueryLog('table', $tableName, 'alterTable');
    }


    // Set the action for the table.
    protected function setAction(): void
    {
        parent::setAction("alterTable");
    }


    // Selection function modification from parent.
    public function select(string $columnName): self
    {
        parent::select($columnName);
        return $this;
    }


    // The functions related to modification of columns in a table.
    // Modification means the addition and deletion, of columns.
    public function addColumn($columnName): self
    {
        // Firstly we select the column.
        $this->select($columnName);
        // Make modification to the query log, we have added the table name and table's action previously.
        // We find the index for the column, and add the column, and it's name there.
        // Get the columns count.
        $newColumnIndex = $this->getNewColumnIndex($columnName);
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
        if ($this->getActionOfColumn($columnName) == 'addColumn' or $this->getActionOfColumn($columnName) == 'dropColumn' or $this->getActionOfColumn($columnName) == 'modifyColumn') {
            // If the column is being added, then you can't drop the column being added.
            throw new SqlBuilderException("You cannot drop a column that is being modified in this instance.", 0, null, 500, ['error_type'=>'ddlTable_alter_dropColumnNotAllowed']);
        }

        // Get the columns count.
        // Logic behind this is to get count number of columns, then do -1 as array index starts from 0, and +1 for new Index.
        $newColumnIndex = $this->getNewColumnIndex($columnName);

        // Add the column and action to the query log.
        $this->addToQueryLogDeep('columns', $newColumnIndex, 'action', 'dropColumn');
        $this->addToQueryLogDeep('columns', $newColumnIndex, 'column', $columnName);

        // Return.
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

        // Check if the action of the column is not set, then set it.
        $currentAction = $this->getActionOfColumn($columnName);

        // If the column is being added, then you can add an attribute to the column being added, without any additional action addition to the column.
        if ($currentAction == 'addColumn') {
            parent::addColumnAttribute($attributeName, $attributeValue);
        }

        // If the column is being dropped, then you can't add an attribute to the column being dropped.
        // You can though add attribute before and then drop the column.
        else if ($currentAction == 'dropColumn') throw new SqlBuilderException("You cannot add an attribute to a column that is being dropped.", 0, null, 500, ['error_type'=>'ddlTable_alter_addAttributeToDroppedColumnNotAllowed']);

        // If the column is being modified (has no action for it), we add an action to query log, We haven't added before, only once, we set it.
        else {
            // Check if the action for its validity.
            if (empty($currentAction) or $currentAction == 'alterColumn') $this->changeColumnAttribute($attributeName, $attributeValue);
            // If the action is not recognized, throw an exception.
            else throw new SqlBuilderException("Unrecognized column action: '$currentAction' for column '$columnName'.", 0, null, 500, ['error_type'=>'ddlTable_alter_unrecognizedColumnAction']);
        }
    }


    protected function changeColumnAttribute(string $attributeName, mixed $attributeValue): void
    {
        // Find the name of the column.
        $columnName = $this->getSelectedColumn();

        // Check if the action of the column is not set, then set it.
        $currentAction = $this->getActionOfColumn($columnName);

        // Check if the action of the column is not set, then set it.
        if (($currentAction == 'addColumn' or $currentAction == 'dropColumn')) {
            throw new SqlBuilderException("You cannot change the attribute of a column that is being added or dropped.", 0, null, 500, ['error_type'=>'ddlTable_alter_changeAttributeOfAddedDroppedColumnNotAllowed']);
        } else {
            // Get a new index for the column current column.
            $newColumnIndex = $this->getNewColumnIndex($columnName);
            // First make an action for the table, if not made already.
            $this->addToQueryLogDeep('columns', $newColumnIndex, 'action', 'alterColumn');
            // Make an entry to the newer index.
            $this->addToQueryLogDeep('columns', $newColumnIndex, 'column', $columnName);
            $this->addToQueryLogDeep('columns', $newColumnIndex, $attributeName, $attributeValue);
        }
    }


    protected function dropColumnAttribute(string $attributeName): void
    {
        // Find the name of the column.
        $columnName = $this->getSelectedColumn();

        // Check if the action of the column is not set, then set it.
        $currentAction = $this->getActionOfColumn($columnName);

        // Check if the action of the column is not set, then set it.
        if ($currentAction == 'addColumn' or $currentAction == 'dropColumn') {
            throw new SqlBuilderException("You cannot change the attribute of a column that is being added or dropped.", 0, null, 500, ['error_type'=>'ddlTable_alter_dropAttributeOfAddedDroppedColumnNotAllowed']);
        } else {
            // Check if the action of the column is not set, then set it.
            if (!empty($currentAction)) throw new SqlBuilderException("No attribute has been set for the column. Please set an attribute before proceeding.", 0, null, 500, ['error_type'=>'ddlTable_alter_dropAttributeOfInvalidAction']);

            // Get a new index for the column current column.
            $newColumnIndex = $this->getNewColumnIndex($columnName);
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


    public function buildQuery(): string
    {
        // Get the table name and build query initializer.
        $table = $this->getQueryLog()['table'];
        $query = "ALTER TABLE `$table` ";

        // Get the columns from the query log.
        $columns = $this->getQueryLog()['columns'];
        if (empty($columns)) throw new SqlBuilderException('No column modifications found.', 0, null, 500, ['error_type'=>'ddlTable_alter_noColumnModificationsFoundForQueryGeneration']);

        // Merging the column SQL to the main query.
        $queryToMerge = "";

        // Loop through the columns and build the column query.
        foreach ($columns as $column) {
            // Get the action from the column
            $action = $column['action'] ?? throw new SqlBuilderException("No action found for column $column.", 0, null, 500, ['error_type'=>'ddlTable_alter_noActionFoundForColumn']);

            // Switch to do processes based on the type of action.
            $queryToMerge .= match ($action) {
                'addColumn' => "ADD COLUMN " . $this->buildColumnSql($column) . ", ",
                'dropColumn' => "DROP COLUMN `" . $column['column'] . "`, ",
                'alterColumn' => "MODIFY COLUMN " . $this->buildColumnSql($column) . ", ",
                default => throw new SqlBuilderException("Unknown column action: '$action'.", 0, null, 500, ['error_type'=>'ddlTable_alter_unknownColumnAction']),
            };
        }

        // If the primary key is to be dropped, then drop it.
        if ($this->dropPrimaryAsked) {
            $query .= "DROP PRIMARY KEY, ";
        }

        // Merge the queryToMerge with Query.
        $query .= rtrim($queryToMerge, ', ');

        // Removing the trailing comma and space.
        return rtrim($query, ', ');
    }


    // Only for handling the primary key droppings.
    private bool $dropPrimaryAsked = false;


    private function buildColumnSql(array $columnDefinition): string
    {
        // Get the column name.
        $columnName = $columnDefinition['column'];

        // If the action is to drop the column, then return the column name.
        if ($columnDefinition['action'] === 'dropColumn') {
            return "`$columnName`";
        }

        // Check if the type of the column is set or not.
        if (!isset($columnDefinition['type'])) {
            throw new SqlBuilderException("Column type for '$columnName' is required.", 0, null, 500, ['error_type'=>'ddlTable_alter_columnTypeRequired']);
        }

        // Build the column query using the type and then also add the length.
        $columnSql = "`$columnName` " . $columnDefinition['type'];
        $columnSql .=  isset($columnDefinition['length']) ? '(' . $columnDefinition['length'] . ')' : '(' . _DdlDefault::getLength($columnDefinition['type']) . ')' ;

        // Handle attributes based on their presence or absence
        $columnSql .= isset($columnDefinition['notNull']) ? ($columnDefinition['notNull'] ? ' NOT NULL' : ' NULL') : '';
        $columnSql .= (isset($columnDefinition['unique']) and $columnDefinition['unique']) ? ' UNIQUE' : '';

        // Primary key needs special handling
        if (isset($columnDefinition['primary']) and ($columnDefinition['primary'])) {
                $columnSql .= ' PRIMARY KEY';
        }

        // Auto increment and default values
        $columnSql .= (isset($columnDefinition['autoIncrement']) and $columnDefinition['autoIncrement']) ? ' AUTO_INCREMENT' : '';
        $columnSql .= isset($columnDefinition['default']) ? ' DEFAULT ' . $columnDefinition['default'] : '';

        // Foreign key handling.
        $columnSql .= isset($columnDefinition['foreign']) ? ' FOREIGN KEY (' . $columnName . ') REFERENCES ' . $columnDefinition['foreign']['table'] . '(' . $columnDefinition['foreign']['column'] . ')' : '';

        // Drop Primary key if it is set (to handle this).
        $this->dropPrimaryAsked = true;

        // Return the finalized column query.
        return $columnSql;
    }
}