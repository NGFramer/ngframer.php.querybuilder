<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

use NGFramer\NGFramerPHPSQLBuilder\_Builder;
use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Supportive\_DmlTable;

class UpdateTable extends _DmlTable
{
    // Constructor for the UpdateTable class.
    public function __construct($tableName, $data)
    {
        // Set the table name using parent constructor.
        parent::__construct($tableName);
        // Add the entry to the query log.
        $this->addQueryLog('table', $tableName, 'updateData');
        // Call the update function.
        $this->update($data);
    }




    // Update function for the class.
    public function update(array $data): void
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


    // Builder function for the class.
    public function build(bool $goDirect = false, int $bindIndexStarter = 0): string
    {
        return "";
    }
}