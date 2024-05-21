<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

require_once 'vendor/autoload.php';

header('Content-Type: application/json');


// Insertion Example
// ================>
$query1 = new Query();
$sqlQuery1 = $query1
    ->table('nameOfTable')
    // [An array is a row, and the values are the columns.] [Another array, another row], can be in one functional calling or multiple.
    ->insert(['colName1' => 'colValue', 'colName2' => 'colValue'], ['colName1' => 'colValue', 'colName2' => 2])
    ->insert(['name' => 'Kishor Neupane', 'website' => 'https://neupkishor.com', 'profile' => 'https://github.com/neupkishor'])
    // Go Direct function makes it possible for direct execution without prepared statement.
    -> goDirect()
    // Build function generates the SQL query.
    ->build();


// Select Example
// =============>
$query2 = new Query();
$sqlQuery2 = $query2
    ->table('nameOfTable')
    // All the string are the columns of the table nameOfTable.
    ->select('name', 'website', 'profile')
    // Where clause can be added in the same functional calling or multiple.
    ->where('id', 1)
    ->where('name', 'Kishor Neupane')
    // Go Direct function makes it possible for direct execution without prepared statement.
    -> goDirect()
    // Build function generates the SQL query.
    ->build();


// Update Example
// =============>
$query3 = new Query();
$sqlQuery3 = $query3
    ->table('nameOfTable')
    // [An array is a row, and the values are the columns.] [Another array, another row], can be in one functional calling or multiple.
    ->update(['name' => 'Kishor Neupane', 'website' => 'https://neupkishor.com', 'profile' => 'https://github.com/neupkishor'])
    // Where clause can be added in the same functional calling or multiple.
    ->where('id', 1)
    ->where('name', 'Kishor Neupane')
    // Go Direct function makes it possible for direct execution without prepared statement.
    -> goDirect()
    // Build function generates the SQL query.
    ->build();


// Delete Example
// =============>
$query4 = new Query();
$sqlQuery4 = $query4
    ->table('nameOfTable')
    ->delete()
    // Where clause can be added in the same functional calling or multiple.
    ->where('name', 'Kishor Neupane')
    ->where('id', 1)
    // Go Direct function makes it possible for direct execution without prepared statement.
    -> goDirect()
    // Build function generates the SQL query.
    ->build();


// Insertion Example
// ================>
$query5 = new Query();
$sqlQuery5 = $query5
    ->table('nameOfTable')->create()
    // [An array is a row, and the values are the columns.] [Another array, another row], can be in one functional calling or multiple.
    ->addColumn('id')->typeLength('varchar', 255)->notNull()->primary()
    ->addColumn('name')->typeLength('varchar', 255)->notNull()
    ->addColumn('website')->typeLength('varchar', 255)->notNull()
    ->addColumn('profile')->typeLength('varchar', 255)->notNull()
    // Build function generates the SQL query.
    ->build();