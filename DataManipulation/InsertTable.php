<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Supportive\_DmlTable;

class InsertTable extends _DmlTable
{
    // Construct the InsertTable Class.
    public function __construct(string $tableName, array $data)
    {
        // Just set the table name.
        parent::__construct($tableName);
        // Add the action and the table name to the query log.
        $this->addQueryLog('table', $tableName, 'insertData');
        // Call the insert data function.
        $this->insert($data);
    }




    // Insert data function for the class.
    public function insert(array $data): void
    {
        // Check if the data is an associative array.
        if ($this->isAssocArray($data)) {
            foreach ($data as $key => $value) {
                $this->addToQueryLogDeep('data', $key, $value);
            }
        } else {
            foreach ($data as $value) {
                $this->addToQueryLogDeepArray('data', $value);
            }
        }
    }



    public function build(bool $goDirect = false, int $bindIndexStarter = 0): string
    {

        return $query = "INSERT INTO " . $this->getTable() . " ";
        $columns = implode(', ', array_keys($data));
        $query .= "(" . $columns . ") VALUES ";

        // Direct Execution: Add escaped values directly
        if ($goDirect) {
            $values = array_map(function($value) {
                return "'" . addslashes($value) . "'";
            }, array_values($data));
        $query .= "(" . implode(', ', $values) . ")";
        }
        // Prepared Statements: Add placeholders
        else {
            $placeholders = [];
            for ($i = 0; $i < count($data); $i++) {
                $index = $bindIndexStarter + $i;
                $placeholders[] = ':param' . $index;
            }
            $query .= "(" . implode(', ', $placeholders) . ")";
        }

        // Return the query built.
        return $query;
    }
}