<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class _DDL
{
    // Variables to store the table and column data.
    public string $table;
    public static ?array $columns = [];
    public static string $selectedColumn;
    public static array $attributeCounter = ['primary' => 0, 'unique' => 0, 'autoIncrement' => 0];




    // The data definition attributes functions.
    // Everything around keys.
    public function key(string $keyName, string|null $columnName = null): void
    {
        // Check if the attribute counter has number more than 0, no more keys allowed, allowed only when the counter is 0.
        if (self::$attributeCounter[$keyName] > 0) {
            throw new \Exception("Only one $keyName key is allowed per table.");
        }

        // If the column name is not set, get the selected column.
        if (!$columnName){
            $columnName = self::getSelectedColumn();
            // If the column name was also not selected, throw an error.
            if (!$columnName) throw new \Exception("No column was selected to add the $keyName key to.");
        }

        // If the column name was not set, throw an error.
        if ($columnName) {
            if (self::checkColumnExistence($columnName)){
                self::$columns[$columnName][$keyName] = true;
                self::$attributeCounter[$keyName] = self::$attributeCounter[$keyName] + 1;
            } else {
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
        self::key('primary', $primaryColumn);
    }

    // A clone of the addPrimary function.
    public static function addPrimary(string|null $primaryColumn = null): void
    {
        self::key('primary', $primaryColumn);
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
        self::key('unique', $uniqueColumn);
    }

    // Clone of the function unique.
    public static function addUnique(string|null $uniqueColumn = null): void
    {
        self::key('unique', $uniqueColumn);
    }

        public static function dropUnique($uniqueColumn): void
    {
        self::dropKey('unique', $uniqueColumn);
    }

    public static function notUnique(string|null $columnName = null): void
    {
        self::notKey('unique', $columnName);
    }

    public static function foreignKey(): void
    {
        // This function will be implemented in the future.
    }

    public static function autoIncrement(string|null $aiColumn = null): void
    {
        self::key('autoIncrement');
    }

    // Clone of the function autoIncrement
    public static function ai(string|null $aiColumn = null): void
    {
        self::key('autoIncrement');
    }

    // Clone of the function autoIncrement
    public static function addAutoIncrement(string|null $aiColumn = null): void
    {
        self::key('autoIncrement');
    }

    // Clone of the function autoIncrement
    public static function addAi(string|null $aiColumn = null): void
    {
        self::key('autoIncrement');
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