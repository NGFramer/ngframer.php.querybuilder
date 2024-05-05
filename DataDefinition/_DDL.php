<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class _DDL
{
    // Variables to store the table and column data.
    public string $table;
    public static ?array $columns = [];
    public static string $selectedColumn;
    public static array $attributeCounter = ['primary' => 0, 'unique' => 0, 'autoIncrement' => 0];



    // The data definition column functions.
    public static function addColumn(string $columnName): void
    {
        self::$columns[$columnName] = [];
        self::selectColumn($columnName);
    }

    // Clone of the function addColumn.
    public static function addField(string $columnName): void
    {
        self::addColumn($columnName);
    }

    public static function dropColumn(string|null $columnName = null): void
    {

        // If the column name is not set, get the selected column.
        if (!$columnName){
            $columnName = self::getSelectedColumn();
            // If the column name was also not selected, throw an error.
            if (!$columnName) throw new \Exception("No column was selected to drop.");
        }

        // If the column name was set, then process the information.
        // Check if the column exists in the columns array.
        if (self::checkColumnExistence($columnName)) {
            // Check and update the key's of the column.
            foreach(self::$columns[$columnName] as $keyName => $keyValue) {
                if ($keyValue) self::$attributeCounter[$keyName] = self::$attributeCounter[$keyName] - 1;
            }
            // Unset the column from the columns array.
            unset(self::$columns[$columnName]);
        }
        // If the column does not exist, throw an error.
        else throw new \Exception("The column $columnName does not exist in the table.");
    }

    // Clone of the function dropColumn.
    public static function dropField(string|null $columnName = null): void
    {
        self::dropColumn($columnName);
    }




    // The data definition attributes functions.
    // Everything around keys.
    public function key(string $keyName, string|null $columnName = null, int $tableKeyLimit = null ): void
    {
        // Check if the attribute counter has number more than $tableKeyLimit, no more keys allowed, allowed only when the counter is less than $tableKeyLimit.
        // $tableKeyLimit is the number of type of keys allowed in the table. If $tableKeyLimit is null, means no limit.
        // If the table has tableKeyLimit, we will validate if the key is allowed to be added.
        if (!$tableKeyLimit === null){
            if (self::$attributeCounter[$keyName] > $tableKeyLimit) {
                throw new \Exception("Only one $keyName key is allowed per table.");
            }
        }

        // If the column name is not set, get the selected column.
        if (!$columnName){
            $columnName = self::getSelectedColumn();
            // If the column name was also not selected, throw an error.
            if (!$columnName) throw new \Exception("No column was selected to add the $keyName key to.");
        }

        // If the column name was set, process the following.
        if ($columnName) {
            if (self::checkColumnExistence($columnName)){
                self::$columns[$columnName][$keyName] = true;
                self::$attributeCounter[$keyName] = self::$attributeCounter[$keyName] + 1;
            } else {
                // If the column does not exist, throw an error.
                throw new \Exception("The column $columnName does not exist in the table.");
            }
        }
    }

    public function dropKey(string $keyName, string|null $columnName = null): void
    {
        // Check if the attribute counter has the Key set as defined.
        if (self::$attributeCounter[$keyName] == 0) {
            throw new \Exception("No $keyName key exists in the table.");
        }

        // If the column name is not set, get the selected column.
        if (!$columnName){
            $columnName = self::getSelectedColumn();
            // If the column name was also not selected, throw an error.
            if (!$columnName) throw new \Exception("No column was selected to add the $keyName key to.");
        }

        // If the column name was set, or passed, then process the information.
        if (self::checkColumnExistence($columnName)) {
            self::notKey($keyName, $columnName);
        } else {
            throw new \Exception("The column $columnName does not exist in the table.");
        }
    }

    public function notKey(string $keyName, string|null $columnName = null): void
    {
        // If the column name is not set, get the selected column.
        if (!$columnName){
            $columnName = self::getSelectedColumn();
            // If the column name was also not selected, throw an error.
            if (!$columnName) throw new \Exception("No column was selected to add the $keyName key to.");
        }

        // If the column is set or passed, then process the information.
        // Check if the column does not exist in the columns array, throw ane error.
        if (!self::checkColumnExistence($columnName)) {
            throw new \Exception("The column $columnName does not exist in the table.");
        }

        // Prev Cond: If the column exists, then process the information.
        // If key exists in the attribute counter or the array column.
        if (!self::$columns[$columnName][$keyName] || (self::$attributeCounter[$keyName] == 0)) {
            throw new \Exception("The column $columnName was not a $keyName key.");
        }

        // Prev Cond: If the does not exist, then process the information.
        // Main operation, remove the key and update the attribute counter.
        self::$columns[$columnName][$keyName] = false;
        self::$attributeCounter[$keyName] = self::$attributeCounter[$keyName] - 1;
    }

    // Might or might not be used, changing the key from one column to another.
    public function changeKey(string $keyName, string $newKeyColumn): void
    {
        self::dropKey($keyName, $newKeyColumn);
        self::key($keyName, $newKeyColumn);
    }




    // Everything about the primary key.
    public static function primary(string|null $primaryColumn = null): void
    {
        self::key('primary', $primaryColumn, 1);
    }

    // A clone of the addPrimary function.
    public static function addPrimary(string|null $primaryColumn = null): void
    {
        self::primary($primaryColumn);
    }

    public static function dropPrimary(): void
    {
        self::dropKey('primary');
    }

    public static function notPrimary(string $columnName): void
    {
        self::notKey('primary', $columnName);
    }

    public static function changePrimary(string $newPrimaryColumn): void
    {
        self::dropPrimary();
        self::primary($newPrimaryColumn);
    }

    // Everything around unique keys.
    public static function unique(string|null $uniqueColumn = null): void
    {
        self::key('unique', $uniqueColumn, 16);
    }

    // Clone of the function unique.
    public static function addUnique(string|null $uniqueColumn = null): void
    {
        self::unique($uniqueColumn);
    }

        public static function dropUnique($uniqueColumn): void
    {
        self::dropKey('unique', $uniqueColumn);
    }

    public static function notUnique(string|null $columnName = null): void
    {
        self::notKey('unique', $columnName);
    }

    public static function autoIncrement(string|null $aiColumn = null): void
    {
        self::key('autoIncrement', $aiColumn, 1);
    }

    // Clone of the function autoIncrement
    public static function ai(string|null $aiColumn = null): void
    {
        self::autoIncrement($aiColumn);
    }

    // Clone of the function autoIncrement
    public static function addAutoIncrement(string|null $aiColumn = null): void
    {
        self::autoIncrement($aiColumn);
    }

    // Clone of the function autoIncrement
    public static function addAi(string|null $aiColumn = null): void
    {
        self::autoIncrement($aiColumn);
    }

    public static function dropAutoIncrement(string|null $aiColumn = null): void
    {
        self::dropKey('autoIncrement', $aiColumn);
    }

    // Clone of the function dropAutoIncrement
    public static function dropAi(string|null $aiColumn = null): void
    {
        self::dropKey('autoIncrement', $aiColumn);
    }

    // Everything around nullNull key.
    public static function notNull(string|null $notNullColumn = null): void
    {
        self::key('notNull', $notNullColumn);
    }

    // Clone of the function notNull.
    public static function addNotNull(string|null $notNullColumn = null): void
    {
        self::notNull($notNullColumn);
    }

    public static function dropNotNull(string|null $notNullColumn = null): void
    {
        self::dropKey('notNull', $notNullColumn);
    }

    public static function notNotNull(string|null $notNullColumn = null): void
    {
        self::notKey('notNull', $notNullColumn);
    }




    // The supporting data manipulation functions from attributes.
    public static function addAttribute(string $attributeName, string|int|null $attributeValue = null, string|null $columnName = null): void
    {
        // If the attribute is not passed.
        if (!$columnName) {
            // Get the selected column.
            $columnName = self::getSelectedColum();
            // If no columns were selected.
            if (!$columnName) throw new \Exception("No column selected to add $attributeName to.");
        }

        // Check if the column exists or not.
        if (!isset(self::$columns[$columnName])) throw new \Exception("The column $columnName does not exist.");

        // Add the attribute to the column.
        self::$columns[$columnName][$attributeName] = $attributeValue;
    }

    public static function dropAttribute(string $attributeName, string|null $columnName = null): void
    {
        // If the attribute is not passed.
        if (!$columnName) {
            // Get the selected column.
            $columnName = self::getSelectedColum();
            // If no columns were selected.
            if (!$columnName) throw new \Exception("No column selected to drop $attributeName from.");
        }

        // Check if the column exists or not.
        if (!isset(self::$columns[$columnName])) throw new \Exception("The column $columnName does not exist.");

        // Check if the attribute has been set or not.
        if (isset(self::$columns[$columnName][$attributeName])){
            unset(self::$columns[$columnName][$attributeName]);
        }else {
            throw new \Exception("The attribute $attributeName does not exist in the column $columnName.");
        }
    }

    public static function changeAttribute(string $attributeName, string|int $newAttributeValue, string|null $columnName = null): void
    {
        // If the attribute is not passed.
        if (!$columnName) {
            // Get the selected column.
            $columnName = self::getSelectedColum();
            // If no columns were selected.
            if (!$columnName) throw new \Exception("No column selected to change $attributeName to.");
        }

        // Check if the column exists or not.
        if (!isset(self::$columns[$columnName])) throw new \Exception("The column $columnName does not exist.");

        // Check if the attribute has been set or not.
        if (isset(self::$columns[$columnName][$attributeName])){
            self::$columns[$columnName][$attributeName] = $newAttributeValue;
        }else {
            throw new \Exception("The attribute $attributeName does not exist in the column $columnName.");
        }
    }




    // The data manipulation attribute functions.
    public static function type(string $type, string|null $columnName = null): void
    {
        self::addAttribute('type', $type, $columnName);
    }

    public static function addType(string $type, string|null $columnName = null): void
    {
        self::type($type, $columnName);
    }

    public static function length(int $length, string|null $columnName = null): void
    {
        self::addAttribute('length', $length, $columnName);
    }

    public static function addLength(int $length, string|null $columnName = null): void
    {
        self::length($length, $columnName);
    }

    public static function typeLength(string $type, int $length, string|null $columnName = null): void
    {
        self::type($type, $columnName);
        self::length($length, $columnName);
    }

    public static function addTypeLength(string $type, int $length, string|null $columnName = null): void
    {
        self::typeLength($type, $length, $columnName);
    }

    public static function changeType(string $newType, string|null $columnName = null): void
    {
        self::type($newType, $columnName);
        self::dropAttribute('length', $columnName);
    }

    public static function changeLength(int $newLength, string|null $columnName = null): void
    {
        self::length($newLength, $columnName);
    }

    public static function addDefaultLength(string $type, string|null $columnName = null): void
    {
        $length = _Default::getLength($type);
        self::length($length, $columnName);
    }

    public static function changeTypeLength(string $newType, int $newLength, string|null $columnName = null): void
    {
        self::changeType($newType, $columnName);
        self::changeLength($newLength, $columnName);
    }

    public static function default(string|int|null $value, string|null $columnName = null): void
    {
        self::addAttribute('default', $value, $columnName);
    }

    public static function addDefault(string|int|null|array $value, string|null $columnName = null): void
    {
        self::default($value, $columnName);
    }

    public static function dropDefault(string|null $columnName = null): void
    {
        self::dropAttribute('default', $columnName);
    }

    public static function changeDefault(string|int|null|array $value, string|null $columnName = null): void
    {
        self::changeAttribute('default', $value, $columnName);
    }




    // The supporting data definition functions.
    public static function selectColumn(string|null $columnName = null): void
    {
        // If the column name is not set, select the last column as column to be selected.
        if (!$columnName) $columnName = self::getLastColumn();

        // Check for if the selected columnName exists in the columns array.
        if (!self::checkColumnExistence($columnName)) {
            throw new \Exception("The column $columnName does not exist in the table.");
        }
        // Set the selected column to the selected column.
        else self::$selectedColumn = $columnName;
    }

    public static function checkColumnExistence(string $columnName): bool
    {
        return array_key_exists($columnName, self::$columns);
    }

    public static function getLastColumn(): string
    {
        return self::$columns[array_key_last(self::$columns)];
    }

    public static function getSelectedColumn(): string
    {
        return self::$selectedColumn;
    }
}